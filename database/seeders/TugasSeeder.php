<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TugasSeeder extends Seeder
{
    public function run(): void
    {
        $guruMapelKelasIds = DB::table('guru_mapel_kelas')->pluck('id');

        if ($guruMapelKelasIds->isEmpty()) {
            $this->command->warn('Seeder tugas: Tidak ada data guru_mapel_kelas ditemukan.');
            return;
        }

        foreach (range(1, 10) as $i) {
            DB::table('tugas')->insert([
                'judul' => 'Tugas ke-' . $i,
                'deskripsi' => 'Deskripsi tugas ke-' . $i,
                'jenis' => $i % 2 == 0 ? 'tugas' : 'kuis',
                'tanggal_deadline' => Carbon::now()->addDays(rand(3, 14)),
                'file_path' => 'uploads/tugas/contoh_file_' . $i . '.pdf',
                'guru_mapel_kelas_id' => $guruMapelKelasIds->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
