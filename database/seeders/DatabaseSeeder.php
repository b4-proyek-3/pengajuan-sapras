<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\OrmawaSeeder; 
use Database\Seeders\ReviewerSeeder; 
use Database\Seeders\TempatSeeder; 
use Database\Seeders\PengajuSeeder;
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
            UsersTableSeeder::class,
            OrmawaSeeder::class,
            ReviewerSeeder::class,
            TempatSeeder::class,
            PengajuSeeder::class,
            RuanganSeeder::class,
            GedungSeeder::class
            //PengajuanSeeder::class,
            //DokumenSeeder::class,
        ]);
    }
}