<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Siswa;
use Faker\Factory as Faker;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $kelasList = [
            [
                'nama_kelas' => 'VII A',
                'wali_kelas' => 'Bu Siti Aminah',
                'jumlah_siswa' => 32,
            ],
            [
                'nama_kelas' => 'VII B',
                'wali_kelas' => 'Pak Budi Hartono',
                'jumlah_siswa' => 30,
            ],
            [
                'nama_kelas' => 'VIII A',
                'wali_kelas' => 'Bu Rina Marlina',
                'jumlah_siswa' => 31,
            ],
            [
                'nama_kelas' => 'IX A',
                'wali_kelas' => 'Pak Dadan Subrata',
                'jumlah_siswa' => 29,
            ],
        ];

        foreach ($kelasList as $item) {
            $kelas = Kelas::create([
                'nama_kelas'   => $item['nama_kelas'],
                'wali_kelas'   => $item['wali_kelas'],
                'jumlah_siswa' => $item['jumlah_siswa'],
            ]);

            // Buat siswa sesuai jumlah_siswa
            for ($i = 0; $i < $item['jumlah_siswa']; $i++) {
                Siswa::create([
                    'nama'      => $faker->name,
                    'nisn'      => $faker->unique()->numerify('##########'),
                    'email'     => $faker->unique()->safeEmail,
                    'kelas_id'  => $kelas->id,
                ]);
            }
        }
    }
}
