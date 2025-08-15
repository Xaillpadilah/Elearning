<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ujian;
use App\Models\GuruMapelKelas;
use App\Models\Mapel;
use Illuminate\Support\Str;

class UjianSeeder extends Seeder
{
    public function run(): void
    {
        $mapels = [
            ['kode_mapel' => 'PKN',  'nama_mapel' => 'Pendidikan Kewarganegaraan'],
            ['kode_mapel' => 'MTK',  'nama_mapel' => 'Matematika'],
            ['kode_mapel' => 'BIND', 'nama_mapel' => 'Bahasa Indonesia'],
            ['kode_mapel' => 'BIG',  'nama_mapel' => 'Bahasa Inggris'],
            ['kode_mapel' => 'IPA',  'nama_mapel' => 'Ilmu Pengetahuan Alam'],
            ['kode_mapel' => 'IPS',  'nama_mapel' => 'Ilmu Pengetahuan Sosial'],
            ['kode_mapel' => 'SBK',  'nama_mapel' => 'Seni Budaya'],
            ['kode_mapel' => 'PJOK', 'nama_mapel' => 'Pendidikan Jasmani'],
            ['kode_mapel' => 'AGM',  'nama_mapel' => 'Pendidikan Agama'],
            ['kode_mapel' => 'TIK',  'nama_mapel' => 'Teknologi Informasi dan Komunikasi'],
            ['kode_mapel' => 'BD',   'nama_mapel' => 'Bahasa Daerah'],
        ];

        foreach ($mapels as $mapelData) {
          $mapel = Mapel::where('nama_mapel', $mapelData['nama_mapel'])->first();

            if (!$mapel) {
                $this->command->warn("Mapel '{$mapelData['nama_mapel']}' tidak ditemukan. Lewati...");
                continue;
            }

            // Ambil satu GuruMapelKelas untuk mapel tersebut
            $gmk = GuruMapelKelas::where('mapel_id', $mapel->id)->first();

            if (!$gmk) {
                // Jika belum ada, buat dummy
                $gmk = GuruMapelKelas::create([
                    'guru_id' => 1, // Pastikan guru_id dan kelas_id valid
                    'mapel_id' => $mapel->id,
                    'kelas_id' => 1,
                ]);
            }

            Ujian::create([
                'judul' => 'Ujian ' . Str::title($mapel->nama) . ' Semester Ganjil',
                'tanggal' => now()->toDateString(),
                'keterangan' => 'Ujian pilihan ganda untuk mata pelajaran ' . $mapel->nama,
                'tipe_ujian' => 'pilihan_ganda',
                'acak_soal' => true,
                'guru_mapel_kelas_id' => $gmk->id,
            ]);

            $this->command->info("✅ Ujian untuk mapel '{$mapel->nama}' berhasil dibuat.");
        }
        
    }
}
