<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Review;
use Carbon\Carbon;

class TrackingController extends Controller
{
    public function show($id_pengajuan)
    {
        $pengajuan = Pengajuan::with(['reviews' => function($query) {
            $query->orderBy('tanggal_review', 'desc');
        }, 'pengaju', 'tempat'])->findOrFail($id_pengajuan);

        $currentStatus = $pengajuan->reviews->first();
        $progressStatus = $this->calculateProgress($pengajuan->reviews);

        return view('tracking.progress2', compact('pengajuan', 'currentStatus', 'progressStatus'));
    }

    private function calculateProgress($reviews)
    {
        $steps = [
            'Pengajuan dibuat' => true,
            'Review Sekretaris BEM' => false,
            'Review KLI' => false,
            'Review ULT' => false,
            'Review Wadir 3' => false
        ];

        $nipToStep = [
            'SEKRETARIS_BEM_NIP' => 'Review Sekretaris BEM',
            'KLI_NIP' => 'Review KLI',
            'ULT_NIP' => 'Review ULT',
            'WADIR_NIP' => 'Review Wadir 3'
        ];

        foreach ($reviews as $review) {
            if (isset($nipToStep[$review->nip])) {
                $steps[$nipToStep[$review->nip]] = true;
            }
        }

        return $steps;
    }
}