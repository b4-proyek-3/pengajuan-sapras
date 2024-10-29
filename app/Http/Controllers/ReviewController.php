<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show()
    {
        return view('pengajuan.index', compact('index'));
    }

    public function storeReview(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'id_reviewer' => 'required|exists:reviewers,id',
            'status' => 'required|in:diterima,direvisi',
            'hasil' => 'required|string',
        ]);

        $pengajuan->reviewers()->attach($request->reviewer_id, [
            'status' => $request->status,
            'hasil' => $request->hasil_review,
            'tanggal_review' => now(),
        ]);

        return redirect()->back()->with('success', 'Review berhasil disimpan!');
    }
}
