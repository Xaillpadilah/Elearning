<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mapel;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
        ];

        foreach ($mapels as $mapel) {
            Mapel::firstOrCreate(
                ['kode_mapel' => $mapel['kode_mapel']],
                ['nama_mapel' => $mapel['nama_mapel']]
            );
        }
    }
}
