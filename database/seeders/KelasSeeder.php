<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Guru;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua guru yang tersedia
        $gurus = Guru::all();

        // Jika tidak ada guru, jangan lanjut
        if ($gurus->isEmpty()) {
            $this->command->warn('Tidak ada data guru untuk dijadikan wali kelas. Jalankan GuruSeeder dulu.');
            return;
        }

        // Buat beberapa kelas
        $kelasList = ['7A', '7B','7C','8A','8B','8C','9A','9B','9C'];

        foreach ($kelasList as $index => $namaKelas) {
            // Ambil guru secara berurutan (atau acak jika mau)
            $waliGuru = $gurus[$index % $gurus->count()]; // Putar kalau guru kurang

            Kelas::create([
                'nama_kelas' => $namaKelas,
                'wali_kelas' => $waliGuru->id,
            ]);
        }

        $this->command->info('KelasSeeder berhasil dijalankan.');
    }
}
