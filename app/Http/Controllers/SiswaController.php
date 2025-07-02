<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
class SiswaController extends Controller
{
    private $mataPelajaran = [
        ['id' => 1, 'nama' => 'Matematika'],
        ['id' => 2, 'nama' => 'Bahasa Indonesia'],
        ['id' => 3, 'nama' => 'Ilmu Pengetahuan Alam (IPA)'],
        ['id' => 4, 'nama' => 'Ilmu Pengetahuan Sosial (IPS)'],
        ['id' => 5, 'nama' => 'Bahasa Inggris'],
        ['id' => 6, 'nama' => 'Pendidikan Pancasila dan Kewarganegaraan (PPKn)'],
        ['id' => 7, 'nama' => 'Pendidikan Jasmani dan Kesehatan (Penjaskes)'],
        ['id' => 8, 'nama' => 'Seni Budaya'],
        ['id' => 9, 'nama' => 'Prakarya'],
        ['id' => 10, 'nama' => 'Bahasa Daerah'],
    ];

    public function index()
    {
        $user = auth()->user();

        $jadwalHariIni = 1;
        $jadwalPengganti = 0;
        $tugasHariIni = 3;

        $pelajaranSelanjutnya = [
            'mapel' => 'Ilmu Pengetahuan Alam (IPA)',
            'jam' => '10:30 - 12:00'
        ];

        $nilaiTerbaru = [
            'mapel' => 'Matematika',
            'nilai' => 88
        ];

        $jadwalMingguan = 10;

        $tugasTerbaru = [
            'mapel' => 'Bahasa Indonesia',
            'judul' => 'Menulis Puisi Bebas'
        ];

        return view('siswa.siswadashboard', [
            'user' => $user,
            'mataPelajaran' => $this->mataPelajaran,
            'jadwalHariIni' => $jadwalHariIni,
            'jadwalPengganti' => $jadwalPengganti,
            'tugasHariIni' => $tugasHariIni,
            'pelajaranSelanjutnya' => $pelajaranSelanjutnya,
            'nilaiTerbaru' => $nilaiTerbaru,
            'jadwalMingguan' => $jadwalMingguan,
            'tugasTerbaru' => $tugasTerbaru
        ]);
    }

