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
use App\Http\Controllers\MateriController;
use App\Http\Controllers\Guru\TugasController;
use App\Http\Controllers\Guru\PengumumanController;
use App\Http\Controllers\OrangtuaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\AdminGuruController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Welcome atau halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect after login
Route::get('/redirect', [RedirectController::class, 'index'])->name('redirect.dashboard')->middleware('auth');

// Role-based dashboards
Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'checkrole:siswa'])->group(function () {
    Route::get('/dashboard-siswa', [SiswaController::class, 'index'])->name('siswa.dashboard');
});

Route::middleware(['auth', 'checkrole:guru'])->group(function () {
    Route::get('/dashboard-guru', [GuruController::class, 'index'])->name('guru.dashboard');
});

Route::middleware(['auth', 'checkrole:orangtua'])->group(function () {
    Route::get('/dashboard-orangtua', [OrangtuaController::class, 'index'])->name('orangtua.dashboard');
});
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Dashboard Redirect by Role

//  Admin
  Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'checkrole:siswa'])->group(function () {
    Route::get('/dashboard-siswa', [SiswaController::class, 'index'])->name('siswa.dashboard');
});

Route::middleware(['auth', 'checkrole:guru'])->group(function () {
    Route::get('/dashboard-guru', [GuruController::class, 'index'])->name('guru.dashboard');
});

Route::middleware(['auth', 'checkrole:orangtua'])->group(function () {
    Route::get('/dashboard-orangtua', [OrangtuaController::class, 'index'])->name('orangtua.dashboard');
});

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
    //Route::get('/materi', [MateriController::class, 'index'])->name('guru.materi');
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
   //guru
    Route::get('/guru', [AdminController::class, 'guruIndex'])->name('admin.guru');
    Route::post('/guru', [AdminController::class, 'guruStore'])->name('admin.guru.store');
    Route::put('/guru/{id}', [AdminController::class, 'guruUpdate'])->name('admin.guru.update');
    Route::get('/guru/export', [AdminController::class, 'guruExport'])->name('admin.guru.export');
    Route::post('/guru/import', [AdminController::class, 'guruImport'])->name('admin.guru.import');
    //siswa admin
 
    // Halaman utama data siswa
   Route::get('/siswa', [AdminController::class, 'indexSiswa'])->name('admin.siswa');

    // Simpan siswa baru
    Route::post('/siswa', [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');

    // Import siswa dari Excel
    Route::post('/siswa/import', [AdminController::class, 'importSiswa'])->name('admin.siswa.import');

    // Export siswa ke Excel
    Route::get('/siswa/export', [AdminController::class, 'exportSiswa'])->name('admin.siswa.export');

    // Update siswa
    Route::post('/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');

    // Hapus siswa
    Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa'])->name('admin.siswa.destroy');

    //admin kelas
      Route::get('/kelas', [AdminController::class, 'indexkelas'])->name('admin.kelas');
    Route::post('/kelas', [AdminController::class, 'storekelas'])->name('admin.kelas.store');
    Route::post('/kelas/{id}', [AdminController::class, 'updatekelas'])->name('admin.kelas.update');
    Route::post('/kelas/import', [AdminController::class, 'importkelas'])->name('admin.kelas.import');
    Route::get('/kelas/export', [AdminController::class, 'exportkelas'])->name('admin.kelas.export');
    Route::post('/kelas/{id}', [AdminController::class, 'updatekelas'])->name('admin.kelas.update');
    //materi admin
    Route::get('/admin/materi', [MateriController::class, 'index'])->name('admin.mapel.index');
    Route::post('/admin/materi', [MateriController::class, 'store'])->name('admin.mapel.store');
    Route::post('/admin/materi/import', [MateriController::class, 'import'])->name('admin.mapel.import');
    Route::get('/admin/materi/export', [MateriController::class, 'export'])->name('admin.mapel.export');
    Route::post('/admin/materi/{id}/update', [MateriController::class, 'update'])->name('admin.mapel.update');
    //pengumuman
    Route::get('/pengumuman', [AdminController::class, 'indexpengumuman'])->name('admin.pengumuman');
    Route::post('/pengumuman/store', [AdminController::class, 'store'])->name('admin.pengumuman.store');
    Route::get('/pengumuman/edit/{id}', [AdminController::class, 'editpengumuman'])->name('admin.pengumuman.edit');
    Route::post('/pengumuman/update/{id}', [AdminController::class, 'updatepengumuman'])->name('admin.pengumuman.update');
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
// Materi - Bisa diakses oleh admin dan guru
Route::middleware(['auth', 'role:admin,guru'])->group(function () {
    Route::get('/materi', [MateriController::class, 'index'])->name('admin.mapel.index');
    Route::get('/materi/export', [MateriController::class, 'export'])->name('admin.mapel.export');
    Route::post('/materi/import', [MateriController::class, 'import'])->name('admin.mapel.import');
});

// Hanya admin yang boleh tambah & update
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/materi', [MateriController::class, 'store'])->name('admin.mapel.store');
    Route::post('/materi/{id}/update', [MateriController::class, 'update'])->name('admin.mapel.update');
});

// Route untuk guru
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/materi', [MateriController::class, 'index'])->name('mapel.index');
    Route::get('/guru/materi', [GuruController::class, 'materi'])->name('guru.materi');
});
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
});
//crud siswaadmin 
// Siswa routes

