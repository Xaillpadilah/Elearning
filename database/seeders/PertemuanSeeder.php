<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pertemuan;
use App\Models\Mapel;
use App\Models\Siswa;
class PertemuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      
    public function run(): void
    {
        $siswas = Siswa::all();
        $mapels = Mapel::all();

        foreach ($siswas as $siswa) {
            foreach ($mapels as $mapel) {
                // total pertemuan semester 1 & 2 (misal fix 18 + 18 = 36)
                $pertemuan1 = 18;
                $pertemuan2 = 18;

                // jumlah hadir (acak, tidak melebihi jumlah pertemuan)
                $hadir1 = rand(10, $pertemuan1);
                $hadir2 = rand(12, $pertemuan2);

                Pertemuan::create([
                    'siswa_id'            => $siswa->id,
                    'mapel_id'            => $mapel->id,
                    'pertemuan_semester1' => $pertemuan1,
                    'pertemuan_semester2' => $pertemuan2,
                    'hadir_semester1'     => $hadir1,
                    'hadir_semester2'     => $hadir2,
                ]);
            }
        }
    }
}
