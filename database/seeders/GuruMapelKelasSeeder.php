<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class GuruMapelKelasSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = Guru::all();
        $mapels = Mapel::all();
        $kelasList = Kelas::all();

        if ($gurus->isEmpty() || $mapels->isEmpty() || $kelasList->isEmpty()) {
            $this->command->warn('Pastikan data guru, mapel, dan kelas sudah di-seed.');
            return;
        }

        DB::table('guru_mapel_kelas')->truncate(); // bersihkan dulu (opsional)

        // Contoh logika: setiap guru dapat mengajar 1-2 mapel di beberapa kelas
        foreach ($gurus as $guru) {
            // Ambil 1–2 mapel untuk guru ini
            $mapelSample = $mapels->random(min(2, $mapels->count()));

            foreach ($mapelSample as $mapel) {
                // Assign ke beberapa kelas
                $kelasSample = $kelasList->random(min(2, $kelasList->count()));

                foreach ($kelasSample as $kelas) {
                    DB::table('guru_mapel_kelas')->updateOrInsert([
                        'guru_id' => $guru->id,
                        'mapel_id' => $mapel->id,
                        'kelas_id' => $kelas->id,
                    ], [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $this->command->info('GuruMapelKelasSeeder berhasil dijalankan.');
    }
}
