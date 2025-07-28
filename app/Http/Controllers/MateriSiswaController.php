<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;

class MateriSiswaController extends Controller
{
    public function index()
{
    $materis = Materi::with(['mapel', 'kelas', 'uploader'])
        ->get(); // Tanpa where('kelas_id', ...) agar semua ditampilkan

    return view('siswa.materi.index', compact('materis'));
}
public function showByMapel($mapel_id)
{
    $user = Auth::user();

    if ($user->role !== 'siswa') {
        abort(403, 'Hanya siswa yang dapat mengakses materi.');
    }

    $mapel = Mapel::findOrFail($mapel_id);

    $materis = Materi::with(['mapel', 'kelas', 'uploader']) // Relasi opsional
        ->where('mapel_id', $mapel_id)
        ->where('kelas_id', $user->kelas_id)
        ->where('status_kirim', 'terkirim')
        ->get();

    return view('siswa.materi.index', compact('materis', 'mapel'));
}
    
}