    public function show($id)
    {
        $data = [
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
            // ... tambahkan sesuai struktur sebelumnya
        

        $mapel = $data[$id] ?? abort(404);

        return view('siswa.siswadetail', [
            'mapel' => $mapel,
            'mataPelajaran' => $this->mataPelajaran
        ]);
    }

    public function absensi()
{
   // 👇 Autologin untuk development (sementara)
    $user = \App\Models\User::first();

    if ($user) {
        Auth::login($user);
    } else {
        $user = \App\Models\User::create([
            'name' => 'esteryuu',
            'email' => 'siswa@example.com',
            'password' => bcrypt('password123'),
        ]);
        Auth::login($user);
    }

    $mataPelajaran = [
        ['id' => 1, 'nama' => 'Matematika'],
        ['id' => 2, 'nama' => 'Bahasa Indonesia'],
        ['id' => 3, 'nama' => 'Ilmu Pengetahuan Alam (IPA)'],
        ['id' => 4, 'nama' => 'Ilmu Pengetahuan Sosial (IPS)'],
        ['id' => 5, 'nama' => 'Bahasa Inggris'],
        ['id' => 6, 'nama' => 'Pendidikan Pancasila dan Kewarganegaraan (PPKn)'],
        ['id' => 7, 'nama' => 'Pendidikan Jasmani dan Kesehatan (Penjaskes)'],
        ['id' => 8, 'nama' => 'Seni Budaya'],
        ['id' => 9, 'nama' => 'Prakarya'],
        ['id' => 10, 'nama' => 'Bahasa Daerah'],
    ];

    $absensi = [
        ['tanggal' => '2025-06-27', 'mapel' => 'Matematika', 'jam' => '07:00', 'status' => 'Hadir'],
        ['tanggal' => '2025-06-26', 'mapel' => 'Bahasa Indonesia', 'jam' => '08:00', 'status' => 'Izin'],
        ['tanggal' => '2025-06-25', 'mapel' => 'IPA', 'jam' => '09:30', 'status' => 'Alpha'],
        ['tanggal' => '2025-06-27', 'mapel' => 'Matematika', 'jam' => '07:00', 'status' => 'Hadir'],
        ['tanggal' => '2025-06-26', 'mapel' => 'Bahasa Indonesia', 'jam' => '08:00', 'status' => 'Izin'],
        ['tanggal' => '2025-06-25', 'mapel' => 'IPA', 'jam' => '09:30', 'status' => 'Alpha'],
        ['tanggal' => '2025-06-27', 'mapel' => 'Matematika', 'jam' => '07:00', 'status' => 'Hadir'],
        ['tanggal' => '2025-06-26', 'mapel' => 'Bahasa Indonesia', 'jam' => '08:00', 'status' => 'Izin'],
        ['tanggal' => '2025-06-25', 'mapel' => 'IPA', 'jam' => '09:30', 'status' => 'Alpha'],
        ['tanggal' => '2025-06-25', 'mapel' => 'IPA', 'jam' => '09:30', 'status' => 'Alpha'],
    ];

    return view('siswa.absensi', compact('user', 'mataPelajaran', 'absensi'));
}
public function nilai()
{
    // 👇 Autologin untuk development (sementara)
    $user = \App\Models\User::first();

    if ($user) {
        Auth::login($user);
    } else {
        $user = \App\Models\User::create([
            'name' => 'esteryuuu',
            'email' => 'siswa@example.com',
            'password' => bcrypt('password123'),
        ]);
        Auth::login($user);
    }

    $mataPelajaran = [
        ['id' => 1, 'nama' => 'Matematika'],
        ['id' => 2, 'nama' => 'Bahasa Indonesia'],
        ['id' => 3, 'nama' => 'IPA'],
        ['id' => 4, 'nama' => 'Ilmu Pengetahuan Sosial (IPS)'],
        ['id' => 5, 'nama' => 'Bahasa Inggris'],
        ['id' => 6, 'nama' => 'Pendidikan Pancasila dan Kewarganegaraan (PPKn)'],
        ['id' => 7, 'nama' => 'Pendidikan Jasmani dan Kesehatan (Penjaskes)'],
        ['id' => 8, 'nama' => 'Seni Budaya'],
        ['id' => 9, 'nama' => 'Prakarya'],
        ['id' => 10, 'nama' => 'Bahasa Daerah'],

    ];

    $nilaiAkhir = [
        ['mapel' => 'Matematika', 'nilai' => 88, 'predikat' => 'A', 'keterangan' => 'Lulus'],
        ['mapel' => 'Bahasa Indonesia', 'nilai' => 75, 'predikat' => 'B', 'keterangan' => 'Lulus'],
        ['mapel' => 'IPA', 'nilai' => 65, 'predikat' => 'C', 'keterangan' => 'Perlu Perbaikan'],
        ['mapel' => 'Ilmu Pengetahuan Sosial (IPS)', 'nilai' => 80, 'predikat' => 'B+', 'keterangan' => 'Lulus'],
        ['mapel' => 'Bahasa Inggris', 'nilai' => 80, 'predikat' => 'B+', 'keterangan' => 'Lulus'],
        ['mapel' => 'Bahasa Inggris', 'nilai' => 80, 'predikat' => 'B+', 'keterangan' => 'Lulus'],
        ['mapel' => 'Bahasa Inggris', 'nilai' => 80, 'predikat' => 'B+', 'keterangan' => 'Lulus'],
        ['mapel' => 'Bahasa Inggris', 'nilai' => 80, 'predikat' => 'B+', 'keterangan' => 'Lulus'],
        ['mapel' => 'Bahasa Inggris', 'nilai' => 80, 'predikat' => 'B+', 'keterangan' => 'Lulus'],
        ['mapel' => 'Bahasa Inggris', 'nilai' => 80, 'predikat' => 'B+', 'keterangan' => 'Lulus'],
    ];

    return view('siswa.nilai', compact('user', 'mataPelajaran', 'nilaiAkhir'));
}
}
