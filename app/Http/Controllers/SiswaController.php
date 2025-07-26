<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\Video;
class SiswaController extends Controller
{
    // Halaman Dashboard Siswa
    public function index()
    {
     
        $siswa = Auth::user();
        $mapels = Mapel::all(); // Ambil semua mapel untuk ditampilkan
        return view('siswa.siswadashboard', compact('mapels'));
    }

    // Halaman Daftar Semua Mata Pelajaran
    public function mapel()
    {
        
        $siswa = Auth::user();
        $mapels = Mapel::all(); // Ambil semua mapel
        return view('siswa.mapel.index', compact('mapels'));
    }

    // Halaman Detail Mata Pelajaran + Materi berdasarkan kelas siswa
    public function show($id)
    {
     
        $siswa = Auth::user();
        $mapel = Mapel::findOrFail($id);     // Ambil mapel berdasarkan ID
        $mapels = Mapel::all();              // Ambil semua mapel (untuk sidebar, dll)

        $siswa = Auth::user();               // Ambil user yang sedang login (siswa)
        $kelasId = $siswa->kelas_id ?? null; // Ambil kelas_id dari siswa

        // Ambil materi berdasarkan mapel_id & kelas_id
        $materis = Materi::where('mapel_id', $id)
                         ->when($kelasId, function ($query, $kelasId) {
                             return $query->where('kelas_id', $kelasId);
                         })
                         ->latest()
                         ->get();

        return view('siswa.mapel.index', compact('mapel', 'mapels', 'materis'));
    }public function materi($id)
{
    
        $siswa = Auth::user();
    $mapels = Mapel::all(); // untuk sidebar
    $materis = Materi::where('mapel_id', $id)->get();
    $mapelAktif = Mapel::find($id);

    return view('siswa.mapel.index', compact('materis', 'mapels', 'mapelAktif'));
}
public function tugas($id)
{
     
    // tampilkan tugas berdasarkan mapel_id
}

public function ujian($id)
{
       // tampilkan ujian berdasarkan mapel_id
}

public function video($id)
{
         // tampilkan video berdasarkan mapel_id
}
public function boot(): void
{
     
        $siswa = Auth::user();
    View::composer('siswa.*', function ($view) {
        $view->with('mapels', Mapel::all());
    });
}
public function absensi()
{
       
    // Ambil data absensi siswa
    $absensi = []; // ganti dengan data dari model jika sudah ada

    return view('siswa.absensi.index', compact('absensi'));
}
public function nilai()
{
         
    // Dummy data nilai (bisa ganti dengan ambil dari database)
    $nilai = [
        ['mapel' => 'Matematika', 'nilai' => 85],
        ['mapel' => 'Bahasa Indonesia', 'nilai' => 90],
        ['mapel' => 'IPA', 'nilai' => 88],
    ];

    return view('siswa.nilai.index', compact('nilai'));
}

}
