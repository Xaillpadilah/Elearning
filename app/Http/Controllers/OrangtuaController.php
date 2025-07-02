<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
       // Halaman utama dashboard orang tua
    public function index()
    {
        $user = Auth::user();
            $user = (object) ['name' => 'Orang Tua Dummy'];

        return view('orangtua.orangtuadashboard', compact('user'));
    }

    // Halaman nilai anak
    public function nilai()
    {
        $user = Auth::user();

        // Dummy data nilai
        $nilai = [
            ['mapel' => 'Matematika', 'nilai' => 85],
            ['mapel' => 'Bahasa Indonesia', 'nilai' => 90],
            ['mapel' => 'IPA', 'nilai' => 88],
        ];

        return view('orangtua.nilai', compact('user', 'nilai'));
    }

    // Halaman absensi anak
    public function absensi()
    {
        $user = Auth::user();

        // Dummy data absensi
        $absensi = [
            ['tanggal' => '2025-06-30', 'status' => 'Hadir'],
            ['tanggal' => '2025-07-01', 'status' => 'Sakit'],
            ['tanggal' => '2025-07-02', 'status' => 'Hadir'],
        ];

        return view('orangtua.absensi', compact('user', 'absensi'));
    }

    // Halaman tugas anak
    public function tugas()
    {
        $user = Auth::user();

        // Dummy data tugas
        $tugas = [
            ['mapel' => 'IPS', 'judul' => 'Tugas Sejarah', 'status' => 'Sudah Dikerjakan'],
            ['mapel' => 'IPA', 'judul' => 'Laporan Percobaan', 'status' => 'Belum Dikerjakan'],
        ];

        return view('orangtua.tugas', compact('user', 'tugas'));
    }

    // Halaman jadwal pelajaran anak
    public function jadwal()
    {
        $user = Auth::user();

        // Dummy data jadwal
        $jadwal = [
            ['hari' => 'Senin', 'jam' => '07:00 - 08:30', 'mapel' => 'Matematika'],
            ['hari' => 'Senin', 'jam' => '08:45 - 10:15', 'mapel' => 'Bahasa Inggris'],
            ['hari' => 'Selasa', 'jam' => '07:00 - 08:30', 'mapel' => 'IPA'],
        ];

        return view('orangtua.jadwal', compact('user', 'jadwal'));
    }
}