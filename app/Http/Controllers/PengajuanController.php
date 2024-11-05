<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(string $id_pengajuan)
    {
        $pengajuans = Pengajuan::with('pengaju', 'reviewers')->findOrFail($id_pengajuan);
        return view('pages.detail', compact('pengajuans'));
    }

    
    public function create()
    {
        return view('pengajuan.create');
    }

    public function edit(string $id_pengajuan)
    {
        // Mengambil data pengajuan berdasarkan id
        $pengajuan = Pengajuan::findOrFail($id_pengajuan);

        // Menampilkan view edit_pengajuan dan mengirim data pengajuan ke view
        return view('pengajuan.edit_pengajuan', compact('pengajuan'));
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
            'dokumen' => $dokumenPath ?? null,
        ]);

        return redirect()->route('pages.detail');
    }

    public function update(Request $request, string $id_pengajuan)
    {
        try {
            // Validasi data
            $request->validate([
                'nama_kegiatan' => 'required|string|max:255',
                'tanggal_pengajuan' => 'required|date',
                'id_tempat' => 'required|exists:tempat,id_tempat',
                'tanggal_pinjam' => 'required|date',
                'tanggal_akhir' => 'required|date|after_or_equal:tanggal_pinjam',
                'waktu_pengajuan' => 'required',
                'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            ]);

            // Ambil data pengajuan berdasarkan ID
            $pengajuan = Pengajuan::findOrFail($id_pengajuan);

            // Cek jika ada file dokumen yang diunggah
            if ($request->hasFile('dokumen')) {
                $dokumenPath = $request->file('dokumen')->store('dokumen');
                $pengajuan->dokumen = $dokumenPath;
            }

            // Update data
            $pengajuan->nama_kegiatan = $request->nama_kegiatan;
            $pengajuan->tanggal_pengajuan = $request->tanggal_pengajuan;
            $pengajuan->id_tempat = $request->input('id_tempat') ?: null;
            $pengajuan->tanggal_pinjam = $request->tanggal_pinjam;
            $pengajuan->tanggal_akhir = $request->tanggal_akhir;
            $pengajuan->waktu_pengajuan = $request->waktu_pengajuan;
            $pengajuan->save();

            // Redirect atau kembalikan respons
            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangkap dan tampilkan kesalahan menggunakan dd()
            dd($e->getMessage());
        }
    }

}

  