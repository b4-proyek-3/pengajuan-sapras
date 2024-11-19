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
        $reviewer = auth()->user()->reviewer;
        $id_reviewer = $reviewer->id_reviewer;
        $role = $reviewer->role;

        $queryDiajukan = Pengajuan::with(['pengaju.ormawa', 'reviewers'])
            ->where(function ($query) use ($role) {
                if ($role == 'sekum-bem') {
                    // Sekum BEM hanya melihat pengajuan dengan status 'diajukan'
                    $query->where('status', 'diajukan');
                } else {
                    $query->where('status', 'direview')
                        ->whereHas('reviewers', function ($query) use ($role) {
                            if ($role == 'kli') {
                                $query->where('role', 'sekum-bem')->where('reviews.status', 'diterima');
                            } elseif ($role == 'wd-3') {
                                $query->where('role', 'kli')->where('reviews.status', 'diterima');
                            }
                        });
                    }
            })
            ->whereDoesntHave('reviewers', function ($query) use ($id_reviewer) {
                $query->where('reviewers.id_reviewer', $id_reviewer); // Belum direview oleh reviewer ini
            })
            ->get();

        $queryRiwayat = Pengajuan::with(['pengaju.ormawa', 'reviewers' => function ($query) use ($id_reviewer) {
                $query->where('reviewers.id_reviewer', $id_reviewer); // Sudah direview oleh reviewer ini
            }])
            ->whereHas('reviewers', function ($query) use ($id_reviewer) {
                $query->where('reviewers.id_reviewer', $id_reviewer); // Sudah direview oleh reviewer ini
            })
            ->get();

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

        $pengajuanRiwayat = $queryRiwayat;
        $pengajuanDiajukan = $queryDiajukan;
        $tempatList = Tempat::all();

        return view('reviewer.index', compact('tempatList', 'reviewer', 'pengajuanRiwayat', 'pengajuanDiajukan'));
    }

    public function detailReviewer($id_pengajuan, $id_reviewer)
    {
        $pengajuan = Pengajuan::with('reviewers', 'latestReview')->findOrFail($id_pengajuan);
        $review = Review::where('id_pengajuan', $id_pengajuan)
                        ->where('id_reviewer', $id_reviewer)
                        ->first();

        if (!$this->canReview($id_pengajuan, $id_reviewer)) {
            return redirect()->route('reviewer.index')->with('error', 'Anda belum bisa mereview pengajuan ini.');
        }

        $hasReviewed = $review ? $review->status != 'diajukan' : false;

        return view('reviewer.detail_reviewer', compact('pengajuan', 'review', 'hasReviewed', 'id_reviewer'));
    }


    public function updateReview(Request $request, string $id_pengajuan, string $id_reviewer)
    {
        $request->validate([
            'catatan' => 'string|nullable',
            'status' => 'required|in:diterima,direvisi,ditolak',
        ]);

        $pengajuan = Pengajuan::findOrFail($id_pengajuan);
        $reviewer = Reviewer::findOrFail($id_reviewer);

        try {
            $existingReview = $pengajuan->reviewers()->wherePivot('id_reviewer', $id_reviewer)->first();

            if (!$existingReview) {
                $pengajuan->reviewers()->attach($id_reviewer, [
                    'status' => $request->input('status'),
                    'catatan' => $request->input('catatan'),
                    'tanggal_review' => now(),
                ]);
            } else {
                $pengajuan->reviewers()->updateExistingPivot($id_reviewer, [
                    'status' => $request->input('status'),
                    'catatan' => $request->input('catatan'),
                    'tanggal_review' => now(),
                ]);
            }

            return redirect()->route('reviewer.detail_reviewer', ['id_pengajuan' => $id_pengajuan, 'id_reviewer' => $id_reviewer])
                            ->with('success', 'Review berhasil disimpan');

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update review: ' . $e->getMessage()], 500);
        }
    }

    private function canReview($id_pengajuan, $id_reviewer)
    {
        $pengajuan = Pengajuan::find($id_pengajuan);
        $currentReviewer = Reviewer::find($id_reviewer);
        
        if ($pengajuan->status == 'diajukan') {
            return $currentReviewer->role == 'sekum-bem';
        }

        if ($pengajuan->status == 'direview' || $pengajuan->status == 'direvisi') {
            $previousReview = Review::where('id_pengajuan', $id_pengajuan)
                                    ->where('id_reviewer', $this->getPreviousReviewerId($currentReviewer->role))
                                    ->first();
            if (!$previousReview || $previousReview->status != 'diterima') {
                return false; 
            }
        }

        $review = Review::where('id_pengajuan', $id_pengajuan)
                        ->where('id_reviewer', $id_reviewer)
                        ->first();
        
        if ($review && $review->status != 'diajukan') {
            return false; 
        }

        return true; 
    }

    private function getPreviousReviewerId($currentRole)
    {
        if ($currentRole == 'kli') {
            return Reviewer::where('role', 'sekum-bem')->first()->id_reviewer;
        } elseif ($currentRole == 'wd-3') {
            return Reviewer::where('role', 'kli')->first()->id_reviewer;
        }
        return null;
    }

}
