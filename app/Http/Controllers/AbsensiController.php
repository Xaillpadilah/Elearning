<?php

namespace App\Http\Controllers;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\MapelKelas;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas; 
use App\Models\Guru;
use App\Models\GuruMapelKelas;
class AbsensiController extends Controller
{
    /**
     * Menampilkan daftar semua absensi.
     */
    public function index()
    {
         $user = Auth::user();

    // Ambil guru yang login
    $guru = Guru::where('user_id', $user->id)->first();

    if (!$guru) {
        abort(403, 'Guru tidak ditemukan');
    }

    // Ambil semua relasi kelas dan mapel yang diajar guru ini
    $relasi = GuruMapelKelas::where('guru_id', $guru->id)->get();

    // Ambil array kelas_id dan mapel_id
    $kelasIds = $relasi->pluck('kelas_id')->toArray();
    $mapelIds = $relasi->pluck('mapel_id')->toArray();

    // Ambil absensi yang sesuai dengan kelas dan mapel dari guru ini
    $absensis = Absensi::with(['siswa', 'mapel', 'kelas'])
        ->whereIn('kelas_id', $kelasIds)
        ->whereIn('mapel_id', $mapelIds)
        ->orderBy('tanggal', 'desc')
        ->get();

    return view('guru.absensi.index', [
        'absensis' => $absensis,
        'siswas' => Siswa::all(),
        'kelass' => Kelas::whereIn('id', $kelasIds)->get(),
        'mapels' => Mapel::whereIn('id', $mapelIds)->get(),
        'user' => $user
    ]);
}

    /**
     * Menampilkan form input absensi manual.
     */
    public function create()
{
   
    $user = Auth::user();
    $guru = Guru::where('user_id', $user->id)->first();

    if (!$guru) {
        abort(403, 'Guru tidak ditemukan');
    }

    // Ambil kelas dan mapel yang diajar oleh guru
    $relasi = GuruMapelKelas::where('guru_id', $guru->id)->get();

    $kelasIds = $relasi->pluck('kelas_id')->unique()->toArray();
    $mapelIds = $relasi->pluck('mapel_id')->unique()->toArray();

    $kelass = Kelas::whereIn('id', $kelasIds)->get();
    $mapels = Mapel::whereIn('id', $mapelIds)->get();

    // Ambil siswa hanya dari kelas yang diajar guru
    $siswas = Siswa::whereIn('kelas_id', $kelasIds)->get();

    return view('guru.absensi.create', compact('siswas', 'kelass', 'mapels'));
}
public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'kelas_id' => 'required|exists:kelas,id',
        'mapel_id' => 'required|exists:mapels,id',
        'siswa_ids' => 'required|array|min:1',
        'siswa_ids.*' => 'exists:siswas,id',
    ]);

    // Ambil ID guru dari tabel gurus berdasarkan user login
    $guruId = \App\Models\Guru::where('user_id', auth()->id())->value('id');

    if (!$guruId) {
        return back()->with('error', 'Guru tidak ditemukan.');
    }

    foreach ($request->siswa_ids as $siswaId) {
        \App\Models\Absensi::create([
            'siswa_id'   => $siswaId,
            'kelas_id'   => $request->kelas_id,
            'mapel_id'   => $request->mapel_id,
            'guru_id'    => $guruId,
            'tanggal'    => $request->tanggal,
            'status'     => 'hadir',
            'keterangan' => null,
        ]);
    }

    return redirect()->route('guru.absensi.index')->with('success', 'Absensi berhasil disimpan.');
}
public function update(Request $request)
{
    $request->validate([
        'absensi_id' => 'required|exists:absensis,id',
        'status' => 'required|in:hadir,izin,sakit,alpha',
        'keterangan' => 'nullable|string',
    ]);

    $absensi = Absensi::findOrFail($request->absensi_id);
    $absensi->status = $request->status; // HARUS berupa string
    $absensi->keterangan = $request->keterangan;
    $absensi->save();

    return redirect()->route('guru.absensi.index')->with('success', 'Absensi berhasil diperbarui.');
}
public function absensiSiswa()
{
    $user = Auth::user();

    // Ambil data siswa berdasarkan user login
    $siswa = Siswa::where('user_id', $user->id)->first();

    if (!$siswa) {
        abort(403, 'Siswa tidak ditemukan.');
    }

    // Ambil semua absensi milik siswa tersebut
    $absensis = Absensi::with(['mapel', 'kelas', 'guru'])
        ->where('siswa_id', $siswa->id)
        ->orderBy('tanggal', 'desc')
        ->get();

    return view('siswa.absensi.index', [
        'absensis' => $absensis,
        'siswa' => $siswa,
        'user' => $user,
        'mapels' => \App\Models\Mapel::all()
    ]);
}
}