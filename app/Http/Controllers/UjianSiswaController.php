<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Ujian;

class UjianSiswaController extends Controller
{
  public function index()
{
    $siswaId = auth()->id();

    $ujians = \App\Models\Ujian::whereHas('guruMapelKelas.kelas.siswa', function ($query) use ($siswaId) {
        $query->where('id', $siswaId);
    })->orderBy('tanggal', 'desc')->get();

    return view('siswa.ujian.index', compact('ujians'));
}

}