<?php

namespace App\Http\Controllers;

use App\Models\SoalUjian;
use Illuminate\Http\Request;
use App\Models\Ujian;
class SoalUjianController extends Controller
{
    public function index(Ujian $ujian)
    {
        $soals = SoalUjian::where('ujian_id', $ujian->id)->orderBy('nomor_urut')->get();
        return view('guru.soal.index', compact('ujian', 'soals'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'ujian_id' => 'required|exists:ujians,id',
        'nomor' => 'required|integer',
        'pertanyaan' => 'required|string',
        'opsi_a' => 'required|string',
        'opsi_b' => 'required|string',
        'opsi_c' => 'required|string',
        'opsi_d' => 'required|string',
        'jawaban_benar' => 'required|in:A,B,C,D',
    ]);

    $soal = \App\Models\SoalUjian::create($validated);

    return response()->json([
        'success' => true,
        'soal' => $soal,
    ]);
}
public function showUjian($id)
{
    $ujian = Ujian::with('soals')->findOrFail($id);
    $soals = $ujian->soals; // relasi one-to-many

    return view('guru.ujian.show', compact('ujian', 'soals'));
}


    public function update(Request $request, $id)
    {
        $soal = SoalUjian::findOrFail($id);

        $request->validate([
            'nomor_urut' => 'required|integer',
            'tipe' => 'required|in:pilihan_ganda,essai',
            'soal' => 'required|string',
            'jawaban_benar' => 'required|string',
        ]);

        $soal->update([
            'nomor_urut' => $request->nomor_urut,
            'tipe' => $request->tipe,
            'soal' => $request->soal,
            'opsi' => $request->tipe == 'pilihan_ganda' ? $request->opsi : null,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return back()->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $soal = SoalUjian::findOrFail($id);
        $soal->delete();

        return back()->with('success', 'Soal berhasil dihapus.');
    }
}

