<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Carbon;

class MateriSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data relasi (pastikan data ini sudah di-seed sebelumnya)
        $mapel = Mapel::first(); // ambil mapel pertama
        $kelas = Kelas::first(); // ambil kelas pertama
        $guru  = Guru::first();  // ambil guru pertama
        $uploader = User::first(); // ambil user pertama (sebagai uploader)

        // Jika salah satu tidak ada, hentikan seeder
        if (!$mapel || !$kelas || !$guru || !$uploader) {
            $this->command->warn("Seeder dibatalkan. Pastikan Mapel, Kelas, Guru, dan User sudah tersedia.");
            return;
        }

        Materi::create([
            'judul'       => 'Materi Pengantar Laravel',
            'mapel'       => $mapel->nama_mapel, // jika kamu tetap pakai kolom 'mapel'
            'kelas'       => $kelas->nama_kelas, // jika kamu tetap pakai kolom 'kelas'
            'file'        => 'materi_pengantar_laravel.pdf',
            'uploaded_at' => Carbon::now(),
            'mapel_id'    => $mapel->id,
            'kelas_id'    => $kelas->id,
            'guru_id'     => $guru->id,
            'uploaded_by' => $uploader->id,
        ]);
    }
}
