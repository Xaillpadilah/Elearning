<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardFiturController extends Controller
{
 public function jadwalHariIni()
    {
        $user = Auth::user();
        $jadwalHariIni = 2; // data dummy
        return view('siswa.dashboard.fitur.jadwal-hari-ini', compact('user', 'jadwalHariIni'));
    }

    public function tugasHariIni()
    {
        $user = Auth::user();
        $tugasHariIni = 3; // data dummy
        return view('siswa.dashboard.fitur.tugas-hari-ini', compact('user', 'tugasHariIni'));
    }

    public function pelajaranSelanjutnya()
    {
        $user = Auth::user();
        $pelajaranSelanjutnya = [
            'jam' => '13:00',
            'mapel' => 'IPA'
        ];
        return view('siswa.dashboard.fitur.pelajaran-selanjutnya', compact('user', 'pelajaranSelanjutnya'));
    }

    public function nilaiTerbaru()
    {
        $user = Auth::user();
        $nilaiTerbaru = [
            'mapel' => 'Matematika',
            'nilai' => 87
        ];
        return view('siswa.dashboard.fitur.nilai-terbaru', compact('user', 'nilaiTerbaru'));
    }

    public function jadwalMingguan()
    {
        $user = Auth::user();
        $jadwalMingguan = 5; // data dummy
        return view('siswa.dashboard.fitur.jadwal-mingguan', compact('user', 'jadwalMingguan'));
    }

    public function tugasTerbaru()
    {
        $user = Auth::user();
        $tugasTerbaru = [
            'mapel' => 'Bahasa Indonesia',
            'judul' => 'Menulis Esai tentang Lingkungan'
        ];
        return view('siswa.dashboard.fitur.tugas-terbaru', compact('user', 'tugasTerbaru'));
    }
}