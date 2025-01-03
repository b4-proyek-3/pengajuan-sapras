<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GedungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gedung')->insert([
            ['nama_gedung' => 'Gedung A', 'created_at' => now(), 'updated_at' => now()],
            ['nama_gedung' => 'Gedung B', 'created_at' => now(), 'updated_at' => now()],
            ['nama_gedung' => 'Gedung C', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}