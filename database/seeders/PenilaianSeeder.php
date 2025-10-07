<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua mapel dari tabel mapels
        $mapels = DB::table('mapels')->get();

        foreach ($mapels as $mapel) {
            // contoh data dummy penilaian
            $tugas = rand(0, 100);
            $kuis = rand(0, 100);
            $uts = rand(0, 100);
            $uas = rand(0, 100);
            $absensi_total = rand(30, 36); // total pertemuan
            $absensi_hadir = rand(0, $absensi_total);

            // Hitung nilai akhir (misal bobot: tugas 20%, kuis 20%, UTS 25%, UAS 25%, absensi 10%)
            $nilaiAkhir = round(
                ($tugas * 0.2) +
                ($kuis * 0.2) +
                ($uts * 0.25) +
                ($uas * 0.25) +
                (($absensi_hadir / $absensi_total) * 100 * 0.1), 2
            );

            DB::table('penilaians')->insert([
                'mapel_id'      => $mapel->id,
                'tugas'         => $tugas,
                'kuis'          => $kuis,
                'uts'           => $uts,
                'uas'           => $uas,
                'absensi'       => $absensi_hadir . '/' . $absensi_total,
                'nilai_akhir'   => $nilaiAkhir,
                'catatan'       => 'Data dummy penilaian untuk ' . $mapel->nama_mapel,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
        }
    }
}
