<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengajuan;
use App\Models\Pengaju;
use App\Models\Tempat;
use App\Models\Ormawa;
use Illuminate\Support\Str;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Mengambil data dari tabel pengaju, tempat, dan ormawa
        $nims = Pengaju::pluck('nim')->toArray();
        $tempatIds = Tempat::pluck('id_tempat')->toArray();
        $ormawaIds = Ormawa::pluck('id_ormawa')->toArray();

        $existingCount = Pengajuan::count();

        // Membuat beberapa data pengajuan
        for ($i = 1; $i <= 20; $i++) {
            $idPengajuan = 'P' . str_pad($existingCount + $i, 5, '0', STR_PAD_LEFT);

            Pengajuan::create([
                'id_pengajuan' => $idPengajuan,
                'id_ormawa' => $ormawaIds[array_rand($ormawaIds)], // Mengambil ID ormawa secara acak
                'nim' => $nims[array_rand($nims)], // Mengambil NIM secara acak
                'tanggal_pengajuan' => now(),
                'id_tempat' => $tempatIds[array_rand($tempatIds)], // Mengambil ID tempat secara acak
                'tanggal_pinjam' => now()->addDays(7),
                'tanggal_akhir' => now()->addDays(14),
                'waktu_pinjam' => now()->format('H:i:s'),
                'nama_kegiatan' => 'Kegiatan ' . $i,
                'jenis_kegiatan' => 'proker',
                'link_drive' => 'https://google.com'
            ]);
        }
    }
}