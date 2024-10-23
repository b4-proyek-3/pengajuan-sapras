<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['nama_role' => 'WD3']);
        Role::create(['nama_role' => 'Sekum BEM']);
        Role::create(['nama_role' => 'KLI']);
        Role::create(['nama_role' => 'ULT']);
    }
}
