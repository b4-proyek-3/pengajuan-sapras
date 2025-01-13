<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ruangan')->insert([
            [
                'nama_ruangan' => 'Ruang 101',
                'id_gedung' => 1, 
                'foto' => 'images/ruangan/ruang101.jpg', 
                'kapasitas' => 30,
            ],
            [
                'nama_ruangan' => 'Ruang 102',
                'id_gedung' => 1, 
                'foto' => 'images/ruangan/ruang102.jpg',
                'kapasitas' => 25,
            ],
            [
                'nama_ruangan' => 'Ruang 201',
                'id_gedung' => 2, 
                'foto' => 'images/ruangan/ruang201.jpg',
                'kapasitas' => 40,
            ],
            [
                'nama_ruangan' => 'Ruang 301',
                'id_gedung' => 3,
                'foto' => 'images/ruangan/ruang301.jpg',
                'kapasitas' => 50,
            ],
        ]);
    }
}