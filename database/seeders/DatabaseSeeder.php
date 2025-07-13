<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            KelasSeeder::class,
            UserSeeder::class,
            AdminUserSeeder::class,
            GuruSeeder::class,
            OrangtuaSeeder::class,
            SiswaSeeder::class, // ← ditempatkan setelah User dan Kelas
            PengumumanSeeder::class,
            MateriSeeder::class,
             GuruMapelSeeder::class,
               GuruMapelKelasSeeder::class,
    ]);// ← tambahkan baris ini
    

        // Jika masih ingin menggunakan factory (opsional):
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
    
}
