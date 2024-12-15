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
        $reviewer = auth()->user()->reviewer;
        $id_reviewer = $reviewer->id_reviewer;
        $role = $reviewer->role;
        $diajukanSortStatus = $request->input('diajukan_sort_status');
        $riwayatSortStatus = $request->input('riwayat_sort_status');
        $activeTab = $request->input('active_tab', 'diajukan'); 

        $query = Pengajuan::with(['pengaju.ormawa', 'reviewers']);

        $query->where(function ($query) use ($role, $id_reviewer) {
            if ($role == 'sekum-bem') {
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
        });

        $query->whereDoesntHave('reviewers', function ($query) use ($id_reviewer) {
            $query->where('reviewers.id_reviewer', $id_reviewer);
        });

        $pengajuanDiajukan = Pengajuan::whereIn('status', ['diajukan', 'direvisi'])
            ->when($request->input('diajukan_sort_status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->input('search'), function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_kegiatan', 'like', "%{$search}%")
                      ->orWhereHas('pengaju.ormawa', function($subQuery) use ($search) {
                          $subQuery->where('nama_ormawa', 'like', "%{$search}%");
                      });
                });
            })
            ->paginate(10, ['*'], 'diajukan_page');
    
        $pengajuanRiwayat = Pengajuan::whereIn('status', ['diterima', 'ditolak'])
            ->when($request->input('riwayat_sort_status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->input('riwayat_search'), function ($query, $search) { 
                return $query->where(function($q) use ($search) {
                    $q->where('nama_kegiatan', 'like', "%{$search}%")
                      ->orWhereHas('pengaju.ormawa', function($subQuery) use ($search) {
                          $subQuery->where('nama_ormawa', 'like', "%{$search}%");
                      });
                });
            })
            ->paginate(10, ['*'], 'riwayat_page');

        $queryRiwayat = Pengajuan::with(['pengaju.ormawa', 'reviewers' => function ($query) use ($id_reviewer) {
            $query->where('reviewers.id_reviewer', $id_reviewer)->withPivot('status');
        }])
        ->whereHas('reviewers', function ($query) use ($id_reviewer) {
            $query->where('reviewers.id_reviewer', $id_reviewer)
                  ->whereIn('reviews.status', ['diterima', 'ditolak']);
        })->get();

        $tempatList = Tempat::all();

        return view('reviewer.index', compact('tempatList', 'reviewer', 'pengajuanRiwayat', 'pengajuanDiajukan', 'activeTab'));
    }

    public function detailReviewer($id_pengajuan, $id_reviewer)
    {
        $pengajuan = Pengajuan::with('reviewers', 'latestReview')->findOrFail($id_pengajuan);
        $review = Review::where('id_pengajuan', $id_pengajuan)
                        ->where('id_reviewer', $id_reviewer)
                        ->first();

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