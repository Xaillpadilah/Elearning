<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Kelas;
use Faker\Factory as Faker;
class SiswaSeeder extends Seeder
{public function run(): void
    {
        $faker = Faker::create('id_ID');

        $kelasList = Kelas::all();

        foreach ($kelasList as $kelas) {
            for ($i = 0; $i < $kelas->jumlah_siswa; $i++) {
                Siswa::create([
                    'nama' => $faker->name,
                    'nisn' => $faker->unique()->numerify('##########'),
                    'email' => $faker->unique()->safeEmail,
                    'kelas_id' => $kelas->id,
                ]);
            }
        }
    }
}