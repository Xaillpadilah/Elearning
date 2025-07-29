<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\Penilaian;
use App\Models\Mapel;
use App\Models\Orangtua;
use Illuminate\Http\Request;
use App\Models\Pengumuman; // pastikan ini ada

class OrangtuaController extends Controller
{
    public function index()
{
    $user = Auth::user(); // user yang login (orang tua)
    $orangtua = \App\Models\Orangtua::where('user_id', $user->id)->first();

    if (!$orangtua) {
        abort(404, 'Data orang tua tidak ditemukan.');
    }

    $siswa = $orangtua->siswa;

    if (!$siswa) {
        abort(404, 'Data siswa dari orang tua ini belum tersedia.');
    }

    // Ambil pengumuman untuk orang tua atau umum
    $pengumumen = Pengumuman::with('dibuat_oleh_user')
        ->whereIn('ditujukan_kepada', ['orangtua', 'semua'])
        ->latest()
        ->take(5)
        ->get();

    return view('orangtua.orangtuadashboard', compact(
        'user',
        'orangtua',
        'siswa',
        'pengumumen'
    ));
}




    // Halaman absensi anak
    public function hasil()
    {
        $user = (object) ['name' => 'Orang Tua'];

        $hasilBelajar = [
            ['mapel' => 'Matematika', 'tugas' => 85, 'ujian' => 90],
            ['mapel' => 'Bahasa Indonesia', 'tugas' => 88, 'ujian' => 87],
            ['mapel' => 'IPA', 'tugas' => 80, 'ujian' => 82],
            ['mapel' => 'IPS', 'tugas' => 75, 'ujian' => 78],
            ['mapel' => 'Bahasa Inggris', 'tugas' => 90, 'ujian' => 92],
        ];

        return view('orangtua.hasil', compact('user', 'hasilBelajar'));
    }

    // Halaman tugas anak

    public function nilaiAnak()
    {
        $user = Auth::user();

        // Ambil anak (asumsinya satu anak untuk satu orang tua)
        $siswa = Siswa::where('user_id_orangtua', $user->id)->first(); // ganti sesuai field relasi

        if (!$siswa) {
            return view('orangtua.nilai', ['penilaians' => collect(), 'siswa' => null]);
        }

        $penilaians = Penilaian::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->get();

        return view('orangtua.nilai', compact('penilaians', 'siswa'));
    }
}