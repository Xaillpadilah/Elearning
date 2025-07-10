<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengumuman;

class PengumumanSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel pengumuman.
     */
    public function run(): void
    {
        Pengumuman::create([
            'judul' => 'Pengumuman Ujian Akhir',
            'isi' => 'Ujian akhir akan dimulai pada tanggal 12 Juli.',
            'tujuan' => 'siswa',
            'tanggal' => now(),
        ]);

        Pengumuman::create([
            'judul' => 'Libur Akhir Semester',
            'isi' => 'Libur semester akan dimulai tanggal 20 Juli.',
            'tujuan' => 'guru',
            'tanggal' => now()->addDays(5),
        ]);

        Pengumuman::create([
            'judul' => 'Rapat Orang Tua Murid',
            'isi' => 'Rapat orang tua murid akan dilaksanakan pada 15 Juli.',
            'tujuan' => 'orangtua',
            'tanggal' => now()->addDays(3),
        ]);
    }
}
