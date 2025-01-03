<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TempatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Menambahkan data acak untuk tabel tempat
        for ($i = 0; $i < 10; $i++) {
            DB::table('tempat')->insert([
                'nama_ruangan' => $faker->word(),  // Nama ruangan acak
                'nama_gedung' => $faker->word(),   // Nama gedung acak
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Seeder untuk tabel tempat berhasil dijalankan!');
    }
}