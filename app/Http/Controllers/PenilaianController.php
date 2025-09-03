<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Ujian;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;
use App\Models\GuruMapelKelas;

class PenilaianController extends Controller
{
 public function index()
{
    $user = Auth::user();

    // Cari guru berdasarkan user_id yang sedang login
    $guru = \App\Models\Guru::where('user_id', $user->id)->first();

    if (!$guru) {
        return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
    }

    // Ambil relasi guru dengan mapel dan kelas
    $relasiGuruMapelKelas = \App\Models\GuruMapelKelas::with(['kelas', 'mapel'])
        ->where('guru_id', $guru->id)
        ->get();

    // Ambil data penilaian lengkap dengan siswa dan mapel
    $penilaians = \App\Models\Penilaian::with(['siswa', 'mapel'])->get();

    return view('guru.penilaian.index', compact('relasiGuruMapelKelas', 'penilaians'));
}public function input(Request $request)
{
    $kelas_id = $request->kelas_id;
    $mapel_id = $request->mapel_id;

    $siswa = \App\Models\Siswa::where('kelas_id', $kelas_id)->get();

    return view('guru.penilaian.input', [
        'siswaList' => $siswa,
        'kelas_id' => $kelas_id,
        'mapel_id' => $mapel_id,
    ]);
}

   public function store(Request $request)
{
    $request->validate([
        'mapel_id' => 'required|exists:mapels,id',
        'kelas_id' => 'required|exists:kelas,id',
        'nilai.*.tugas' => 'required|numeric',
        'nilai.*.kuis' => 'required|numeric',
        'nilai.*.uts' => 'required|numeric',
        'nilai.*.uas' => 'required|numeric',
        'nilai.*.catatan' => 'nullable|string',
    ]);

    $guru = Guru::where('user_id', Auth::id())->first();

   foreach ($request->nilai as $siswa_id => $nilai) {
    Penilaian::updateOrCreate(
        [
            'siswa_id' => $siswa_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $guru->id,
            'kelas_id' => $request->kelas_id,
        ],
        [
            'nilai_tugas' => $nilai['tugas'] ?? 0,
            'nilai_kuis' => $nilai['kuis'] ?? 0,
            'nilai_uts' => $nilai['uts'] ?? 0,
            'nilai_uas' => $nilai['uas'] ?? 0,
            'catatan' => $nilai['catatan'] ?? '',
        ]
    );

    }

    return redirect()->route('guru.penilaian.index')->with('success', 'Nilai berhasil disimpan.');
}

   public function updateMultiple(Request $request)
{
    // Validasi inputan
    $request->validate([
        'penilaian_ids' => 'required|array',
        'nilai' => 'required|array',
    ]);

    foreach ($request->penilaian_ids as $index => $id) {
        $penilaian = Penilaian::find($id);
        $nilai = $request->nilai[$index] ?? null;

        // Pastikan data penilaian dan nilai tersedia
        if ($penilaian && is_array($nilai)) {
            // Update data penilaian
            $penilaian->update([
                'nilai_tugas' => isset($nilai['tugas']) ? floatval($nilai['tugas']) : 0,
                'nilai_kuis'  => isset($nilai['kuis']) ? floatval($nilai['kuis']) : 0,
                'nilai_uts'   => isset($nilai['uts']) ? floatval($nilai['uts']) : 0,
                'nilai_uas'   => isset($nilai['uas']) ? floatval($nilai['uas']) : 0,
                'catatan'     => $nilai['catatan'] ?? '',
            ]);
        }
    }

    // Redirect dengan pesan berbeda jika nilai dikirim ke siswa
    if ($request->has('kirim_ke_siswa')) {
        return redirect()->route('siswa.nilai.index')
            ->with('success', 'Nilai berhasil dikirim dan ditampilkan ke siswa.');
    }

    return back()->with('success', 'Data nilai berhasil diperbarui.');
}

}

