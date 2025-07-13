<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class GuruSeeder extends Seeder
{
     public function run(): void
    {
        // Buat user baru untuk guru
        $user = User::create([
            'name' => 'Ahmad Yusuf',
            'email' => 'ahmad@guru.com',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        // Buat guru yang terhubung ke user
        Guru::create([
            'user_id' => $user->id,
            'nama' => 'Ahmad Yusuf',
            'nik' => '1987654321',
        ]);
    }
}