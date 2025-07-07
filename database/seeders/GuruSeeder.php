<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Guru;
class GuruSeeder extends Seeder
{
     public function run(): void
    {
        Guru::insert([
            [
                'nama' => 'Ahmad Yusuf',
                'nik' => '1987654321',
                'mengajar' => 'Matematika',
                'email' => 'ahmad@guru.com',
            ],
            [
                'nama' => 'Siti Rahma',
                'nik' => '1987123456',
                'mengajar' => 'Bahasa Indonesia',
                'email' => 'siti@guru.com',
            ],
            [
                'nama' => 'Bambang Wijaya',
                'nik' => '1987112233',
                'mengajar' => 'IPA',
                'email' => 'bambang@guru.com',
            ],
            [
                'nama' => 'Desi Kartika',
                'nik' => '1987001122',
                'mengajar' => 'IPS',
                'email' => 'desi@guru.com',
            ],
            [
                'nama' => 'Rina Lestari',
                'nik' => '1987334455',
                'mengajar' => 'Bahasa Inggris',
                'email' => 'rina@guru.com',
            ],
        ]);
    }
}