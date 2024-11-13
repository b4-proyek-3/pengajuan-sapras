<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Review;
use App\Models\Reviewer;
use App\Models\Tempat;
use App\Models\Ormawa;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $sortStatus = $request->input('sort_status');
        $search = $request->input('search');

        // Query untuk pengajuan selain yang statusnya "diajukan"
        $queryRiwayat = Pengajuan::with(['pengaju.ormawa'])
            ->where('status', '!=', 'diajukan');

        // Query untuk pengajuan dengan status "diajukan"
        $queryDiajukan = Pengajuan::with(['pengaju.ormawa'])
            ->where('status', 'diajukan');

        if ($sortStatus) {
            $query->where('status', $sortStatus);
        }

        if ($search) {
            $queryRiwayat->where(function ($query) use ($search) {
                $query->where('nama_kegiatan', 'like', '%' . $search . '%')
                      ->orWhereHas('pengaju.ormawa', function ($query) use ($search) {
                          $query->where('nama_ormawa', 'like', '%' . $search . '%');
                      });
            });
    
            $queryDiajukan->where(function ($query) use ($search) {
                $query->where('nama_kegiatan', 'like', '%' . $search . '%')
                      ->orWhereHas('pengaju.ormawa', function ($query) use ($search) {
                          $query->where('nama_ormawa', 'like', '%' . $search . '%');
                      });
            });
        }

        $pengajuanRiwayat = $queryRiwayat->get();
        $pengajuanDiajukan = $queryDiajukan->get();
        $ormawaList = Ormawa::all(); 
        $tempatList = Tempat::all();
        $reviewer = auth()->user()->reviewer;

        return view('reviewer.index', compact('ormawaList', 'tempatList', 'reviewer', 'pengajuanRiwayat', 'pengajuanDiajukan'));
    }

    public function detailReviewer($id_pengajuan, $id_reviewer)
    {
        // Mendapatkan detail pengajuan
        $pengajuan = Pengajuan::with('reviewers', 'latestReview')->findOrFail($id_pengajuan);

        // Mendapatkan detail review berdasarkan reviewer
        $review = Review::where('id_pengajuan', $id_pengajuan)
                        ->where('id_reviewer', $id_reviewer)
                        ->first();

        // Mengecek apakah reviewer sebelumnya sudah memberikan review
        if (!$this->canReview($id_pengajuan, $id_reviewer)) {
            // Jika reviewer sebelumnya belum mereview, kembalikan error atau redirect
            return redirect()->route('reviewer.index')->with('error', 'Anda belum bisa mereview pengajuan ini.');
        }

        // Mengecek apakah reviewer sudah memberikan review
        $hasReviewed = $review ? $review->status != 'diajukan' : false;

        return view('reviewer.detail_reviewer', compact('pengajuan', 'review', 'hasReviewed', 'id_reviewer'));
    }

    public function updateReview(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'catatan' => 'string',
        ]);
        // Masukkan hasil review ke tabel hasil_review
        HasilReview::create([
            'id_pengajuan' => $pengajuan->id,
            'id_reviewer' => auth()->user()->id,
            'catatan' => $request->catatan,
            'tanggal_review' => now(),
        ]);

        // Status dan histori akan otomatis terupdate melalui trigger
        return response()->json(['message' => 'Review updated, next reviewer assigned automatically.']);
    }

    // Mengecek apakah reviewer sebelumnya sudah mereview sebelum reviewer saat ini
    private function canReview($id_pengajuan, $id_reviewer)
    {
        // Mendapatkan daftar reviewer dalam urutan
        $allReviewers = Reviewer::orderedByRole()->get();
        $currentReviewer = Reviewer::find($id_reviewer);
    
        // Mendapatkan reviewer sebelumnya
        foreach ($allReviewers as $reviewer) {
            if ($reviewer->role < $currentReviewer->role) {
                $previousReviewer = $reviewer;
            } else {
                break;
            }
        }
    
        // Jika tidak ada reviewer sebelumnya (artinya reviewer pertama)
        if (!isset($previousReviewer)) {
            return true;
        }
    
        // Mengecek apakah reviewer sebelumnya sudah menyelesaikan review
        $previousReview = Review::where('id_pengajuan', $id_pengajuan)
                                ->where('id_reviewer', $previousReviewer->id_reviewer)
                                ->first();
    
        // Reviewer saat ini hanya bisa mereview jika reviewer sebelumnya sudah menyelesaikan
        return $previousReview && $previousReview->status == 'diterima';
    }
    

    // Mengecek apakah reviewer ini adalah reviewer terakhir
    private function isLastReviewer($pengajuan, $id_reviewer)
    {
        // Mendapatkan semua reviewer berdasarkan urutan role
        $allReviewers = Reviewer::orderedByRole()->get();
        $currentReviewer = Reviewer::find($id_reviewer);

        // Mengecek apakah ada reviewer berikutnya
        $nextReviewer = $allReviewers->first(function ($reviewer) use ($currentReviewer) {
            return $reviewer->role > $currentReviewer->role;
        });

        return !$nextReviewer;
    }

    // Mendapatkan reviewer berikutnya setelah reviewer saat ini
    private function getNextReviewer($pengajuan, $id_reviewer)
    {
        // Mendapatkan semua reviewer berdasarkan urutan role
        $allReviewers = Reviewer::orderedByRole()->get();
        $currentReviewer = Reviewer::find($id_reviewer);
    
        // Mendapatkan reviewer berikutnya
        foreach ($allReviewers as $reviewer) {
            if ($reviewer->role > $currentReviewer->role) {
                return $reviewer;
            }
        }
    
        return null;
    }    
}
