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
        $reviews = Review::with('reviewer')
            ->where('id_pengajuan', $id_pengajuan)
            ->orderBy('tanggal_review', 'asc')
            ->get();

        $pengaju = Pengaju::where('nim', $pengajuan->nim)->first();
        $ormawa = Ormawa::find($pengaju->id_ormawa);

        $highestLevel = $this->getHighestLevel($reviews);
        $reviewDates = $this->getReviewDates($reviews, $pengajuan);
        $stepStatus = $this->getStepStatus($reviews);
        $progressStatus = $this->calculateProgress($reviews, $pengajuan);

        return view('progress2', compact(
            'pengajuan',
            'reviews',
            'ormawa',
            'reviewDates',
            'stepStatus',
            'progressStatus'
        ))->with([
            'stepIcons' => $this->stepIcons
        ]);
    }

    private function getStepStatus($reviews)
    {
        $stepStatus = [
            'Pengajuan dibuat' => ['status' => true, 'isRevisi' => false],
            'Review Sekretaris BEM' => ['status' => false, 'isRevisi' => false],
            'Review KLI' => ['status' => false, 'isRevisi' => false],
            'Review Wadir 3' => ['status' => false, 'isRevisi' => false],
            'Diterima' => ['status' => false, 'isRevisi' => false]
        ];

        foreach ($reviews as $review) {
            switch ($review->reviewer->role) {
                case 'sekum-bem':
                    $stepStatus['Review Sekretaris BEM']['status'] = true;
                    $stepStatus['Review Sekretaris BEM']['isRevisi'] = ($review->status === 'direvisi');
                    break;
                case 'kli':
                    $stepStatus['Review KLI']['status'] = true;
                    $stepStatus['Review KLI']['isRevisi'] = ($review->status === 'direvisi');
                    break;
                case 'wd-3':
                    $stepStatus['Review Wadir 3']['status'] = true;
                    $stepStatus['Review Wadir 3']['isRevisi'] = ($review->status === 'direvisi');
                    if ($review->status === 'diterima') {
                        $stepStatus['Diterima']['status'] = true;
                    }
                    break;
            }
        }

        return $stepStatus;
    }

    private function getReviewDates($reviews, $pengajuan)
    {
        $dates = [
            'Pengajuan dibuat' => $pengajuan->tanggal_pengajuan
        ];

        foreach ($reviews as $review) {
            switch ($review->reviewer->role) {
                case 'sekum-bem':
                    $dates['Review Sekretaris BEM'] = $review->tanggal_review;
                    break;
                case 'kli':
                    $dates['Review KLI'] = $review->tanggal_review;
                    break;
                case 'wd-3':
                    $dates['Review Wadir 3'] = $review->tanggal_review;
                    if ($review->status === 'diterima') {
                        $dates['Diterima'] = $review->tanggal_review;
                    }
                    break;
            }
        }

        return $dates;
    }

    private function calculateProgress($reviews, $pengajuan)
    {
        $progress = [
            'Pengajuan dibuat' => true,
            'Review Sekretaris BEM' => false,
            'Review KLI' => false,
            'Review Wadir 3' => false,
            'Diterima' => false
        ];

        foreach ($reviews as $review) {
            switch ($review->reviewer->role) {
                case 'sekum-bem':
                    $progress['Review Sekretaris BEM'] = true;
                    break;
                case 'kli':
                    $progress['Review KLI'] = true;
                    break;
                case 'wd-3':
                    $progress['Review Wadir 3'] = true;
                    if ($review->status === 'diterima') {
                        $progress['Diterima'] = true;
                    }
                    break;
            }
        }

        return $progress;
    }

    private function getHighestLevel($reviews)
    {
        $roleLevels = [
            'sekum-bem' => 1,
            'kli' => 2,
            'wd-3' => 3
        ];

        $maxLevel = 0;
        foreach ($reviews as $review) {
            $level = $roleLevels[$review->reviewer->role] ?? 0;
            $maxLevel = max($maxLevel, $level);
            if ($review->status === 'diterima' && $review->reviewer->role === 'wd-3') {
                return 3;
            }
        }
        return $maxLevel;
    }
}
