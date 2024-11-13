<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tempat;

class TempatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tempat = [
            ['id_tempat' => '1', 'nama_tempat' => 'Pendopo Agung'],
            ['id_tempat' => '2', 'nama_tempat' => 'Ruang Kuliah H-405'],
            ['id_tempat' => '3', 'nama_tempat' => 'Ruang Rapat A (P2T)'],
            ['id_tempat' => '4', 'nama_tempat' => 'Ruang Kelas 310'],
            ['id_tempat' => '5', 'nama_tempat' => 'Ruang Kelas 309'],
            ['id_tempat' => '6', 'nama_tempat' => 'Ruang Kelas 307'],
            ['id_tempat' => '7', 'nama_tempat' => 'Ruang Kelas 301'],
            ['id_tempat' => '8', 'nama_tempat' => 'Ruang Aula'],
            ['id_tempat' => '9', 'nama_tempat' => 'Ruang Teleconference Room'],
            ['id_tempat' => '10', 'nama_tempat' => 'Ruang Conference Room'],
            ['id_tempat' => '11', 'nama_tempat' => 'Ruang Rapat E'],
            ['id_tempat' => '12', 'nama_tempat' => 'Ruang Rapat D'],
            ['id_tempat' => '13', 'nama_tempat' => 'Ruang Rapat C'],
            ['id_tempat' => '14', 'nama_tempat' => 'Ruang Rapat B (Auditorium)'],
            ['id_tempat' => '15', 'nama_tempat' => 'Ruang Rapat A (Direktorat)'],
            ['id_tempat' => '16', 'nama_tempat' => 'Ruang Rapim'],
        ];

        foreach ($tempat as $item) {
            Tempat::create($item);
        }
    }
}
