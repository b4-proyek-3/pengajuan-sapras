<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Tempat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        return view('pengaju.detail', compact('pengajuans'));
    }

    public function show(string $id_pengajuan)
    {
        $pengajuans = Pengajuan::with(['pengaju', 'reviewers', 'latestReview'])
                            ->findOrFail($id_pengajuan);
        $tempatList = Tempat::all();
        $pengajuans->waktu_pengajuan = Carbon::createFromFormat('H:i:s', $pengajuans->waktu_pengajuan)->format('H:i');
        return view('pengaju.detail', compact('pengajuans', 'tempatList'));
    }

    
    public function create()
    {
        return view('pengaju.create');
    }

    public function edit(string $id_pengajuan)
    {
        // Mengambil data pengajuan berdasarkan id
        $pengajuan = Pengajuan::findOrFail($id_pengajuan);
        $tempatList = Tempat::all();

        // Menampilkan view edit_pengajuan dan mengirim data pengajuan ke view
        return view('pengajuan.edit_pengajuan', compact('pengajuan', 'tempatList'));
    }


    public function store(Request $request)
    {
        // Upload dokumen
        if ($request->hasFile('dokumen')) {
            $dokumenPath = $request->file('dokumen')->store('dokumen');
        }

        Pengajuan::create([
            'nim' => $request->nim,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'id_tempat' => $request-> id_tempat,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_akhir' => $request->tanggal_akhir,
            'waktu_pengajuan' => $request->waktu_pengajuan,
            'nama_kegiatan' => $request->nama_kegiatan,
        ]);

        return redirect()->route('pengaju.detail');
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
    
    public function updateDokumen(Request $request, string $id_pengajuan)
    {
        $request->validate([
            'dokumen.*' => 'required|file|mimes:pdf,doc,docx|max:2048', // Ubah sesuai kebutuhan
        ]);

        $pengajuan = Pengajuan::where('id_pengajuan', $id_pengajuan)->firstOrFail();
        
        // Simpan dokumen baru
        foreach ($request->file('dokumen') as $file) {
            $path = $file->store('dokumen');

            $pengajuan->dokumen()->create([
                'nama_dokumen' => $file->getClientOriginalName(),
                'path' => $path,
            ]);
        }

        return redirect()->route('pengaju.show', $pengajuan->id_pengajuan)->with('success', 'Dokumen berhasil diunggah.');
    }

    // Menangani penghapusan dokumen
    public function destroyDokumen(string $id_pengajuan, int $dokumenId)
    {
        $pengajuan = Pengajuan::where('id_pengajuan', $id_pengajuan)->firstOrFail();
        $dokumen = $pengajuan->dokumen()->findOrFail($dokumenId);
        
        // Hapus file dari penyimpanan
        Storage::delete($dokumen->path);
        
        // Hapus dari database
        $dokumen->delete();

        return redirect()->route('pengaju.show', $pengajuan->id_pengajuan)->with('success', 'Dokumen berhasil dihapus.');
    }
}


  