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
        Ormawa::create(['nama_ormawa' => 'BEM']);
        Ormawa::create(['nama_ormawa' => 'Himpunan Mahasiswa Teknik Informatika']);
        Ormawa::create(['nama_ormawa' => 'Himpunan Mahasiswa Elektro']);
        Ormawa::create(['nama_ormawa' => 'Himpunan Mahasiswa Teknik Sipil']);
        Ormawa::create(['nama_ormawa' => 'UKM Musik']);
    }
}
