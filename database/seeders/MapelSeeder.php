<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mapel;
class MapelSeeder extends Seeder
{
   
  public function run()
    {
        $mapels = [
            ['nama_mapel' => 'Matematika', 'kode_mapel' => 'MTK001'],
            ['nama_mapel' => 'IPA',         'kode_mapel' => 'IPA001'],
            ['nama_mapel' => 'IPS',         'kode_mapel' => 'IPS001'],
            ['nama_mapel' => 'Bahasa Indonesia', 'kode_mapel' => 'BIN001'],
            ['nama_mapel' => 'Bahasa Inggris',   'kode_mapel' => 'BIG001'],
        ];

        foreach ($mapels as $mapel) {
            Mapel::create($mapel);
        }
    }
}