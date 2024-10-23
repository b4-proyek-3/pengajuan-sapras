<?php

namespace Tests\Feature;

use App\Models\Pengaju;
use App\Models\Reviewer;
use App\Models\Pengajuan;
use App\Models\Ormawa;
use App\Models\Role;
use App\Models\Tempat;
use App\Models\Review; // Pastikan untuk mengimpor model Review
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected $pengaju;
    protected $reviewer;

    protected function setUp(): void
    {
        parent::setUp();

        // Membuat data dummy untuk Ormawa
        $this->ormawa = Ormawa::create([
            'id_ormawa' => 1,
            'nama_ormawa' => 'Ormawa Example',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Membuat data dummy untuk Role
        $this->role = Role::create([
            'id_role' => 1,
            'nama_role' => 'Sekum BEM',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Membuat data dummy untuk Tempat
        $this->tempat = Tempat::create([
            'id_tempat' => 1,
            'nama_tempat' => 'Ruang Rapat 1',
            'lokasi' => 'Lantai 2, Gedung A',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Membuat data dummy untuk Pengaju
        $this->pengaju = Pengaju::create([
            'nim' => '12345678',
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'), // Enkripsi password
            'id_ormawa' => 1, // Asumsi id_ormawa sudah ada
        ]);

        // Membuat data dummy untuk Reviewer
        $this->reviewer = Reviewer::create([
            'nip' => '87654321',
            'nama' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'), // Enkripsi password
            'id_role' => 1, // Asumsi id_role sudah ada
        ]);
    }

    /** @test */
    public function it_allows_a_pengaju_to_create_a_submission_and_a_reviewer_to_review_it()
    {
        // Buat Pengajuan
        $submissionData = [
            'id_pengajuan' => substr('sub_' . Str::random(2), 0, 6),
            'nim' => $this->pengaju->nim, // Menggunakan data pengaju yang telah dibuat
            'tanggal_pengajuan' => now(),
            'id_tempat' => 1, // Misalkan id_tempat sudah ada
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
            'nim' => $this->pengaju->nim,
            'nama_kegiatan' => 'Research Project',
        ]);

        // Reviewer mereview pengajuan
        $reviewData = [
            'id_pengajuan' => $pengajuan->id_pengajuan,
            'nip' => $this->reviewer->nip, // Menggunakan data reviewer yang telah dibuat
            'review' => 'Pengajuan ini sangat baik.',
            'status' => 'diterima', // Misalkan kita set status untuk review ini
            'tanggal_review' => now(),
        ];

        // Buat review menggunakan model Review
        Review::create($reviewData);

        // Verifikasi bahwa review telah dibuat
        $this->assertDatabaseHas('reviews', [
            'id_pengajuan' => $pengajuan->id_pengajuan,
            'nip' => $this->reviewer->nip,
            'review' => 'Pengajuan ini sangat baik.',
            'status' => 'diterima', // Verifikasi status review
        ]);
    }
}