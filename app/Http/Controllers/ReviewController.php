<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Review;
use App\Models\Reviewer;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    // Menampilkan detail pengajuan untuk reviewer tertentu
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
            return redirect()->route('home')->with('error', 'Anda belum bisa mereview pengajuan ini.');
        }

        // Mengecek apakah reviewer sudah memberikan review
        $hasReviewed = $review ? $review->status != 'diajukan' : false;

        return view('reviewer.detail_reviewer', compact('pengajuan', 'review', 'hasReviewed', 'id_reviewer'));
    }

    // Menyimpan review yang dilakukan oleh reviewer tertentu
    public function storeReview(Request $request, string $id_pengajuan, string $id_reviewer)
    {
        // Validasi input dari form
        $request->validate([
            'review' => 'string',
            'status' => 'required|in:diterima,direvisi,ditolak,selesai',
        ]);

        // Mendapatkan pengajuan
        $pengajuan = Pengajuan::findOrFail($id_pengajuan);

        // Mendapatkan waktu saat ini
        $currentDateTime = now();

        // Simpan atau update review
        $review = Review::updateOrCreate(
            ['id_pengajuan' => $id_pengajuan, 'id_reviewer' => $id_reviewer],
            [
                'review' => $request->input('review'),
                'status' => $request->input('status'),
                'tanggal_review' => $currentDateTime,
            ]
        );

        // Update status pengajuan berdasarkan hasil review
        if ($request->input('status') == 'ditolak') {
            $pengajuan->status = 'ditolak';
        } elseif ($request->input('status') == 'direvisi') {
            $pengajuan->status = 'direvisi';
        } elseif ($request->input('status') == 'diterima') {
            if ($this->isLastReviewer($pengajuan, $id_reviewer)) {
                $pengajuan->status = 'selesai';
            } else {
                $pengajuan->status = 'diterima';
                
                // Debugging next reviewer
                $nextReviewer = $this->getNextReviewer($pengajuan, $id_reviewer);
                //dd(['Next reviewer' => $nextReviewer]);

                if ($nextReviewer) {
                    Review::create([
                        'id_pengajuan' => $id_pengajuan,
                        'id_reviewer' => $nextReviewer->id_reviewer,
                        'status' => 'diajukan',
                        'tanggal_review' => $currentDateTime,
                    ]);
                }
            }
        }

        // Simpan status pengajuan
        $pengajuan->save();
        //dd(['Pengajuan status' => $pengajuan->status]);

        // Debugging hasil akhir
        /*dd([
            'Redirecting to detail reviewer with' => [
                'id_pengajuan' => $id_pengajuan,
                'id_reviewer' => $id_reviewer,
                'success_message' => 'Review berhasil disimpan'
            ]
        ]);*/

        // Redirect kembali ke halaman detail reviewer
        return redirect()->route('reviewer.detail_reviewer', ['id_pengajuan' => $id_pengajuan, 'id_reviewer' => $id_reviewer])
                         ->with('success', 'Review berhasil disimpan');
    }

    // Mengecek apakah reviewer sebelumnya sudah mereview sebelum reviewer saat ini
    private function canReview($id_pengajuan, $id_reviewer)
    {
        // Mendapatkan daftar reviewer dalam urutan
        $allReviewers = Reviewer::orderBy('id_role')->get();
        $currentReviewer = Reviewer::find($id_reviewer);
    
        // Mendapatkan reviewer sebelumnya
        foreach ($allReviewers as $reviewer) {
            if ($reviewer->id_role < $currentReviewer->id_role) {
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
        $allReviewers = Reviewer::orderBy('id_role')->get();
        $currentReviewer = Reviewer::find($id_reviewer);

        // Mengecek apakah ada reviewer berikutnya
        $nextReviewer = $allReviewers->first(function ($reviewer) use ($currentReviewer) {
            return $reviewer->id_role > $currentReviewer->id_role;
        });

        return !$nextReviewer;
    }

    // Mendapatkan reviewer berikutnya setelah reviewer saat ini
    private function getNextReviewer($pengajuan, $id_reviewer)
    {
        // Mendapatkan semua reviewer berdasarkan urutan role
        $allReviewers = Reviewer::orderBy('id_role')->get();
        $currentReviewer = Reviewer::find($id_reviewer);
    
        // Mendapatkan reviewer berikutnya
        foreach ($allReviewers as $reviewer) {
            if ($reviewer->id_role > $currentReviewer->id_role) {
                return $reviewer;
            }
        }
    
        return null;
    }    
}
