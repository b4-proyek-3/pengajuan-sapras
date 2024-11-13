<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Pengaju;
use App\Models\Pengajuan;
use App\Models\Ormawa;
use App\Models\Tempat;
use App\Models\Dokumen;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $sortStatus = $request->input('sort_status');
        $search = $request->input('search');  
        $statusFilter = $request->input('status_filter');  
        
        $query = Pengajuan::query();
        
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        
        if ($sortStatus && in_array(strtolower($sortStatus), ['asc', 'desc'])) {
            $query->orderBy('status', strtolower($sortStatus)); 
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_kegiatan', 'like', '%' . $search . '%')
                  ->orWhereHas('ormawa', function($q) use ($search) {
                      $q->where('nama_ormawa', 'like', '%' . $search . '%');
                  });
            });
        }

        $pengajuanList = $query->with('ormawa')->get();
        $ormawaList = Ormawa::all(); 
        $tempatList = Tempat::all(); 
    
        return view('pengajuan.index', compact('pengajuanList', 'ormawaList', 'tempatList'));
    }    
    
    public function show(string $id_pengajuan)
    {
        $pengajuans = Pengajuan::with('pengaju', 'reviewers')->findOrFail($id_pengajuan);
        return view('pengajuan.detail', compact('pengajuans'));
    }

    public function create()
    {
        $ormawaList = Ormawa::all(); 
        $tempatList = Tempat::all(); 

        return view('pengajuan.index', compact('ormawaList', 'tempatList'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'tanggal_pinjam' => 'required|date',
                'tanggal_akhir' => 'required|date',
                'waktu_pengajuan' => 'required|date_format:H:i',
                'id_tempat' => 'required|exists:tempat,id_tempat',
                'nama_kegiatan' => 'required|string',
                'activity_type' => 'required|in:program_kerja,pergerakan',
                'link_gdrive' => 'nullable|url',
                'dokumen1' => 'nullable|file|mimes:pdf',
                'dokumen2' => 'nullable|file|mimes:pdf',
                'dokumen3' => 'nullable|file|mimes:pdf',
                'dokumen4' => 'nullable|file|mimes:pdf',
                'dokumen5' => 'nullable|file|mimes:pdf',
                'dokumen6' => 'nullable|file|mimes:pdf',
                'dokumen7' => 'nullable|file|mimes:pdf',
            ]);

            $id_pengajuan = strtoupper(Str::random(6));

            $id_ormawa = auth()->user()->id_ormawa;

            // Menyimpan data pengajuan
            $pengajuan = Pengajuan::create([
                'id_pengajuan' => $id_pengajuan,
                'id_ormawa' => $id_ormawa,
                'nim' => auth()->user()->nim,
                'tanggal_pengajuan' => now(),
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_akhir' => $request->tanggal_akhir,
                'waktu_pengajuan' => $request->waktu_pengajuan,
                'id_tempat' => $request->id_tempat,
                'nama_kegiatan' => $request->nama_kegiatan,
                'jenis_kegiatan' => $request->activity_type == 'program_kerja' ? 'proker' : 'pergerakan',
                'link_gdrive' => $request->link_gdrive,
            ]);

            // Menyimpan dokumen sesuai jenis kegiatan
            $dokumenFiles = [
                'dokumen1' => $request->file('dokumen1'), // Proposal untuk Program Kerja
                'dokumen2' => $request->file('dokumen2'), // Term of Reference untuk Pergerakan
                'dokumen3' => $request->file('dokumen3'), // Surat Peminjaman Sarana Prasarana
                'dokumen4' => $request->file('dokumen4'), // Surat Izin Berkegiatan
                'dokumen5' => $request->file('dokumen5'), // Surat Pernyataan Ketua Ormawa
                'dokumen6' => $request->file('dokumen6'), // Surat Pendampingan Pembina
                'dokumen7' => $request->file('dokumen7'), // Lampiran Daftar Peserta
            ];

            foreach ($dokumenFiles as $key => $file) {
                if ($file) {
                    // Generate nama file unik dan path penyimpanan
                    $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $path = 'dokumen/' . $pengajuan->jenis_kegiatan . '/' . $fileName;
                    
                    // Simpan file ke storage
                    Storage::put($path, file_get_contents($file));

                    // Simpan data dokumen ke database
                    Dokumen::create([
                        'no_dokumen' => strtoupper(Str::random(6)), // Generate ID dokumen unik
                        'id_pengajuan' => $pengajuan->id_pengajuan,
                        'nama_dokumen' => $key,
                        'path' => $path,
                    ]);
                }
            }

            return response()->json(['message' => 'Pengajuan dan dokumen berhasil disimpan'], 201);

        } catch (\Exception $e) {
            // Hapus file yang sudah diunggah jika terjadi error
            if (isset($pengajuan)) {
                foreach ($dokumenFiles as $key => $file) {
                    if ($file && Storage::exists($path)) {
                        Storage::delete($path);
                    }
                }
            }
            
            // Tangani error dan kirim respons gagal
            return response()->json(['error' => 'Gagal menyimpan pengajuan: ' . $e->getMessage()], 500);
        }
    }
}    