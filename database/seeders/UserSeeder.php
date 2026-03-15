<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@layang.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_verified' => true,
        ]);

        // Juri
        User::create([
            'name' => 'Dr. Budi Juri',
            'email' => 'juri@layang.com',
            'password' => Hash::make('password'),
            'role' => 'juri',
            'is_verified' => true,
        ]);

        // Peserta
        User::create([
            'name' => 'Sari Peserta',
            'email' => 'peserta@layang.com',
            'password' => Hash::make('password'),
            'role' => 'peserta',
            'phone' => '081234567890',
            'region' => 'Yogyakarta',
            'is_verified' => true,
        ]);
    }
}