<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $dataKelas = [
            ['nama_kelas' => 'VII A', 'wali_kelas' => 'Bu Siti'],
            ['nama_kelas' => 'VII B', 'wali_kelas' => 'Pak Budi'],
            ['nama_kelas' => 'VIII A', 'wali_kelas' => 'Bu Lina'],
            ['nama_kelas' => 'VIII B', 'wali_kelas' => 'Pak Ahmad'],
            ['nama_kelas' => 'IX A', 'wali_kelas' => 'Bu Nur'],
            ['nama_kelas' => 'IX B', 'wali_kelas' => 'Pak Dedi'],
        ];

        foreach ($dataKelas as $kelas) {
            Kelas::create($kelas);
        }
    }
}
