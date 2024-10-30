<?php

namespace Database\Factories;

use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengajuanFactory extends Factory
{
    protected $model = Pengajuan::class;

    public function definition()
    {
        return [
            'id_pengajuan' => strtoupper($this->faker->unique()->lexify('??????')),
            'tanggal_pengajuan' => $this->faker->date(),
            'ormawa' => $this->faker->word(),
            'tanggal_peminjaman' => $this->faker->date(),
            'tanggal_berakhir' => $this->faker->date(),
            'waktu' => $this->faker->time(),
            'nama_kegiatan' => $this->faker->sentence(),
            'tempat_peminjaman' => $this->faker->address(),
            'dokumen1' => 'dummy.pdf', // Simulasikan dokumen yang diupload
            // Tambahkan dokumen lainnya sesuai kebutuhan
        ];
    }
}