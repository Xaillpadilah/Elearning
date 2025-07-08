<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    
      public function index()
    {
        $user = auth()->user(); // ambil user login

        // Dummy data (sementara, nanti bisa diganti dari DB)
        $jadwalHariIni = 3;
        $daftarSiswa = 120;
        $materiBaru = 5;
        $tugasBaru = 4;
        $pengumuman = 2;

        return view('guru.dashboardguru', compact(
            'user',
            'jadwalHariIni',
            'daftarSiswa',
            'materiBaru',
            'tugasBaru',
            'pengumuman'
        ));
    }
}

