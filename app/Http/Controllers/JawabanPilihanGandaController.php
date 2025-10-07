<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JawabanUjian;
use App\Models\Ujian;

class JawabanPilihanGandaController extends Controller
{
    // Misal di UjianPilihanGandaController
public function store(Request $request)
{
    $ujian = Ujian::findOrFail($request->ujian_id);
    $jawabanSiswa = $request->input('jawaban');

    $jumlahSoal = $ujian->soals->count();
    $jawabanBenar = 0;

    foreach ($ujian->soals as $soal) {
        if (isset($jawabanSiswa[$soal->id]) && $jawabanSiswa[$soal->id] === $soal->kunci_jawaban) {
            $jawabanBenar++;
        }
    }

    $skor = ($jawabanBenar / $jumlahSoal) * 100;

    JawabanUjian::create([
        'ujian_id' => $ujian->id,
        'user_id' => auth()->id(),
        'skor' => round($skor),
        
    ]);

    return redirect()->back()->with('success', 'Jawaban berhasil dikirim!');
}
}
