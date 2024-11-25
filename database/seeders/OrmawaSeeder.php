<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ormawa;

class OrmawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan semua nama ormawa ke dalam database
        $ormawas = [
            'MPM',
            'BEM',
            'HMAN',
            'HMAK',
            'HIMARIS',
            'HME',
            'HMJTK',
            'HIMAKOM',
            'HMTE',
            'HMM',
            'HMRA',
            'HIMAS',
            'UKM Assalam',
            'UKM Bela Diri',
            'UKM Bola Basket',
            'UKM Bola Voli',
            'UKM Bulutangkis',
            'UKM Catur',
            'UKM Flag Football',
            'UKM Kabayan',
            'UKM KMK',
            'UKM Kewirausahaan',
            'UKM KSR',
            'UKM Musik dan Teater',
            'UKM Otomotif',
            'UKM PSM',
            'UKM SAGA',
            'UKM PMK',
            'UKM Pramuka',
            'UKM Robotika',
            'UKM USF',
            'UKM Tenis Meja',
            'UKM Eltras',
            'UKM UBSU',
            'UKM UKB',
        ];

        foreach ($ormawas as $nama) {
            Ormawa::create(['nama_ormawa' => $nama]);
        }
    }
}