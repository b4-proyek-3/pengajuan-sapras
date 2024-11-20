<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Pengajuan;
use App\Models\Reviewer;
use Carbon\Carbon;

class ReviewsSeeder extends Seeder
{
    public function run()
    {
        // Sample data that matches the migration schema
        $reviews = [
            [
                'id_pengajuan' => 'P00001',
                'id_reviewer' => 1,
                'status' => 'diterima',
                'catatan' => 'bagus',
                'tanggal_review' => '2024-11-01 08:00:00'
            ],
            [
                'id_pengajuan' => 'P00001',
                'id_reviewer' => 2,
                'status' => 'diterima',
                'catatan' => 'bagus',
                'tanggal_review' => '2024-11-01 08:00:00'
            ],
            [
                'id_pengajuan' => 'P00002',
                'id_reviewer' => 1,
                'status' => 'diterima',
                'catatan' => 'bagus',
                'tanggal_review' => '2024-11-01 08:00:00'
            ],
            [
                'id_pengajuan' => 'P00001',
                'id_reviewer' => 4,
                'status' => 'diterima',
                'catatan' => 'bagus',
                'tanggal_review' => '2024-11-01 08:00:00'
            ],
            [
                'id_pengajuan' => 'P00002',
                'id_reviewer' => 2,
                'status' => 'diterima',
                'catatan' => 'bagus',
                'tanggal_review' => '2024-11-01 08:00:00'
            ],
            [
                'id_pengajuan' => 'P00003',
                'id_reviewer' => 1,
                'status' => 'direvisi',
                'catatan' => 'bagus',
                'tanggal_review' => '2024-11-01 08:00:00'
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
