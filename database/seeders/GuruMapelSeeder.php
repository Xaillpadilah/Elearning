<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\User;
use App\Models\GuruMapelKelas;
use Illuminate\Support\Facades\Hash;
class GuruMapelSeeder extends Seeder
{
    public function run(): void
    {
        // Data Mapel
        $mapels = [
            ['nama_mapel' => 'Matematika', 'kode_mapel' => 'MATH101'],
            ['nama_mapel' => 'Bahasa Indonesia', 'kode_mapel' => 'INDO101'],
            ['nama_mapel' => 'IPA', 'kode_mapel' => 'IPA101'],
            ['nama_mapel' => 'IPS', 'kode_mapel' => 'IPS101'],
            ['nama_mapel' => 'Bahasa Inggris', 'kode_mapel' => 'ENG101'],
            ['nama_mapel' => 'PPKn', 'kode_mapel' => 'PPKN101'],
        ];

        foreach ($mapels as $m) {
            Mapel::firstOrCreate(['kode_mapel' => $m['kode_mapel']], $m);
        }

        // Data Kelas
        $kelasList = ['VII A', 'VII B', 'VIII A', 'VIII B', 'IX A', 'IX B'];

        foreach ($kelasList as $kelasNama) {
            Kelas::firstOrCreate(['nama_kelas' => $kelasNama]);
        }

        // Data Guru
        $gurus = [
            [
                'nama' => 'Ahmad Yusuf',
                'email' => 'ahmad@guru.com',
                'nik' => '1987654321',
                'mengajar' => 'Matematika, IPA, PPKn',
            ],
            [
                'nama' => 'Siti Rahma',
                'email' => 'siti@guru.com',
                'nik' => '1987123456',
                'mengajar' => 'Bahasa Indonesia, Bahasa Inggris, IPS',
            ],
        ];

        foreach ($gurus as $g) {
            // Buat user
            $user = User::firstOrCreate([
                'email' => $g['email']
            ], [
                'name' => $g['nama'],
                'password' => Hash::make('password'),
                'role' => 'guru'
            ]);

            // Buat guru
            $guru = Guru::firstOrCreate([
                'user_id' => $user->id
            ], [
                'nama' => $g['nama'],
                'nik' => $g['nik'],
                'mengajar' => $g['mengajar'],
            ]);

            // Ambil mapel dan kelas
            $mapelNames = explode(',', $g['mengajar']);
            $kelasSemua = Kelas::all()->pluck('id');

            foreach ($mapelNames as $mapelNama) {
                $mapelNama = trim($mapelNama);
                $mapel = Mapel::where('nama_mapel', $mapelNama)->first();

                if ($mapel) {
                    // Assign guru ke semua kelas
                    foreach ($kelasSemua as $kelasId) {
                        GuruMapelKelas::firstOrCreate([
                            'guru_id' => $guru->id,
                            'mapel_id' => $mapel->id,
                            'kelas_id' => $kelasId,
                        ]);
                    }
                }
            }
        }
    }
}