<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrmawaSeeder extends Seeder
{
    public function run()
    {
        $ormawaList = [
            'Majelis Perwakilan Mahasiswa (MPM)',
            'Badan Eksekutif Mahasiswa (BEM)',
            'Himpunan Mahasiswa Jurusan (HMJ)',
            'HMJ Teknik Sipil',
            'HMJ Teknik Mesin',
            'HMJ Teknik Elektro',
            'HMJ Teknik Kimia',
            'HMJ Teknik Komputer dan Informatika',
            'HMJ Teknik Refrigerasi dan Tata Udara',
            'HMJ Teknik Konversi Energi',
            'HMJ Akuntansi',
            'HMJ Administrasi Niaga',
            'HMJ Bahasa Inggris',
            'Unit Kegiatan Mahasiswa (UKM)',
            'UKM Robotika',
            'UKM Otomotif',
            'UKM Kewirausahaan',
            'UKM The Education and Entertainment Line Transmitter Radio Stations (ELTRAS)',
            'UKM Asosiasi Mahasiswa Islam (Assalam)',
            'UKM Persatuan Mahasiswa Kristen (PMK)',
            'UKM Keluarga Mahasiswa Katholik (KMK)',
            'UKM Kebudayaan Baraya Sunda (Kabayan)',
            'UKM Paduan Suara Mahasiswa (PSM)',
            'UKM Musik dan Teater',
            'UKM Unit Kesenian Budaya Minang (UKBM)',
            'UKM Unit Budaya & Seni Sumatera Utara (UBSU)',
            'UKM Sepak Bola dan Futsal (USF)',
            'UKM Bola Basket',
            'UKM Bola Voli',
            'UKM Bulu Tangkis',
            'UKM Catur',
            'UKM Bela Diri',
            'UKM Perhimpunan Penempuh Rimba dan Pendaki Gunung (PPRPG) SAGA',
            'UKM Korp Sukarela (KSR) PMI',
            'UKM Pramuka',
            'UKM Fellas'
        ];

        foreach ($ormawaList as $ormawa) {
            DB::table('ormawa')->insert([
                'nama_ormawa' => $ormawa,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
