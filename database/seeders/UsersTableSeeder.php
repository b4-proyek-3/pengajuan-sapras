<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void { 
        $password = 'password'; 
        // Password plaintext untuk testing 
        $hashedPassword = Hash::make($password); 
        // Log password plaintext dan hashed untuk testing purposes 
        Log::info('Password Plaintext: ' . $password); 
        Log::info('Hashed Password: ' . $hashedPassword); 
        DB::table('users')->insert([ 
            [ 
                'name' => 'John Doe', 
                'email' => 'john.doe@polban.ac.id', 
                'email_verified_at' => now(), 
                'password' => $hashedPassword, 
                // Menggunakan hashed password 
                'remember_token' => Str::random(10), 
                'created_at' => now(), 
                'updated_at' => now(), 
            ], 
            [ 
                'name' => 'Jane Smith', 
                'email' => 'jane.smith@polban.ac.id', 
                'email_verified_at' => now(), 
                'password' => $hashedPassword, 
                // Menggunakan hashed password 
                'remember_token' => Str::random(10), 
                'created_at' => now(), 
                'updated_at' => now(), 
            ], 
            [ 
                'name' => 'James Johnson', 
                'email' => 'james.johnson@polban.ac.id', 
                'email_verified_at' => now(), 
                'password' => $hashedPassword, 
                // Menggunakan hashed password 
                'remember_token' => Str::random(10), 
                'created_at' => now(), 
                'updated_at' => now(), 
            ], 
            [ 'name' => 'Alice Williams', 
            'email' => 'alice.williams@polban.ac.id', 
            'email_verified_at' => now(), 
            'password' => $hashedPassword, 
            // Menggunakan hashed password 
            'remember_token' => Str::random(10), 
            'created_at' => now(), 
            'updated_at' => now(), 
        ], 
    ]); 
} 
}
