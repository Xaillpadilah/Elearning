<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
     // Dashboard Admin
    public function dashboard()
    {
        $user = auth()->user();

        // Kamu bisa tambahkan data ringkasan di sini jika perlu
        $jumlahGuru = 10; // Dummy
        $jumlahSiswa = 100; // Dummy
        $jumlahKelas = 6;

        return view('admin.dashboard', compact('user', 'jumlahGuru', 'jumlahSiswa', 'jumlahKelas'));
    }

    public function guru()
    {
        $user = auth()->user();
        $daftarGuru = [
            ['nama' => 'Ahmad Syarif', 'mapel' => 'Matematika'],
            ['nama' => 'Siti Rahma', 'mapel' => 'IPA'],
        ];
        return view('admin.guru.index', compact('user', 'daftarGuru'));
    }

    public function siswa()
    {
        $user = auth()->user();
        $daftarSiswa = [
            ['nama' => 'Budi', 'kelas' => '7A'],
            ['nama' => 'Ani', 'kelas' => '8B'],
        ];
        return view('admin.siswa.index', compact('user', 'daftarSiswa'));
    }

    public function kelas()
    {
        $user = auth()->user();
        $daftarKelas = ['7A', '7B', '8A', '8B', '9A'];
        return view('admin.kelas.index', compact('user', 'daftarKelas'));
    }

    public function mapel()
    {
        $user = auth()->user();
        $daftarMapel = ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'Bahasa Inggris'];
        return view('admin.mapel.index', compact('user', 'daftarMapel'));
    }

    public function pengumuman()
    {
        $user = auth()->user();
        $pengumuman = [
            ['judul' => 'Ujian Tengah Semester', 'tanggal' => '2025-09-15'],
            ['judul' => 'Libur Akhir Tahun', 'tanggal' => '2025-12-20'],
        ];
        return view('admin.pengumuman.index', compact('user', 'pengumuman'));
    }
}