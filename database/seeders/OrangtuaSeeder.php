<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Orangtua;
use Illuminate\Support\Facades\Hash;

class OrangtuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Orang Tua',
            'email' => 'ortu@example.com',
            'password' => Hash::make('ortu123'), // password
            'role' => 'orangtua'
        ]);

        Orangtua::create([
            'user_id' => $user->id,
            'nama' => 'Bapak/Ibu Andi',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Pendidikan No. 123',
        ]);
    }
}