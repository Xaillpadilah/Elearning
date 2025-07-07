<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Chat;

use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
       // Halaman utama dashboard orang tua
    public function index()
    {
         $user = (object)[
            'name' => 'Orang Tua'
        ];

        // Data Dummy dari database (bisa diganti nanti)
        $nilaiAnak = [
            'Matematika' => 85,
            'IPA' => 90,
            'Bahasa Indonesia' => 88,
            'IPS' => 82,
            'PKN' => 89
        ];

        $kehadiran = [
            'Senin' => 4,
            'Selasa' => 3,
            'Rabu' => 5,
            'Kamis' => 4,
            'Jumat' => 5
        ];

        $perkembanganTugas = [
            'Matematika' => 5,
            'IPA' => 4,
            'Bahasa Indonesia' => 6,
            'IPS' => 5,
            'PKN' => 3
        ];

        $pengumuman = [
        ['tanggal' => '13 Juli 2025', 'isi' => 'Ujian tengah semester dimulai pekan depan, mohon persiapkan anak Anda.'],
        ['tanggal' => '10 Juli 2025', 'isi' => 'Libur sekolah pada tanggal 17 Juli dalam rangka Hari Besar Nasional.'],
        ['tanggal' => '5 Juli 2025', 'isi' => 'Vaksinasi rutin diadakan di sekolah, pastikan anak membawa surat izin.'],
    ];

         return view('orangtua.orangtuadashboard', compact('user', 'nilaiAnak', 'kehadiran', 'perkembanganTugas', 'pengumuman'));
    }

    
    // Halaman absensi anak
    public function hasil()
    {
        $user = (object)['name' => 'Orang Tua'];

    $hasilBelajar = [
        ['mapel' => 'Matematika', 'tugas' => 85, 'ujian' => 90],
        ['mapel' => 'Bahasa Indonesia', 'tugas' => 88, 'ujian' => 87],
        ['mapel' => 'IPA', 'tugas' => 80, 'ujian' => 82],
        ['mapel' => 'IPS', 'tugas' => 75, 'ujian' => 78],
        ['mapel' => 'Bahasa Inggris', 'tugas' => 90, 'ujian' => 92],
    ];

    return view('orangtua.hasil', compact('user', 'hasilBelajar'));
}

    // Halaman tugas anak
    public function perkembangan()
    {
       $user = (object)['name' => 'Orang Tua'];

    $perkembanganBulanan = [
        '1 Jul' => 2, '5 Jul' => 4, '10 Jul' => 3,
        '15 Jul' => 5, '20 Jul' => 4, '25 Jul' => 3, '30 Jul' => 4
    ];

    $belajarSemester = [
        'Matematika' => 85,
        'IPA' => 88,
        'Bahasa Indonesia' => 90,
        'IPS' => 83,
        'Bahasa Inggris' => 87
    ];

    $ekskul = [
        ['nama' => 'Pramuka', 'kehadiran' => 90],
        ['nama' => 'Futsal', 'kehadiran' => 85],
        ['nama' => 'Paduan Suara', 'kehadiran' => 80]
    ];

    return view('orangtua.perkembangan', compact('user', 'perkembanganBulanan', 'belajarSemester', 'ekskul'));
}

   
    //komunikasi
    public function komunikasi()
{
    $user = Auth::user();
    $chats = Chat::orderBy('created_at', 'asc')->get(); // Sesuaikan dengan user_id jika perlu
    return view('orangtua.komunikasi', compact('user', 'chats'));
}

public function kirimPesan(Request $request)
{
    Chat::create([
        'from' => 'orangtua',
        'message' => $request->message,
    ]);

    return redirect()->route('orangtua.komunikasi');
}
}