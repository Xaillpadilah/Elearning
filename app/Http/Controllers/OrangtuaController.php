<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
 // Halaman utama dashboard orang tua
    
    // Dashboard utama orang tua
    public function index()
    {
        $user = auth()->user();

        $jadwalHariIni = 3;
        $tugasHariIni = 2;
        $pelajaranSelanjutnya = ['mapel' => 'Bahasa Indonesia', 'jam' => '10:30 - 11:30'];
        $nilaiTerbaru = ['mapel' => 'Matematika', 'nilai' => 88];
        $jadwalMingguan = 12;
        $tugasTerbaru = ['mapel' => 'IPA', 'judul' => 'Kerjakan soal bab 3 halaman 45-46'];

        return view('orangtua.dashboardorangtua', compact(
            'user', 'jadwalHariIni', 'tugasHariIni',
            'pelajaranSelanjutnya', 'nilaiTerbaru',
            'jadwalMingguan', 'tugasTerbaru'
        ));
    }

    public function anak()
    {
        $anak = [
            'nama' => 'Rizki Ramadhan',
            'nis' => '20250123',
            'kelas' => '8B',
            'jenis_kelamin' => 'Laki-laki',
            'foto' => 'assets/image/siswa1.png',
        ];

        return view('orangtua.anak', compact('anak'));
    }

    public function nilai()
    {
        $nilaiAnak = [
            ['mapel' => 'Matematika', 'nilai' => 88],
            ['mapel' => 'IPA', 'nilai' => 91],
            ['mapel' => 'IPS', 'nilai' => 84],
        ];

        return view('orangtua.nilai', compact('nilaiAnak'));
    }

    public function absensi()
    {
        $absensi = [
            ['tanggal' => '2025-07-01', 'status' => 'Hadir'],
            ['tanggal' => '2025-07-02', 'status' => 'Hadir'],
            ['tanggal' => '2025-07-03', 'status' => 'Izin'],
        ];

        return view('orangtua.absensi', compact('absensi'));
    }

    public function catatan()
    {
        $catatan = [
            ['tanggal' => '2025-07-01', 'guru' => 'Bu Siti', 'isi' => 'Anak perlu meningkatkan fokus saat pelajaran.'],
            ['tanggal' => '2025-06-28', 'guru' => 'Pak Dedi', 'isi' => 'Tugas dikerjakan dengan baik dan tepat waktu.']
        ];

        return view('orangtua.catatan', compact('catatan'));
    }

    public function jadwalHariIni()
    {
        $jadwal = [
            ['jam' => '07:00 - 08:30', 'mapel' => 'Matematika'],
            ['jam' => '08:45 - 10:15', 'mapel' => 'IPA'],
            ['jam' => '10:30 - 11:30', 'mapel' => 'IPS'],
        ];

        return view('orangtua.jadwal.hariini', compact('jadwal'));
    }

    public function tugasHariIni()
    {
        $tugas = [
            ['mapel' => 'Bahasa Indonesia', 'judul' => 'Menulis Puisi', 'deadline' => 'Hari Ini'],
            ['mapel' => 'IPS', 'judul' => 'Kerjakan soal latihan 5', 'deadline' => 'Hari Ini']
        ];

        return view('orangtua.tugas.hariini', compact('tugas'));
    }

    public function pelajaranSelanjutnya()
    {
        $pelajaran = ['mapel' => 'Bahasa Inggris', 'jam' => '13:00 - 14:30'];

        return view('orangtua.pelajaran.selanjutnya', compact('pelajaran'));
    }

    public function nilaiTerbaru()
    {
        $nilai = ['mapel' => 'IPA', 'nilai' => 91, 'tanggal' => '2025-07-02'];

        return view('orangtua.nilai.terbaru', compact('nilai'));
    }

    public function jadwalMingguan()
    {
        $mingguan = [
            ['hari' => 'Senin', 'mapel' => ['Matematika', 'Bahasa Inggris']],
            ['hari' => 'Selasa', 'mapel' => ['IPA', 'IPS']],
            ['hari' => 'Rabu', 'mapel' => ['Bahasa Indonesia', 'PKN']],
        ];

        return view('orangtua.jadwal.mingguan', compact('mingguan'));
    }

    public function tugasTerbaru()
    {
        $tugas = [
            'mapel' => 'Bahasa Sunda',
            'judul' => 'Tugas Membuat Cerita Pendek',
            'tanggal' => '2025-07-01'
        ];

        return view('orangtua.tugas.terbaru', compact('tugas'));
    }
}