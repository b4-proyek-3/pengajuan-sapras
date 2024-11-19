<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Pengajuan;
use App\Models\Reviewer;
use Carbon\Carbon;

class HasilReviewSeeder extends Seeder
{
    public function run()
    {
        $pengajuans = Pengajuan::all();
        $reviewers = Reviewer::all();
        
        foreach ($pengajuans as $pengajuan) {
            // Create initial submission status
            Review::create([
                'id_pengajuan' => $pengajuan->id_pengajuan,
                'id_reviewer' => $reviewers->where('role', 'SEKRETARIS')->first()->id_reviewer,
                'review' => 'Pengajuan dibuat',
                'status' => 'Pengajuan dibuat',
                'tanggal_review' => $pengajuan->tanggal_pengajuan
            ]);

            // Randomly add more review statuses
            $statuses = [
                'Review Sekretaris BEM',
                'Review KLI',
                'Review ULT',
                'Review Wadir 3'
            ];

            $currentDate = Carbon::parse($pengajuan->tanggal_pengajuan);
            
            foreach ($statuses as $status) {
                if (rand(0, 1)) {
                    $currentDate = $currentDate->addHours(rand(1, 24));
                    Review::create([
                        'id_pengajuan' => $pengajuan->id_pengajuan,
                        'id_reviewer' => $reviewers->random()->id_reviewer,
                        'review' => 'Review untuk status ' . $status,
                        'status' => $status,
                        'tanggal_review' => $currentDate
                    ]);
                } else {
                    break; // Stop adding statuses for this pengajuan
                }
            }
        }
    }
}