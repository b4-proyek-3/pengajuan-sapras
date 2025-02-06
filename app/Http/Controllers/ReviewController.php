<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Review;
use App\Models\Reviewer;
use App\Models\Ruangan;
use App\Models\Gedung;
use App\Models\Ormawa;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        try {
            $reviewer = auth()->user()->reviewer;
            $id_reviewer = $reviewer->id_reviewer;
            $role = $reviewer->role;
            $diajukanSortStatus = $request->input('diajukan_sort_status');
            $riwayatSortStatus = $request->input('riwayat_sort_status');
            $activeTab = $request->input('active_tab', 'diajukan'); 

            $queryDiajukan = Pengajuan::with(['pengaju.ormawa', 'reviewers'])
            ->where(function ($query) use ($role) {
                if ($role == 'sekum-bem') {
                    $query->where('status', 'diajukan')->orWhere('status', 'diedit');
                } elseif ($role == 'kli') {
                    $query->where(function ($subQuery) {
                        $subQuery->where('status', 'direview')->orWhere('status', 'diedit');
                    })
                    ->whereHas('reviewers', function ($subQuery) {
                        $subQuery->where('role', 'sekum-bem')->where('reviews.status', 'diterima');
                    });
                } elseif ($role == 'wd-3') {
                    $query->where(function ($subQuery) {
                        $subQuery->where('status', 'direview')->orWhere('status', 'diedit'); // Tetap periksa status diedit
                    })
                    ->whereHas('reviewers', function ($subQuery) {
                        $subQuery->where('role', 'kli')->where('reviews.status', 'diterima');
                    });
                }
            })
            ->where(function ($query) use ($id_reviewer) {
                $query->whereDoesntHave('reviewers', function ($subQuery) use ($id_reviewer) {
                    $subQuery->where('reviewers.id_reviewer', $id_reviewer);
                })
                ->orWhereHas('reviewers', function ($subQuery) use ($id_reviewer) {
                    $subQuery->where('reviewers.id_reviewer', $id_reviewer)->where('reviews.status', 'direvisi');
                });
            });

            $queryRiwayat = Pengajuan::with(['pengaju.ormawa', 'reviewers' => function ($query) use ($id_reviewer) {
                    $query->where('reviewers.id_reviewer', $id_reviewer)->withPivot('status');
                }])
                ->whereHas('reviewers', function ($query) use ($id_reviewer) {
                    $query->where('reviewers.id_reviewer', $id_reviewer);
                })
                ->where('status', '!=', 'diedit');
            
            $pengajuanRiwayat = $queryRiwayat
                ->when($request->input('riwayat_sort_status'), function ($query, $status) use ($id_reviewer) {
                    return $query->whereHas('reviewers', function ($subQuery) use ($status, $id_reviewer) {
                        $subQuery->where('reviewers.id_reviewer', $id_reviewer)
                                ->where('reviews.status', $status); 
                    });
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
                
            $pengajuanDiajukan = $queryDiajukan
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

            $tempatList = Ruangan::all();

            return view('reviewer.index', compact('tempatList', 'reviewer', 'pengajuanRiwayat', 'pengajuanDiajukan', 'activeTab'));

        } catch (\Exception $e) {
            \Log::error('Error in ReviewerController@index: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data. Silakan coba lagi nanti.');
        }
    }

    public function detailReviewer($id_pengajuan, $id_reviewer)
    {
        $pengajuan = Pengajuan::with('reviewers', 'latestReview')->findOrFail($id_pengajuan);
        $review = Review::where('id_pengajuan', $id_pengajuan)
                        ->where('id_reviewer', $id_reviewer)
                        ->first();
        $firstDocument = $pengajuan->dokumen->first();

        $hasReviewed = $review ? $review->status != 'diajukan' : false;

        return view('reviewer.detail_reviewer', compact('pengajuan', 'review', 'hasReviewed', 'id_reviewer', 'firstDocument'));
    }

    public function updateReview(Request $request, string $id_pengajuan, string $id_reviewer)
    {
        $request->validate([
            'catatan' => 'string|nullable',
            'status' => 'required|in:diterima,direvisi,ditolak',
        ]);

        $pengajuan = Pengajuan::findOrFail($id_pengajuan);

        try {
            $existingReview = $pengajuan->reviewers()->wherePivot('id_reviewer', $id_reviewer)->first();

            if (!$existingReview) {
                $pengajuan->reviewers()->attach($id_reviewer, [
                    'status' => $request->input('status'),
                    'catatan' => $request->input('catatan'),
                    'tanggal_review' => now(),
                ]);
            } else {
                $pengajuan->update(['edited' => false]);
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
}