<?php

namespace Tests\Feature;

use App\Models\Pengaju;
use App\Models\Reviewer;
use App\Models\Pengajuan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_allows_a_pengaju_to_create_a_submission_and_a_reviewer_to_review_it()
    {
        // Buat Pengaju
        $pengaju = Pengaju::create([
            'nim' => '123456',
            'nama' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Buat Reviewer
        $reviewer = Reviewer::create([
            'nip' => '987654',
            'nama' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'password' => bcrypt('password456'),
        ]);

        // Buat Pengajuan
        $submissionData = [
            'id_pengajuan' => 'sub_' . uniqid(),
            'nim' => $pengaju->nim,
            'tanggal_pengajuan' => now(),
            'tanggal_pinjam' => now()->addDays(7),
            'tanggal_akhir' => now()->addDays(14),
            'waktu_pengajuan' => now()->format('H:i:s'),
            'nama_kegiatan' => 'Research Project',
            'dokumen' => null, // Asumsi tidak ada dokumen untuk kesederhanaan
        ];

        $pengajuan = Pengajuan::create($submissionData);

        // Verifikasi bahwa pengajuan telah dibuat
        $this->assertDatabaseHas('pengajuan', [
            'id_pengajuan' => $submissionData['id_pengajuan'], // Cek apakah ada dalam DB
            'nim' => $pengaju->nim,
            'nama_kegiatan' => 'Research Project',
        ]);

        // Reviewer mereview pengajuan
        $reviewData = [
            'id_pengajuan' => $pengajuan->id_pengajuan,
            'nip' => $reviewer->nip,
            'review' => 'Pengajuan ini sangat baik.',
        ];

        // Buat review (Anda mungkin ingin mengimplementasikan bagian ini di controller Anda)
        $pengajuan->reviewers()->attach($reviewer->nip, ['review' => $reviewData['review']]);

        // Verifikasi bahwa review telah dibuat
        $this->assertDatabaseHas('reviews', [
            'id_pengajuan' => $pengajuan->id_pengajuan,
            'nip' => $reviewer->nip,
            'review' => 'Pengajuan ini sangat baik.',
        ]);
    }
}
