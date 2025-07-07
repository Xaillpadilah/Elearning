<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
   
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // ✅ password
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Guru A',
            'email' => 'guru@example.com',
            'password' => Hash::make('guru123'), // ✅ password
            'role' => 'guru'
        ]);

        User::create([
            'name' => 'Siswa Pertama',
            'email' => 'siswa@example.com',
            'password' => Hash::make('siswa123'), // ✅ password
            'role' => 'siswa'
        ]);

        User::create([
            'name' => 'Orang Tua',
            'email' => 'ortu@example.com',
            'password' => Hash::make('ortu123'), // ✅ password
            'role' => 'orangtua'
        ]);
    }
}