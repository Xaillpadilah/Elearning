<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Absensi;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\Pengumuman;
use App\Models\JawabanTugas;
use App\Models\JawabanUjian;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
class GuruController extends Controller
{
    /**
     * Tampilkan dashboard guru
     */
    public function Dashboard()
{
    $user = auth()->user();

    // Ambil guru login
    $guru = \App\Models\Guru::where('user_id', $user->id)->first();

    if (!$guru) {
        abort(403, 'Guru tidak ditemukan');
    }

    // Relasi guru
    $relasi = \App\Models\GuruMapelKelas::with(['kelas', 'mapel'])
        ->where('guru_id', $guru->id)
        ->get();

    $kelasIds = $relasi->pluck('kelas_id')->toArray();
    $mapelIds = $relasi->pluck('mapel_id')->toArray();

    // Data ujian
    $ujians = \App\Models\Ujian::with('relasi.kelas', 'relasi.mapel')
        ->whereHas('relasi', function ($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        })->latest()->take(3)->get();

    // Data tugas
    $tugas = \App\Models\Tugas::with('relasi.kelas', 'relasi.mapel')
        ->whereHas('relasi', function ($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        })->latest()->take(3)->get();

    // Data materi
    $materis = \App\Models\Materi::with(['mapel', 'kelas'])
        ->whereIn('mapel_id', $mapelIds)
        ->whereIn('kelas_id', $kelasIds)
        ->latest()->take(3)->get();

    // Data absensi
    $absensis = \App\Models\Absensi::with(['siswa', 'kelas', 'mapel'])
        ->whereIn('mapel_id', $mapelIds)
        ->whereIn('kelas_id', $kelasIds)
        ->latest()->take(5)->get();

    // ✅ Tambahkan pengumuman untuk guru
    $pengumumen = \App\Models\Pengumuman::with('dibuat_oleh_user')
        ->whereIn('ditujukan_kepada', ['guru', 'semua'])
        ->latest()
        ->take(5)
        ->get();

    return view('guru.dashboardguru', compact(
        'user',
        'ujians',
        'tugas',
        'materis',
        'absensis',
        'pengumumen' // Tambahkan ke compact
    ));
}

public function jawaban()
{
    $user = Auth::user();

    if (!$user->guru) {
        abort(403, 'Hanya guru yang dapat mengakses halaman ini.');
    }

  $jawabanTugas = JawabanTugas::with(['siswa.user'])->get();
    $jawabanUjian = JawabanUjian::with(['user', 'ujian'])->get();

    // Ambil SQL-nya
    $query = JawabanTugas::select('id', 'tugas_id', 'siswa_id', 'jawaban', 'file_jawaban', 'skor', 'created_at', 'updated_at')->toSql();

    return view('guru.jawaban.index', compact('jawabanTugas', 'jawabanUjian', 'query'));
}
public function profil()
{
    $user = Auth::user();
    $guru = $user->guru;

    return view('guru.profil', compact('user', 'guru'));
}

public function updateProfil(Request $request)
{
    $user = Auth::user();
    $guru = $user->guru;

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'foto' => 'nullable|image|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('foto_guru', 'public');
        $user->foto = $path;
    }

    $user->save();

    return redirect()->route('guru.profil')->with('success', 'Profil berhasil diperbarui.');
}
}
