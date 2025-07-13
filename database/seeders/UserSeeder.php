<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Orangtua;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        $this->command->info('Membuat user admin...');
        $adminUser = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        $this->command->info('Menambahkan data ke tabel admins...');
        Admin::create([
            'user_id' => $adminUser->id,
        ]);
        $this->command->info('Admin berhasil dibuat.');

        // 2. Guru
        $this->command->info('Membuat user guru...');
        $guruUser = User::create([
            'name' => 'Guru Matematika',
            'email' => 'guru@example.com',
            'password' => Hash::make('123456'),
            'role' => 'guru',
        ]);

        Guru::create([
            'user_id' => $guruUser->id,
            'nama' => 'Bapak Rudi',
            'nip' => '1980456789',
            'mapel' => 'Matematika',
        ]);
        $this->command->info('Guru berhasil dibuat.');

        // 3. Siswa
        $this->command->info('Membuat user siswa...');
        $siswaUser = User::create([
            'name' => 'Siswa Contoh',
            'email' => 'siswa@example.com',
            'password' => Hash::make('123456'),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'user_id' => $siswaUser->id,
            'nama' => 'Andi Pratama',
            'nisn' => '1234567890',
            'kelas' => '8A',
        ]);
        $this->command->info('Siswa berhasil dibuat.');

        // 4. Orang Tua
        $this->command->info('Membuat user orangtua...');
        $ortuUser = User::create([
            'name' => 'Orangtua Siswa',
            'email' => 'ortu@example.com',
            'password' => Hash::make('123456'),
            'role' => 'orangtua',
        ]);

        Orangtua::create([
            'user_id' => $ortuUser->id,
            'nama' => 'Ibu Andi',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Pendidikan No. 10',
        ]);
        $this->command->info('Orangtua berhasil dibuat.');
    }
}
