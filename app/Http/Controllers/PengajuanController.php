<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Tempat;
use App\Models\Ormawa;
use App\Models\Dokumen;
use App\Models\Pengaju;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $pengaju = auth()->user()->pengaju;
        $search = $request->input('search');
        $sortStatus = $request->input('sort_status');
    
        // Query awal dengan filtering berdasarkan nim pengaju
        $query = Pengajuan::with(['pengaju.ormawa', 'latestReview'])->where('nim', $pengaju->nim);
    
        // Filter berdasarkan status
        if ($sortStatus) {
            $query->where('status', $sortStatus);
        }
    
        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nama_kegiatan', 'like', '%' . $search . '%')
                      ->orWhereHas('pengaju.ormawa', function ($query) use ($search) {
                          $query->where('nama_ormawa', 'like', '%' . $search . '%');
                      });
            });
        }
    
        $pengajuanDiajukan = Pengajuan::where('status', 'diajukan')
        ->when($request->input('search'), function ($query, $search) {
            return $query->where('nama_kegiatan', 'like', "%$search%");
        })
        ->paginate(10, ['*'], 'diajukan_page');

    
        $pengajuanRiwayat = Pengajuan::whereIn('status', ['diterima', 'ditolak'])
        ->when($request->input('status_filter'), function ($query, $status) {
            return $query->where('status', $status);
        })
        ->when($request->input('search'), function ($query, $search) {
            return $query->where('nama_kegiatan', 'like', "%$search%");
        })
        ->paginate(10, ['*'], 'riwayat_page'); 
        
        $tempatList = Tempat::all();
    
        return view('pengajuan.index', compact('pengajuanDiajukan', 'pengajuanRiwayat', 'tempatList'));
    }
    
        
    public function show(string $id_pengajuan)
    {
        $pengajuans = Pengajuan::with(['pengaju', 'reviewers', 'latestReview', 'dokumen'])
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
    }

    public function store(Request $request)
    {
        $user = Auth::user(); 
        $pengaju = $user->pengaju;

        $existingCount = Pengajuan::count();

        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_pinjam',
            'waktu_pinjam' => 'required',
            'id_tempat' => 'required|exists:tempat,id_tempat',
            'nama_kegiatan' => 'required|string|max:100',
            'link_gdrive' => 'nullable|url',
            'activity_type' => 'required|string|in:proker,pergerakan',
            
            'dokumen1' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen2' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen3' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen4' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen5' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen6' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen7' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Membuat ID pengajuan unik
        $id_pengajuan = 'P' . str_pad($existingCount + 1, 5, '0', STR_PAD_LEFT);

        // Menyimpan data pengajuan
        $pengajuan = Pengajuan::create([
            'id_pengajuan' => $id_pengajuan,
            'nim' => $pengaju->nim,
            'tanggal_pengajuan' => now(),
            'id_tempat' => $request->id_tempat,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_akhir' => $request->tanggal_akhir,
            'waktu_pinjam' => $request->waktu_pinjam,
            'nama_kegiatan' => $request->nama_kegiatan,
            'jenis_kegiatan' => $request->activity_type,
            'link_drive' => $request->link_gdrive,
            'updated_at' => now(),
         ]);

        // Simpan setiap dokumen yang diunggah
        $this->simpanDokumen($request, $id_pengajuan);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil ditambahkan!');
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
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('dokumen/' . $id_pengajuan, $filename, 'public');

                Dokumen::create([
                    'id_pengajuan' => $id_pengajuan,
                    'nama_dokumen' => $nama_dokumen,
                    'path' => $path,
                ]);

                \Log::info("Dokumen $nama_dokumen berhasil disimpan.", ['id_pengajuan' => $id_pengajuan, 'nama_dokumen' => $nama_dokumen, 'path' => $path]);

            } else {
                \Log::warning("Dokumen $field tidak ada dalam permintaan.");
                
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
                'waktu_pengajuan' => 'nullable|date_format:H:i',
            ]);
    
            $pengajuan = Pengajuan::findOrFail($id_pengajuan);
    
            $updateData = array_filter([
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_akhir' => $request->tanggal_akhir,
                'id_tempat' => $request->filled('id_tempat') ? $request->id_tempat : $pengajuan->id_tempat,
                'nama_kegiatan' => $request->nama_kegiatan,
                'waktu_pinjam' => $request->waktu_pengajuan,
            ], function ($value) {
                return $value !== null;
            });

            $pengajuan->edited = true;
            $pengajuan->update($updateData);
    
            // Update tabel tempat jika nama_tempat disertakan dan id_tempat ada
            if (isset($validatedData['nama_tempat']) && $pengajuan->id_tempat) {
                $tempat = $pengajuan->tempat;
    
                if ($tempat) {
                    $tempat->nama_gedung = $validatedData['nama_tempat'];
                    $tempat->save();
                }
            }
            return redirect()->route('pengajuan.show', $pengajuan->id_pengajuan)->with('success', 'Informasi pengajuan berhasil diperbarui.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('pengajuan.show', $id_pengajuan)->with('failed', 'Informasi pengajuan tidak berhasil diperbarui.');
        }
    }

    public function simpan_dokumen(Request $request, $id_pengajuan) {
        // Decode dokumen dihapus
        $dokumenDihapus = json_decode($request->dokumenDihapus, true);
        foreach ($dokumenDihapus as $dokumen) {
            Dokumen::where('no_dokumen', $dokumen['id'])->delete();
        }
    
        // Simpan dokumen baru atau update dokumen
        foreach ($request->file('dokumenBaru') as $index => $file) {
            $namaDokumen = $request->input("dokumenNama.$index");
            $path = $file->store('dokumen');
    
            Dokumen::updateOrCreate(
                ['id_pengajuan' => $id_pengajuan, 'nama_dokumen' => $namaDokumen],
                ['path' => $path]
            );
        }
    
        return response()->json(['success' => true, 'message' => 'Dokumen berhasil disimpan.']);
    }    

    public function submitPengajuan(Request $request, $id_pengajuan)
    {
        // Validasi status yang diterima
        $request->validate([
            'status' => 'required|string',
        ]);

        // Cari pengajuan berdasarkan ID
        $pengajuan = Pengajuan::find($id_pengajuan);

        // Pastikan pengajuan ditemukan
        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Pengajuan tidak ditemukan');
        }

        // Update kolom 'edited' dan 'status'
        $pengajuan->edited = false;
        $pengajuan->status = 'diedit';

        // Simpan perubahan ke database
        $pengajuan->save();

        // Kembali ke halaman pengajuan dengan pesan sukses
        return redirect()->route('pengajuan.show', $id_pengajuan)
                        ->with('success', 'Pengajuan berhasil disubmit');
    }

}
