<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tempat;

class TempatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tempat::create(['nama_tempat' => 'Pendopo']);
        Tempat::create(['nama_tempat' => 'Gedung H']);
        Tempat::create(['nama_tempat' => 'Gedung P2T']);
        Tempat::create(['nama_tempat' => 'Gedung D']);
    }
}
