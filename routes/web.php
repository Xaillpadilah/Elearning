<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Siswa\MataPelajaranController;
use App\Http\Controllers\Siswa\DashboardFiturController;

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
