<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ormawa; // Import model Ormawa
use Faker\Factory as Faker;

class PengajuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Mengambil semua id_ormawa yang ada di tabel ormawa
        $ormawaIds = Ormawa::pluck('id_ormawa')->toArray();

        foreach ($ormawaIds as $ormawaId) {
            // Mengisi tabel pengaju dengan data acak
            DB::table('pengaju')->insert([
                'nim' => $faker->unique()->numerify('########'), // Membuat NIM acak
                'nama' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password123'), // Enkripsi password
                'id_ormawa' => $ormawaId, // Menggunakan ID ormawa yang diambil
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
