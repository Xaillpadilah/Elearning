<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\GuruMapelKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class TugasController extends Controller
{
    
    public function index()
    {
         $user = Auth::user();

    // Ambil guru yang login
    $guru = \App\Models\Guru::where('user_id', $user->id)->first();

    // Ambil semua tugas (opsional bisa filter juga berdasarkan guru)
    $tugas = \App\Models\Tugas::with('relasi.kelas', 'relasi.mapel')
        ->whereHas('relasi', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })
        ->get();

    // Ambil hanya relasi milik guru login
    $relasi = \App\Models\GuruMapelKelas::with(['kelas', 'mapel'])
        ->where('guru_id', $guru->id)
        ->get();

    return view('guru.tugas.index', compact('tugas', 'relasi'));
}

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|in:tugas,kuis',
            'tanggal_deadline' => 'nullable|date',
            'guru_mapel_kelas_id' => 'required|exists:guru_mapel_kelas,id',
            'file_upload' => 'nullable|file|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $filePath = null;
        if ($request->hasFile('file_upload')) {
            $filePath = $request->file('file_upload')->store('tugas', 'public');
        }
        

        Tugas::create([
            'judul' => $request->judul,
            'jenis' => $request->jenis,
            'tanggal_deadline' => $request->tanggal_deadline,
            'guru_mapel_kelas_id' => $request->guru_mapel_kelas_id,
            'file_path' => $filePath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|in:tugas,kuis',
            'tanggal_deadline' => 'nullable|date',
            'guru_mapel_kelas_id' => 'required|exists:guru_mapel_kelas,id',
            'file_upload' => 'nullable|file|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('file_upload')) {
            if ($tugas->file_path) {
                Storage::disk('public')->delete($tugas->file_path);
            }
            $tugas->file_path = $request->file('file_upload')->store('tugas', 'public');
        }

        $tugas->update([
            'judul' => $request->judul,
            'jenis' => $request->jenis,
            'tanggal_deadline' => $request->tanggal_deadline,
            'guru_mapel_kelas_id' => $request->guru_mapel_kelas_id,
            'deskripsi' => $request->deskripsi,
            'file_path' => $tugas->file_path,
        ]);
 
        return redirect()->back()->with('success', 'Tugas berhasil diperbarui.');
    }


    public function destroy($id)
{
    $tugas = Tugas::findOrFail($id);
    $this->checkAksesGuru($tugas);

    $tugas->delete();

    return back()->with('success', 'Tugas berhasil dihapus.');
}
   public function kirim($id)
{
    $tugas = Tugas::findOrFail($id);
    
    // Acak pertanyaan (jika ada detail soal) — contoh implementasi untuk data acak
    // Misal: $tugas->soal adalah array / JSON dari soal
    if (!empty($tugas->soal)) {
        $soal = json_decode($tugas->soal, true);
        $shuffledSoal = $this->fisherYatesShuffle($soal);
        $tugas->soal = json_encode($shuffledSoal);
    }

    $tugas->update(['dikirim' => true]);

    return redirect()->back()->with('success', 'Tugas berhasil dikirim ke siswa dengan soal teracak.');
}
// ✅ Fungsi bantu ini diletakkan di dalam controller ini
    private function checkAksesGuru($tugas)
    {
       $guru = Auth::user()->guru; // Ambil model Guru dari User yang login
$mapels = $guru->mapels;    // Ambil relasi mapel dari Guru
        $allowedIds = $guru->mapelKelas->pluck('id')->toArray();

        if (!in_array($tugas->guru_mapel_kelas_id, $allowedIds)) {
            abort(403, 'Anda tidak memiliki akses untuk tugas ini.');
        }
    }

    // ✅ Fungsi bantu untuk validasi dari form input (id langsung)

     private function fisherYatesShuffle(array $array)
    {
        $n = count($array);
        for ($i = $n - 1; $i > 0; $i--) {
            $j = rand(0, $i);
            $temp = $array[$i];
            $array[$i] = $array[$j];
            $array[$j] = $temp;
        }
        return $array;
    }

}