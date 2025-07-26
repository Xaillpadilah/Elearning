<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\SoalUjian;
use Illuminate\Support\Facades\Auth;
use App\Models\GuruMapelKelas;
class PembelajaranController extends Controller
{
   public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Asumsikan ID guru sama dengan ID user (bisa disesuaikan)
        $guruId = $user->id;

        // Ambil semua data mapel dan kelas yang diajar guru
        $pengampu = GuruMapelKelas::with(['kelas', 'mapel'])
            ->where('guru_id', $guruId)
            ->get();

        // Kirim data ke view
        return view('guru.menu', [
            'user' => $user,
            'pengampu' => $pengampu,
        ]);
    }
}

