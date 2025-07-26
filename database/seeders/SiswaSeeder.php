<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Orangtua;
use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua kelas
        $kelasList = Kelas::pluck('id')->toArray();

        for ($i = 1; $i <= 180; $i++) {
            $namaSiswa = fake()->name();
            $slugSiswa = Str::slug($namaSiswa); // contoh: "Ahmad Yani" → "ahmad-yani"
            $nisn = fake()->unique()->numberBetween(10000000, 9999999999);
            $kelasId = fake()->randomElement($kelasList);
            $jenisKelamin = fake()->randomElement(['Laki-laki', 'Perempuan']);
            $emailSiswa = $slugSiswa . '@smpn5.sch.id';

            $namaOrtu = fake()->name();
            $slugOrtu = Str::slug($namaOrtu);
            $emailOrtu = $slugOrtu . '.' . $nisn . '@ortu.smpn5.sch.id';
            $noHpOrtu = '08' . fake()->numerify('##########');

            // Buat user siswa
            $userSiswa = User::create([
                'name' => $namaSiswa,
                'email' => $emailSiswa,
                'role' => 'siswa',
                'password' => Hash::make('smp5siswa'),
            ]);

            // Buat siswa
            $siswa = Siswa::create([
                'nama' => $namaSiswa,
                'nisn' => $nisn,
                'kelas_id' => $kelasId,
                'jenis_kelamin' => $jenisKelamin,
                'user_id' => $userSiswa->id,
            ]);

            // Buat user ortu
            $userOrtu = User::create([
                'name' => $namaOrtu,
                'email' => $emailOrtu,
                'role' => 'orangtua',
                'password' => Hash::make('smp5orangtuasiswa'),
            ]);

            // Buat data ortu
            Orangtua::create([
                'nama' => $namaOrtu,
                'user_id' => $userOrtu->id,
                'nomor_hp' => $noHpOrtu,
                'siswa_id' => $siswa->id,
            ]);
        }
    }
}
