<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Review;
use App\Models\Reviewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function detailReviewer(string $id_pengajuan)
    {
        $pengajuan = Pengajuan::with(['pengaju', 'tempat', 'reviewers' => function($query) {
            $query->select('reviewers.id_reviewer', 'nama', 'reviews.status', 'reviews.review', 'reviews.tanggal_review')
                  ->withPivot('status', 'review', 'tanggal_review');
        }])->findOrFail($id_pengajuan);
    
        return view('reviewer.detail_reviewer', compact('pengajuan'));
    }

    public function reviewPengajuan(Request $request, string $id_pengajuan)
    {
        $pengajuan = Pengajuan::findOrFail($id_pengajuan);
        $reviewerId = Reviewer::where('id_role', 1)->first()->id_reviewer;
        $catatan = $request->input('catatan');

        if ($request->input('action') === 'terima') {;

            // Menyimpan data review di tabel reviews
            Review::create([
                'id_pengajuan' => $id_pengajuan,
                'id_reviewer' => $reviewerId,
                'status' => 'diterima',
                'review' => null,
                'tanggal_review' => now(),
            ]);

            return redirect()->back()->with('success', 'Pengajuan berhasil diterima.');

        } elseif ($request->input('action') === 'tolak') {
            $status = $catatan ? 'direvisi' : 'ditolak';

            // Menyimpan data review di tabel reviews
            Review::create([
                'id_pengajuan' => $id_pengajuan,
                'id_reviewer' => $reviewerId,
                'status' => $status,
                'review' => $catatan,
                'tanggal_review' => now(),
            ]);
            return redirect()->back()->with('success', 'Pengajuan berhasil ditolak dengan catatan.');
        }
        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }
}
