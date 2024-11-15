<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Tempat;
use App\Models\Ormawa;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $sortStatus = $request->input('sort_status');
        $search = $request->input('search');

        $query = Pengajuan::with(['pengaju.ormawa']);

        if ($sortStatus) {
            $query->where('status', $sortStatus);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nama_kegiatan', 'like', '%' . $search . '%')
                      ->orWhereHas('pengaju.ormawa', function ($query) use ($search) {
                          $query->where('nama_ormawa', 'like', '%' . $search . '%'); 
                      });
            });
        }

        $pengajuanList = $query->get();
        $ormawaList = Ormawa::all(); 
        $tempatList = Tempat::all(); 

        return view('pengajuan.index', compact('pengajuanList', 'ormawaList', 'tempatList'));
    }

    public function show(string $id_pengajuan)
    {
        $pengajuans = Pengajuan::with(['pengaju', 'reviewers', 'latestReview'])
                            ->findOrFail($id_pengajuan);
        $tempatList = Tempat::all();
        $pengajuans->waktu_pinjam = Carbon::createFromFormat('H:i:s', $pengajuans->waktu_pinjam)->format('H:i');
        return view('pengajuan.detail', compact('pengajuans', 'tempatList'));
    }

    public function create()
    {
        $ormawaList = Ormawa::all(); 
        $tempatList = Tempat::all(); 

        return view('pengajuan.index', compact('ormawaList', 'tempatList'));
        $ormawaList = Ormawa::all(); 
        $tempatList = Tempat::all(); 

        return view('pengajuan.index', compact('ormawaList', 'tempatList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'nullable|exists:pengaju,nim',
            'tanggal_pinjam' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_pinjam',
            'waktu_pinjam' => 'required',
            'id_tempat' => 'required|exists:tempat,id_tempat',
            'nama_kegiatan' => 'required|string|max:100',
            'link_gdrive' => 'nullable|url',
            'dokumen1' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen2' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen3' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen4' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen5' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen6' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen7' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Membuat ID pengajuan unik
        $id_pengajuan = Str::random(6);

        try {
            // Menyimpan data pengajuan
            DB::transaction(function () use ($request, $id_pengajuan) {
                
                Pengajuan::create([
                    'id_pengajuan' => $id_pengajuan,
                    'nim' => $request->nim,
                    'tanggal_pengajuan' => now(),
                    'id_tempat' => $request->id_tempat,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_akhir' => $request->tanggal_akhir,
                    'waktu_pinjam' => $request->waktu_pinjam,
                    'nama_kegiatan' => $request->nama_kegiatan,
                    'link_gdrive' => $request->link_gdrive,
                ]);
    
                // Simpan setiap dokumen yang diunggah
                $this->simpanDokumen($request, $id_pengajuan);
            });
    
            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil ditambahkan!');
    
        } catch (\Exception $e) {
            // Mencatat log error
            dd('Gagal menyimpan pengajuan: ' . $e->getMessage());
        }
    }

    private function simpanDokumen(Request $request, $id_pengajuan)
    {
        \Log::info('Memulai proses penyimpanan dokumen.', ['request' => $request->all(), 'id_pengajuan' => $id_pengajuan]);
    
        $dokumen_fields = [
            'dokumen1' => 'Proposal',
            'dokumen2' => 'Term of Reference',
            'dokumen3' => 'Surat Peminjaman Sarana Prasarana',
            'dokumen4' => 'Surat Pernyataan Berkegiatan',
            'dokumen5' => 'Surat Pernyataan Ketua Ormawa',
            'dokumen6' => 'Surat Pendampingan Pembina',
            'dokumen7' => 'Lampiran Daftar Peserta',
        ];
    
        foreach ($dokumen_fields as $field => $nama_dokumen) {
            try {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('dokumen_pengajuan', $filename, 'public');
    
                    Dokumen::create([
                        'id_pengajuan' => $id_pengajuan,
                        'nama_dokumen' => $nama_dokumen,
                        'path' => $path,
                    ]);
    
                    \Log::info("Dokumen $nama_dokumen berhasil disimpan.", ['id_pengajuan' => $id_pengajuan, 'nama_dokumen' => $nama_dokumen, 'path' => $path]);
    
                } else {
                    \Log::warning("Dokumen $field tidak ada dalam permintaan.");
                }
            } catch (\Exception $e) {
                dd("Gagal menyimpan dokumen $nama_dokumen: " . $e->getMessage());
            }
        }
    }
    
    public function update(Request $request, string $id_pengajuan)
    {
        try {
            $validatedData = $request->validate([
                'tanggal_pinjam' => 'nullable|date',
                'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_pinjam',
                'id_tempat' => 'nullable|exists:tempat,id_tempat',
                'nama_kegiatan' => 'nullable|string',
                'nama_tempat' => 'nullable|string',
                'waktu_pengajuan' => 'nullable|date_format:H:i'
            ]);
    
            $pengajuan = Pengajuan::findOrFail($id_pengajuan);
    
            $updateData = array_filter([
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_akhir' => $request->tanggal_akhir,
                'id_tempat' => $request->filled('id_tempat') ? $request->id_tempat : $pengajuan->id_tempat,
                'nama_kegiatan' => $request->nama_kegiatan,
                'waktu_pengajuan' => $request->waktu_pengajuan
            ], function ($value) {
                return $value !== null;
            });

            $pengajuan->edited = true;
            $pengajuan->update($updateData);
    
            // Update tabel tempat jika nama_tempat disertakan dan id_tempat ada
            if (isset($validatedData['nama_tempat']) && $pengajuan->id_tempat) {
                $tempat = $pengajuan->tempat;
    
                if ($tempat) {
                    $tempat->nama_tempat = $validatedData['nama_tempat'];
                    $tempat->save();
                }
            }
            return redirect()->route('pengaju.show', $pengajuan->id_pengajuan)->with('success', 'Informasi pengajuan berhasil diperbarui.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('pengaju.show', $id_pengajuan)->with('failed', 'Informasi pengajuan tidak berhasil diperbarui.');
        }
    }
}