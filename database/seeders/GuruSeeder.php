<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = [
            ['nama' => 'Budi Santosa, S.Pd', 'nik' => '197001010001', 'jenis_kelamin' => 'Laki-laki', 'email' => 'budi.santosa@smpn5.sch.id'],
            ['nama' => 'Siti Marlina, M.Pd', 'nik' => '197002020002', 'jenis_kelamin' => 'Perempuan', 'email' => 'siti.marlina@smpn5.sch.id'],
            ['nama' => 'Ahmad Fadli, S.Pd.I', 'nik' => '197003030003', 'jenis_kelamin' => 'Laki-laki', 'email' => 'ahmad.fadli@smpn5.sch.id'],
            ['nama' => 'Dewi Kartika, M.Pd', 'nik' => '197004040004', 'jenis_kelamin' => 'Perempuan', 'email' => 'dewi.kartika@smpn5.sch.id'],
            ['nama' => 'Agus Supriyadi, S.Pd', 'nik' => '197005050005', 'jenis_kelamin' => 'Laki-laki', 'email' => 'agus.supriyadi@smpn5.sch.id'],
            ['nama' => 'Rina Melati, M.Pd', 'nik' => '197006060006', 'jenis_kelamin' => 'Perempuan', 'email' => 'rina.melati@smpn5.sch.id'],
            ['nama' => 'Dedi Pratama, S.Pd', 'nik' => '197007070007', 'jenis_kelamin' => 'Laki-laki', 'email' => 'dedi.pratama@smpn5.sch.id'],
            ['nama' => 'Nurul Hidayati, M.Pd', 'nik' => '197008080008', 'jenis_kelamin' => 'Perempuan', 'email' => 'nurul.hidayati@smpn5.sch.id'],
            ['nama' => 'Joko Wibowo, S.Pd', 'nik' => '197009090009', 'jenis_kelamin' => 'Laki-laki', 'email' => 'joko.wibowo@smpn5.sch.id'],
           

        ];

        foreach ($gurus as $g) {
            $user = User::create([
                'name' => $g['nama'],
                'email' => $g['email'],
                'password' => Hash::make('gurusmp5'), // default password
                'role' => 'guru'
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nama' => $g['nama'],
                'nik' => $g['nik'],
                'jenis_kelamin' => $g['jenis_kelamin']
            ]);
        }
    }
}
