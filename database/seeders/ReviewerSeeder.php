<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ReviewerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Mengambil semua id_user yang ada di tabel users
        $userIds = DB::table('users')->pluck('id_user')->toArray();

        // Mengecek apakah ada user yang tersedia
        if (empty($userIds)) {
            $this->command->error('Tidak ada data pengguna di tabel users!');
            return;
        }
        // Role yang akan digunakan untuk reviewer
        $roles = ['sekum-bem', 'kli', 'ketua_jurusan', 'wd-3'];

        // Menambahkan data reviewer ke tabel reviewers
        foreach ($roles as $role) {
            // Memilih id_user acak dari tabel users
            $idUser = $faker->randomElement($userIds);

            // Menambahkan data reviewer ke tabel reviewers
            DB::table('reviewers')->insert([
                'id_user' => $idUser,  // Menggunakan id_user acak dari tabel users
                'role' => $role,       // Role reviewer (sekum-bem, kli, ketua_jurusan, wd-3)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Seeder untuk tabel reviewers berhasil dijalankan!');
    }
}
