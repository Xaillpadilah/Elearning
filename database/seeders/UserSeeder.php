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
            'name' => 'esteryuu',
            'email' => 'siswa@example.com',
            'password' => Hash::make('password123'), // default password
            'role' => 'siswa', // Tambahkan role jika diperlukan
        ]);

        User::create([
            'name' => 'Orang Tua Rizki',
            'email' => 'ortu@example.com',
            'password' => Hash::make('password'), // default password
            'role' => 'orangtua',
        ]);
    }
}
