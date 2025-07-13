<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
       public function run(): void
    {
        // Hapus user dengan email admin@example.com jika sudah ada (untuk mencegah duplicate error)
        User::where('email', 'admin@example.com')->delete();

        // Buat ulang user admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // ✅ password disesuaikan
            'role' => 'admin',
        ]);
    }
}