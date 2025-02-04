<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\OrmawaSeeder; 
use Database\Seeders\ReviewerSeeder; 
use Database\Seeders\PengajuanSeeder;
use Database\Seeders\DokumenSeeder;
use Database\Seeders\RuanganSeeder;
use Database\Seeders\GedungSeeder;
use Database\Seeders\UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OrmawaSeeder::class,
            UsersTableSeeder::class,
            ReviewerSeeder::class,
            GedungSeeder::class
        ]);
    }
}