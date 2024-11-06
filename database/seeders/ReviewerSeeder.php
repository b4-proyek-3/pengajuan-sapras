<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role; // Import model Role
use Faker\Factory as Faker;

class ReviewerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Mengambil semua id_ormawa yang ada di tabel ormawa
        $roleIds = Role::pluck('id_role')->toArray();

        foreach ($roleIds as $roleId) {
            // Mengisi tabel pengaju dengan data acak
            DB::table('reviewers')->insert([
                'id_reviewer' => $faker->unique()->numerify('########'), // Membuat NIP acak
                'nama' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password123'), // Enkripsi password
                'id_role' => $roleId, // Menggunakan ID role yang diambil
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
