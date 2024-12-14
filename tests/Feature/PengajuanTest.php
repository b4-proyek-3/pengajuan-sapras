<?php

namespace Tests\Feature;

use App\Models\Pengajuan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class PengajuanTest extends TestCase
{
    use RefreshDatabase;

    public function test_saves_form_data_to_database_correctly()
    {
        $data = [
            'tanggal_pengajuan' => '2024-10-23',
            'ormawa' => 'Ormawa Contoh',
            'nama_pengaju' => 'Nama Pengaju',
            'tanggal_peminjaman' => '2024-11-01',
            'tanggal_berakhir' => '2024-11-02',
            'waktu' => '09:00 - 12:00',
            'nama_kegiatan' => 'Kegiatan Contoh',
            'tempat_peminjaman' => 'Tempat Contoh',
            'dokumen1' => UploadedFile::fake()->create('dokumen1.pdf', 100, 'application/pdf'),
        ];

        // Melewati middleware CSRF
        $response = $this->withoutMiddleware()->post(route('pengajuan.form'), $data);

        // Kirim permintaan POST
        $response = $this->post(route('pengajuan.form'), $data);

        // Pastikan data disimpan di database
        $this->assertDatabaseHas('pengajuan', [
            'nama_kegiatan' => $data['nama_kegiatan'],
        ]);
        
        // Pastikan ada redirect
        $response->assertRedirect(route('pengajuan.index'));
    }

    public function test_displays_the_pengajuan_table_correctly()
    {
        // Buat pengajuan menggunakan factory
        $pengajuan = Pengajuan::factory()->create();

        // Akses halaman index
        $response = $this->get(route('pengajuan.index'));

        // Pastikan respon sukses
        $response->assertStatus(200);

        // Pastikan pengajuan ada di dalam respon
        $response->assertSee($pengajuan->nama_kegiatan);
    }

    public function test_validates_form_submission_correctly()
    {
        // Data form yang valid
        $data = [
            'tanggal_pengajuan' => now()->format('Y-m-d'),
            'ormawa' => 'Ormawa Contoh',
            'nama_pengaju' => 'Nama Contoh',
            'tanggal_peminjaman' => now()->format('Y-m-d'),
            'tanggal_berakhir' => now()->addDays(2)->format('Y-m-d'),
            'waktu' => '10:00 - 12:00',
            'nama_kegiatan' => 'Kegiatan Contoh',
            'tempat_peminjaman' => 'Tempat Contoh',
            'dokumen1' => UploadedFile::fake()->create('dokumen1.pdf', 500), // Buat file contoh
        ];

        // Nonaktifkan middleware CSRF
        $response = $this->withoutMiddleware()->post(route('pengajuan.form'), $data);

        // Pastikan ada redirect
        $response->assertRedirect(route('pengajuan.index'));
    }

    public function test_shows_validation_errors_if_form_submission_is_invalid()
    {
        // Data yang tidak valid
        $data = [
            'tanggal_pengajuan' => now()->format('Y-m-d'),
            'ormawa' => 'Ormawa Contoh',
            'nama_pengaju' => 'Nama Contoh',
            'tanggal_peminjaman' => now()->format('Y-m-d'),
            'tanggal_berakhir' => now()->addDays(2)->format('Y-m-d'),
            'waktu' => '10:00 - 12:00',
            'nama_kegiatan' => 'Kegiatan Contoh',
            'tempat_peminjaman' => 'Tempat Contoh',
            'dokumen1' => null, // Tidak mengirim dokumen, akan menyebabkan validasi gagal
        ];

        $response = $this->withoutMiddleware()->post(route('pengajuan.form'), $data);

        // Pastikan validasi gagal untuk dokumen1
        $response->assertSessionHasErrors(['dokumen1']);
    }
}