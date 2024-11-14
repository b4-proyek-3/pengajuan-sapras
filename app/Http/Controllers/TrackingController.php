<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Reviewer;
use App\Models\Pengajuan;
use App\Models\Pengaju;
use App\Models\Ormawa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrackingController extends Controller
{
    private $stepIcons = [
        'Pengajuan dibuat' => 'pencil',
        'Review Sekretaris BEM' => 'user-magnifying-glass',
        'Review KLI' => 'file-check',
        'Review Wadir 3' => 'user',
        'Diterima' => 'check-circle'
    ];

    public function show(string $id_pengajuan)
    {
        $pengajuan = Pengajuan::findOrFail($id_pengajuan);
        $reviews = Review::with(['reviewer.role'])
            ->where('id_pengajuan', $id_pengajuan)
            ->orderBy('tanggal_review', 'asc')
            ->get();

        $pengaju = Pengaju::where('nim', $pengajuan->nim)->first();
        $ormawa = Ormawa::find($pengaju->id_ormawa);

        $highestLevel = $reviews->map(function($review) {
            return $this->getReviewerLevel($review->reviewer->role->nama_role);
        })->max();

        $isAccepted = $reviews->where('status', 'diterima')->isNotEmpty();
        if ($isAccepted) {
            $highestLevel = 3;
        }

        $reviewDates = $this->getReviewDates($reviews);
        $stepStatus = $this->getStepStatus($reviews, $highestLevel);
        $statusHistory = $this->getStatusHistory($reviews);
        $progressStatus = $this->calculateProgress($reviews, $highestLevel);

        return view('progress2', compact('pengajuan', 'reviews', 'statusHistory', 'progressStatus', 'ormawa', 'reviewDates', 'stepStatus'))->with([
            'stepIcons' => $this->stepIcons,
            'highestLevel' => $highestLevel
        ]);
    }

    private function getStatusDescription($reviews, $step)
    {
        $roleMap = [
            'Review Sekretaris BEM' => 'Sekum BEM',
            'Review KLI' => 'KLI',
            'Review Wadir 3' => 'WD3'
        ];

        if ($step === 'Pengajuan dibuat') {
            return "Pengajuan telah dibuat dengan ID " . $reviews->first()->id_pengajuan;
        }

        if ($step === 'Diterima') {
            $acceptedReview = $reviews->where('reviewer.role.nama_role', 'WD3')->first();
            if ($acceptedReview) {
                return "Pengajuan diterima pada tanggal " . Carbon::parse($acceptedReview->tanggal_review)->format('d-m-Y H:i:s');
            }

            $lastReview = $reviews->last();
            if ($lastReview && $lastReview->reviewer->role->nama_role === 'WD3') {
                return "Menunggu persetujuan final dari WD3";
            }
            return "Menunggu persetujuan final";
        }

        if (isset($roleMap[$step])) {
            $roleName = $roleMap[$step];
            $review = $reviews->first(function($review) use ($roleName) {
                return $review->reviewer->role->nama_role === $roleName;
            });

            if ($review) {
                return "Sudah direview oleh {$roleName} dengan catatan: {$review->review}";
            } else {
                return "Menunggu review dari {$roleName}";
            }
        }

        return "Status tidak diketahui";
    }

    private function getStepStatus($reviews, $highestLevel)
    {
        $stepStatus = [
            'Pengajuan dibuat' => true,
            'Review Sekretaris BEM' => false,
            'Review KLI' => false,
            'Review Wadir 3' => false,
            'Diterima' => false
        ];

        foreach ($reviews as $review) {
            $roleName = $review->reviewer->role->nama_role;
            switch ($roleName) {
                case 'Sekum BEM':
                    $stepStatus['Review Sekretaris BEM'] = true;
                    break;
                case 'KLI':
                    $stepStatus['Review KLI'] = true;
                    break;
                case 'WD3':
                    $stepStatus['Review Wadir 3'] = true;
                    break;
            }

            if ($review->status === 'diterima') {
                $stepStatus['Diterima'] = true;
                $stepStatus['Review Sekretaris BEM'] = true;
                $stepStatus['Review KLI'] = true;
                $stepStatus['Review Wadir 3'] = true;
            }
        }

        return $stepStatus;
    }

    private function getStatusHistory($reviews)
    {
        $history = [];
        $isAccepted = $reviews->where('status', 'diterima')->isNotEmpty();

        foreach ($this->stepIcons as $step => $icon) {
            $review = null;
            $date = 'Menunggu review';

            if ($step === 'Pengajuan dibuat') {
                $review = $reviews->first();
                if ($review) {
                    $date = Carbon::parse($review->tanggal_review)->format('d-m-Y H:i:s');
                }
            } else {
                $roleName = $this->getRoleNameForStep($step);
                if ($roleName) {
                    $review = $reviews->first(function($r) use ($roleName) {
                        return $r->reviewer->role->nama_role === $roleName;
                    });
                    if ($review) {
                        $date = Carbon::parse($review->tanggal_review)->format('d-m-Y H:i:s');
                    }
                }
            }

            $history[] = [
                'date' => $date,
                'title' => $step,
                'description' => $this->getStatusDescription($reviews, $step),
                'is_active' => $review !== null || ($isAccepted && $step !== 'Diterima')
            ];
        }

        return collect($history)->sortByDesc('date');
    }

    private function getReviewDates($reviews)
    {
        $dates = [];

        $firstReview = $reviews->first();
        if ($firstReview) {
            $dates['Pengajuan dibuat'] = $firstReview->tanggal_review;
        }

        foreach ($reviews as $review) {
            $roleName = $review->reviewer->role->nama_role;

            switch ($roleName) {
                case 'Sekum BEM':
                    $dates['Review Sekretaris BEM'] = $review->tanggal_review;
                    break;
                case 'KLI':
                    $dates['Review KLI'] = $review->tanggal_review;
                    break;
                case 'WD3':
                    $dates['Review Wadir 3'] = $review->tanggal_review;
                    break;
            }

            if ($review->status === 'diterima') {
                $dates['Diterima'] = $review->tanggal_review;
                if (!isset($dates['Review Sekretaris BEM'])) {
                    $dates['Review Sekretaris BEM'] = $review->tanggal_review;
                }
                if (!isset($dates['Review KLI'])) {
                    $dates['Review KLI'] = $review->tanggal_review;
                }
                if (!isset($dates['Review Wadir 3'])) {
                    $dates['Review Wadir 3'] = $review->tanggal_review;
                }
            }
        }

        return $dates;
    }

    private function getRoleNameForStep($step)
    {
        $roleMap = [
            'Review Sekretaris BEM' => 'Sekum BEM',
            'Review KLI' => 'KLI',
            'Review Wadir 3' => 'WD3',
            'Diterima' => null
        ];

        return $roleMap[$step] ?? null;
    }

    private function calculateProgress($reviews, $highestLevel)
    {
        $isAccepted = $reviews->where('status', 'diterima')->isNotEmpty();

        return [
            'Pengajuan dibuat' => true,
            'Review Sekretaris BEM' => $highestLevel >= 1 || $isAccepted,
            'Review KLI' => $highestLevel >= 2 || $isAccepted,
            'Review Wadir 3' => $highestLevel >= 3 || $isAccepted,
            'Diterima' => $isAccepted
        ];
    }

    private function getReviewerLevel($roleName)
    {
        $roleLevels = ['Sekum BEM' => 1, 'KLI' => 2, 'WD3' => 3];
        return $roleLevels[$roleName] ?? -1;
    }
}
