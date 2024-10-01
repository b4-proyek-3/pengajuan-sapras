<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with('pengaju', 'reviewers')->get();
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
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_akhir' => $request->tanggal_akhir,
            'waktu_pengajuan' => $request->waktu_pengajuan,
            'nama_kegiatan' => $request->nama_kegiatan,
            'dokumen' => $dokumenPath ?? null,
        ]);

        return redirect()->route('pages.detail');
    }
}
