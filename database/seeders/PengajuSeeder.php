<?php

namespace Database\Seeders;

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
        $user = DB::table('users')->where('id_user', 1)->first();

        // Pastikan user ditemukan
        if ($user) {
            foreach ($ormawaIds as $ormawaId) {
                // Mengisi tabel pengaju dengan data acak
                DB::table('pengaju')->insert([
                    'nim' => $faker->unique()->numerify('########'), // Membuat NIM acak
                    'id_user' => $user->id_user, // Menggunakan id_user dari data user yang ditemukan
                    'id_ormawa' => $ormawaId, // Menggunakan ID ormawa yang diambil
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } else {
            echo "User dengan id_user = 1 tidak ditemukan.";
        }
    }
}
