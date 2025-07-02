<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Siswa\MataPelajaranController;
use App\Http\Controllers\Siswa\DashboardFiturController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\Guru\JadwalController;
use App\Http\Controllers\Guru\SiswaaaController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\MateriController;
use App\Http\Controllers\Guru\TugasController;
use App\Http\Controllers\Guru\PengumumanController;
use App\Http\Controllers\OrangtuaController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

//  Admin
   
// siswa
Route::get(uri: '/siswa', action: [SiswaController::class, 'index'])->name('siswa.index');
Route::get('/siswa/matapelajaran/{id}', [SiswaController::class, 'show'])->name('siswa.matapelajaran.show');
Route::prefix('siswa')->group(function () {
Route::get('/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');
Route::get('/matapelajaran/{id}', [SiswaController::class, 'show'])->name('siswa.matapelajaran.show');
Route::get('/siswa/matapelajaran/{id}/materi', [MataPelajaranController::class, 'materi'])->name('siswa.matapelajaran.materi');
Route::get('/siswa/mapel/{id}/materi', [MataPelajaranController::class, 'materi'])->name('siswa.mapel.materi');
Route::get('/siswa/mapel/{id}/materi', [MataPelajaranController::class, 'materi'])->name('siswa.mapel.materi');
Route::get('/absensi', [SiswaController::class, 'absensi'])->name('siswa.absensi');
Route::get('/nilai', [SiswaController::class, 'nilai'])->name('siswa.nilai');
});

//tampilan sub dashboard
Route::prefix('siswa/fitur')->middleware(['auth'])->name('siswa.fitur.')->group(function () {
    Route::get('/jadwal-hari-ini', [DashboardFiturController::class, 'jadwalHariIni'])->name('jadwal.hariini');
    Route::get('/tugas-hari-ini', [DashboardFiturController::class, 'tugasHariIni'])->name('tugas.hariini');
    Route::get('/pelajaran-selanjutnya', [DashboardFiturController::class, 'pelajaranSelanjutnya'])->name('pelajaran.selanjutnya');
    Route::get('/nilai-terbaru', [DashboardFiturController::class, 'nilaiTerbaru'])->name('nilai.terbaru');
    Route::get('/jadwal-mingguan', [DashboardFiturController::class, 'jadwalMingguan'])->name('jadwal.mingguan');
    Route::get('/tugas-terbaru', [DashboardFiturController::class, 'tugasTerbaru'])->name('tugas.terbaru');
});
//mata pelajaran 
Route::prefix('siswa/matapelajaran')->name('siswa.matapelajaran.')->group(function () {
    Route::get('/{id}', [MataPelajaranController::class, 'show'])->name('show');
    Route::get('/{id}/materi', [MataPelajaranController::class, 'materi'])->name('materi');
});
//Dashboard guru
Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
Route::prefix('guru')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('guru.jadwal');
    Route::get('/siswa', [SiswaaaController::class, 'index'])->name('guru.siswa');
    Route::get('/nilai', [NilaiController::class, 'index'])->name('guru.nilai');
    Route::get('/materi', [MateriController::class, 'index'])->name('guru.materi');
    Route::get('/tugas', [TugasController::class, 'index'])->name('guru.tugas');
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('guru.pengumuman');
});
//admin 
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/guru', [AdminController::class, 'guru'])->name('admin.guru');
    Route::get('/siswa', [AdminController::class, 'siswa'])->name('admin.siswa');
    Route::get('/kelas', [AdminController::class, 'kelas'])->name('admin.kelas');
    Route::get('/mapel', [AdminController::class, 'mapel'])->name('admin.mapel');
    Route::get('/pengumuman', [AdminController::class, 'pengumuman'])->name('admin.pengumuman');
});
//orang tua
Route::get('/login-sementara', function () {
    $user = User::where('role', 'orangtua')->first(); // pastikan user dengan role orangtua ada
    Auth::login($user);
    return redirect()->route('orangtua.dashboard');
});
Route::prefix('orangtua')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [OrangtuaController::class, 'index'])->name('orangtua.dashboard');
    Route::get('/anak', [OrangtuaController::class, 'anak'])->name('orangtua.anak');
    Route::get('/nilai', [OrangtuaController::class, 'nilai'])->name('orangtua.nilai');
    Route::get('/absensi', [OrangtuaController::class, 'absensi'])->name('orangtua.absensi');
    Route::get('/catatan', [OrangtuaController::class, 'catatan'])->name('orangtua.catatan');

    // subfitur
    Route::get('/jadwal/hariini', [OrangtuaController::class, 'jadwalHariIni'])->name('orangtua.jadwal.hariini');
    Route::get('/tugas/hariini', [OrangtuaController::class, 'tugasHariIni'])->name('orangtua.tugas.hariini');
    Route::get('/pelajaran/selanjutnya', [OrangtuaController::class, 'pelajaranSelanjutnya'])->name('orangtua.pelajaran.selanjutnya');
    Route::get('/nilai/terbaru', [OrangtuaController::class, 'nilaiTerbaru'])->name('orangtua.nilai.terbaru');
    Route::get('/jadwal/mingguan', [OrangtuaController::class, 'jadwalMingguan'])->name('orangtua.jadwal.mingguan');
    Route::get('/tugas/terbaru', [OrangtuaController::class, 'tugasTerbaru'])->name('orangtua.tugas.terbaru');
});