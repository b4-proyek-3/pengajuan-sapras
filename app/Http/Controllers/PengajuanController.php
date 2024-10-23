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
}
