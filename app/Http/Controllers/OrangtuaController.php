<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\Penilaian;
use App\Models\Mapel;
use App\Models\Orangtua;
use Illuminate\Http\Request;
use App\Models\Pengumuman; // pastikan ini ada
use App\Models\Siswa;
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
    $user = auth()->user();
    $siswa = $user->anak;

    $penilaianBulan = collect();
    $penilaianSemester = collect();
    $kehadiranBulan = collect();

    if ($siswa) {
        // Penilaian 1 bulan terakhir
        $penilaianBulan = $siswa->penilaians()
            ->with('mapel')
            ->where('created_at', '>=', now()->subMonth())
            ->get();

        // Penilaian 6 bulan terakhir (semester)
        $penilaianSemester = $siswa->penilaians()
            ->with('mapel')
            ->where('created_at', '>=', now()->subMonths(6))
            ->get();

        
    }

    return view('orangtua.hasil', compact(
        'penilaianBulan',
        'penilaianSemester',
        'kehadiranBulan'
    ));
}

}