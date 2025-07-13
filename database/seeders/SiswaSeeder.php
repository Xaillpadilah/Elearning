<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $kelasList = Kelas::all();

        foreach ($kelasList as $kelas) {
            for ($i = 0; $i < ($kelas->jumlah_siswa ?? 5); $i++) {
                $email = $faker->unique()->safeEmail;

                // Cek agar tidak ada duplikat email
                if (!User::where('email', $email)->exists()) {
                    $user = User::create([
                        'name' => $faker->name,
                        'email' => $email,
                        'password' => Hash::make('siswa123'),
                        'role' => 'siswa',
                    ]);

                    Siswa::create([
                        'user_id' => $user->id,
                        'nama' => $user->name,
                        'email' => $user->email,
                        'nisn' => $faker->unique()->numerify('##########'),
                        'kelas_id' => $kelas->id,
                    ]);
                }
            }
        }

        // Cek apakah ada kelas untuk siswa manual
        $kelasPertama = $kelasList->first();

        if ($kelasPertama) {
            $user = User::updateOrCreate(
                ['email' => 'siswa@example.com'],
                [
                    'name' => 'Siswa Pertama',
                    'password' => Hash::make('siswa123'),
                    'role' => 'siswa',
                ]
            );

            Siswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama' => 'Siswa Pertama',
                    'email' => $user->email, // ✅ tambahkan ini
                    'nisn' => '1234567890',
                    'kelas_id' => $kelasPertama->id,
                ]
            );
        } else {
            $this->command->warn('Tidak ada data kelas. Silakan jalankan KelasSeeder terlebih dahulu.');
        }
    }
}
