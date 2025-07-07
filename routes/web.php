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
use App\Http\Controllers\AdminGuruController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Welcome atau halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Redirect by Role
// Route::get('/admin/dashboard', fn() => view('dashboard.admin'))->name('admin.dashboard');
Route::get('/guru/dashboard', fn() => view('dashboard.guru'))->name('guru.dashboard');
Route::get('/siswa/dashboard', fn() => view('dashboard.siswa'))->name('siswa.dashboard');
Route::get('/orangtua/dashboard', fn() => view('dashboard.orangtua'))->name('orangtua.dashboard');
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
// Untuk admin
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/guru', [AdminController::class, 'guru'])->name('admin.guru');
    Route::get('/siswa', [AdminController::class, 'siswa'])->name('admin.siswa');
    Route::get('/kelas', [AdminController::class, 'kelas'])->name('admin.kelas');
    Route::get('/mapel', [AdminController::class, 'mapel'])->name('admin.mapel');
    Route::get('/pengumuman', [AdminController::class, 'pengumuman'])->name('admin.pengumuman');
    //admin guru
       Route::get('/guru/create', [AdminController::class, 'create'])->name('admin.guru.create');
    Route::post('/guru/store', [AdminController::class, 'store'])->name('admin.guru.store');
       // Ekspor dan Impor
    Route::get('/guru/export', [AdminController::class, 'export'])->name('admin.guru.export');
   Route::get('/guru/import', [AdminController::class, 'showImportForm'])->name('admin.guru.import.form');
    Route::post('/guru/import', [AdminController::class, 'import'])->name('admin.guru.import');
     Route::get('/guru/{id}/edit', [AdminController::class, 'edit'])->name('admin.guru.edit'); // 👈
    Route::put('/guru/{id}', [AdminController::class, 'update'])->name('admin.guru.update'); // 👈
});
//orang tua
Route::prefix('orangtua')->group(function () {
    Route::get('/dashboard', [OrangtuaController::class, 'index'])->name('orangtua.dashboard');
    Route::get('/hasil', [OrangtuaController::class, 'hasil'])->name('orangtua.hasil');
    Route::get('/perkembangan', [OrangtuaController::class, 'perkembangan'])->name('orangtua.perkembangan');
    Route::get('/komunikasi', [OrangtuaController::class, 'komunikasi'])->name('orangtua.komunikasi');
    Route::get('/orangtua/nilai', [OrangtuaController::class, 'nilai'])->name('orangtua.nilai');
    Route::get('/orangtua/hasil', [OrangtuaController::class, 'hasil'])->name('orangtua.hasil');
    //pesan 
    Route::get('/orangtua/komunikasi', [OrangtuaController::class, 'komunikasi'])->name('orangtua.komunikasi');
Route::post('/orangtua/kirim-pesan', [OrangtuaController::class, 'kirimPesan'])->name('orangtua.kirimPesan');
});

//import
Route::get('/cek-zip', function () {
    return class_exists('ZipArchive') ? 'ZipArchive aktif' : 'ZipArchive tidak ditemukan';
});