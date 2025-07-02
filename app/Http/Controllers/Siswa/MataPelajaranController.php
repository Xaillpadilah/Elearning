<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class MataPelajaranController extends Controller
{
     protected $dataMapel = [];

    public function __construct()
    {
        $this->dataMapel = [
            1 => [
                'kode' => 'SMP001',
                'nama' => 'Matematika',
                'sks' => 0,
                'ruangan' => 'Kelas 7A',
                'Guru' => 'Ibu Rina Susanti, S.Pd.',
                'email' => 'rina.susanti@smpn1.sch.id',
                'hari' => 'Senin',
                'jam' => '07:00 - 08:30',
            ],
            2 => [
                'kode' => 'SMP002',
                'nama' => 'Bahasa Indonesia',
                'sks' => 0,
                'ruangan' => 'Kelas 7B',
                'Guru' => 'Bapak Ahmad Hidayat, S.Pd.',
                'email' => 'ahmad.hidayat@smpn1.sch.id',
                'hari' => 'Selasa',
                'jam' => '08:45 - 10:15',
            ],
            3 => [
                'kode' => 'SMP003',
                'nama' => 'Ilmu Pengetahuan Alam (IPA)',
                'sks' => 0,
                'ruangan' => 'Lab IPA',
                'Guru' => 'Ibu Fitriani, S.Pd.',
                'email' => 'fitriani@smpn1.sch.id',
                'hari' => 'Rabu',
                'jam' => '10:30 - 12:00',
            ],
            4 => [
                'kode' => 'SMP004',
                'nama' => 'Ilmu Pengetahuan Sosial (IPS)',
                'sks' => 0,
                'ruangan' => 'Kelas 7C',
                'Guru' => 'Bapak Andi Saputra, S.Pd.',
                'email' => 'andi.saputra@smpn1.sch.id',
                'hari' => 'Kamis',
                'jam' => '07:00 - 08:30',
            ],
            5 => [
                'kode' => 'SMP005',
                'nama' => 'Bahasa Inggris',
                'sks' => 0,
                'ruangan' => 'Kelas 7A',
                'Guru' => 'Miss Sarah Olivia, S.Pd.',
                'email' => 'sarah.olivia@smpn1.sch.id',
                'hari' => 'Jumat',
                'jam' => '08:45 - 10:15',
            ],
            6 => [
                'kode' => 'SMP006',
                'nama' => 'Pendidikan Pancasila dan Kewarganegaraan (PPKn)',
                'sks' => 0,
                'ruangan' => 'Kelas 7B',
                'Guru' => 'Ibu Neni Yuliani, S.Pd.',
                'email' => 'neni.yuliani@smpn1.sch.id',
                'hari' => 'Senin',
                'jam' => '10:30 - 12:00',
            ],
            7 => [
                'kode' => 'SMP007',
                'nama' => 'Pendidikan Jasmani dan Kesehatan (Penjaskes)',
                'sks' => 0,
                'ruangan' => 'Lapangan Sekolah',
                'Guru' => 'Pak Yoga Pratama, S.Or.',
                'email' => 'yoga.pratama@smpn1.sch.id',
                'hari' => 'Selasa',
                'jam' => '07:00 - 08:30',
            ],
            8 => [
                'kode' => 'SMP008',
                'nama' => 'Seni Budaya',
                'sks' => 0,
                'ruangan' => 'Ruang Seni',
                'Guru' => 'Ibu Lisa Mariana, S.Pd.',
                'email' => 'lisa.mariana@smpn1.sch.id',
                'hari' => 'Rabu',
                'jam' => '08:45 - 10:15',
            ],
            9 => [
                'kode' => 'SMP009',
                'nama' => 'Prakarya',
                'sks' => 0,
                'ruangan' => 'Lab Keterampilan',
                'Guru' => 'Bapak Wahyu Rahmat, S.Pd.',
                'email' => 'wahyu.rahmat@smpn1.sch.id',
                'hari' => 'Kamis',
                'jam' => '10:30 - 12:00',
            ],
            10 => [
                'kode' => 'SMP010',
                'nama' => 'Bahasa Daerah',
                'sks' => 0,
                'ruangan' => 'Kelas 7C',
                'Guru' => 'Ibu Sari Dewi, S.Pd.',
                'email' => 'sari.dewi@smpn1.sch.id',
                'hari' => 'Jumat',
                'jam' => '07:00 - 08:30',
            ],
        ];
    }

    public function show($id)
    {
        if (!isset($this->dataMapel[$id])) {
            abort(404, 'Mata pelajaran tidak ditemukan.');
        }

        $mapel = $this->dataMapel[$id];
        $mapel['id'] = $id;
        $mataPelajaran = $this->generateListWithId();
        $user = Auth::user();

        return view('siswa.siswadetail', compact('mapel', 'mataPelajaran', 'user'));
    }

    public function materi($id)
    {
        if (!isset($this->dataMapel[$id])) {
            abort(404, 'Mata pelajaran tidak ditemukan.');
        }

        $mapel = $this->dataMapel[$id];
        $mapel['id'] = $id;

        $materis = [
            ['pertemuan' => 1, 'link' => 'https://drive.google.com/drive/folders/1y0LUH1', 'tanggal' => '2025-03-03'],
            ['pertemuan' => 2, 'link' => 'https://drive.google.com/drive/folders/1y0LUH2', 'tanggal' => '2025-03-10'],
            ['pertemuan' => 3, 'link' => 'https://drive.google.com/drive/folders/1y0LUH3', 'tanggal' => '2025-03-17'],
        ];

        $mataPelajaran = $this->generateListWithId();
        $user = Auth::user();

        // ✅ Kirim semua ke view
        return view('siswa.materi', compact('mapel', 'materis', 'mataPelajaran', 'user'));
    }

    private function generateListWithId()
    {
        $list = [];
        foreach ($this->dataMapel as $id => $item) {
            $list[] = [
                'id' => $id,
                'nama' => $item['nama'],
            ];
        }
        return $list;
    }
}
