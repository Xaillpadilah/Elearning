<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Materi;
class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Materi::create([
            'judul' => 'Materi Matematika Dasar',
            'mapel' => 'Matematika',
            'kelas' => '7A',
            'file' => 'matematika_dasar.pdf',
            'uploaded_at' => now(),
        ]);

        Materi::create([
            'judul' => 'Pengenalan IPA',
            'mapel' => 'IPA',
            'kelas' => '8B',
            'file' => 'ipa_pengenalan.pdf',
            'uploaded_at' => now(),
        ]);

        Materi::create([
            'judul' => 'Bahasa Indonesia Menulis Puisi',
            'mapel' => 'Bahasa Indonesia',
            'kelas' => '9C',
            'file' => 'bindo_puisi.pdf',
            'uploaded_at' => now(),
        ]);
    }
}

