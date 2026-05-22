<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Kode ini untuk menyuntikkan data admin baru ke database lokal kamu
        User::create([
            'name' => 'Master Admin',
            'email' => 'admin',                     // Ini yang nanti diketik di kotak USERNAME halaman login
            'password' => Hash::make('admin123'),   // Ini PASSWORD-nya
        ]);
    }
}