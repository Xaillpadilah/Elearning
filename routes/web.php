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
use App\Http\Controllers\TugasController;
use App\Http\Controllers\OrangtuaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\AdminGuruController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\SoalUjianController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\TugasSiswaController;
use App\Http\Controllers\MateriSiswaController;
use App\Http\Controllers\UjianSiswaController;
// Welcome atau halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-orangtua', [AuthController::class, 'loginDenganNisn'])->name('login.orangtua');
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
    // Reset Password (tambahan agar route('password.request') tidak error)
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    // Tampilkan form reset password
    // Tampilkan form reset password
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');

    // Proses update password
    Route::get('/test-email', function () {
    Mail::raw('Ini email uji coba dari Laravel ke Mailpit', function ($msg) {
        $msg->to('user@example.com')->subject('Email Test');
    });

    return 'Email berhasil dikirim ke Mailpit!';
});
//  Admin
    Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});


Route::middleware(['auth', 'checkrole:guru'])->group(function () {
    Route::get('/dashboard-guru', [GuruController::class, 'index'])->name('guru.dashboard');
});

Route::middleware(['auth', 'checkrole:orangtua'])->group(function () {
    Route::get('/dashboard-orangtua', [OrangtuaController::class, 'index'])->name('orangtua.dashboard');
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
Route::prefix('guru')->middleware(['auth', 'checkRole:guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
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
    Route::delete('/admin/guru/{id}', [AdminController::class, 'guruDestroy'])->name('admin.guru.destroy');
    //siswa admin
    Route::get('/siswa', [AdminController::class, 'indexSiswa'])->name('admin.siswa');
    Route::post('/siswa', [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
    Route::post('/siswa/import', [AdminController::class, 'importSiswa'])->name('admin.siswa.import');
    Route::get('/siswa/export', [AdminController::class, 'exportSiswa'])->name('admin.siswa.export');
    Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa'])->name('admin.siswa.destroy');
    Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
    //admin kelas
      Route::get('/kelas', [AdminController::class, 'indexkelas'])->name('admin.kelas');
    Route::post('/kelas', [AdminController::class, 'storekelas'])->name('admin.kelas.store');
    Route::post('/kelas/{id}', [AdminController::class, 'updatekelas'])->name('admin.kelas.update');
    Route::post('/kelas/import', [AdminController::class, 'importkelas'])->name('admin.kelas.import');
    Route::get('/kelas/export', [AdminController::class, 'exportkelas'])->name('admin.kelas.export');
    Route::delete('/admin/kelas/{id}', [AdminController::class, 'destroyKelas'])->name('admin.kelas.destroy');
    //jadwal
    Route::get('/admin/kelas/{kelas_id}/jadwal', [AdminController::class, 'indexJadwal'])->name('admin.kelas.jadwal');
    Route::post('/admin/kelas/jadwal/store', [AdminController::class, 'storeJadwal'])->name('admin.kelas.jadwal.store');
    Route::put('/kelas/jadwal/{id}', [AdminController::class, 'jadwalUpdate'])->name('admin.kelas.jadwal.update');
    Route::get('/kelas/jadwal/{id}/edit', [AdminController::class, 'getJadwal'])->name('admin.kelas.jadwal.get');
    Route::delete('/kelas/jadwal/{id}', [AdminController::class, 'jadwalDestroy'])->name('admin.kelas.jadwal.destroy');
    //pengumuman
    Route::get('/pengumuman', [AdminController::class, 'pengumumanindex'])->name('admin.pengumuman.index');
    Route::post('/pengumuman', [AdminController::class, 'store'])->name('admin.pengumuman.store');
    Route::put('/pengumuman/{id}', [AdminController::class, 'pengumumanupdate'])->name('admin.pengumuman.update');
    Route::delete('/pengumuman/{id}', [AdminController::class, 'pengumumandestroy'])->name('admin.pengumuman.destroy');
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
Route::middleware(['auth', 'checkRole:admin,guru'])->group(function () {
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
    Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');
    Route::delete('/materi/{id}', [MateriController::class, 'destroy'])->name('materi.destroy');
    Route::post('/admin/materi/{id}/kirim', [MateriController::class, 'kirim'])->name('materi.kirim');
    Route::put('/admin/materi/{id}', [MateriController::class, 'update'])->name('materi.update');
});
//tugas
Route::middleware(['auth', 'checkRole:admin,guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'Dashboard'])->name('guru.dashboardguru');
    Route::get('/tugas', [TugasController::class, 'index'])->name('guru.tugas.index');
    Route::post('/tugas', [TugasController::class, 'store'])->name('guru.tugas.store');
    Route::put('/tugas/{id}', [TugasController::class, 'update'])->name('guru.tugas.update');
    Route::put('/guru/tugas/{id}/kirim', [TugasController::class, 'kirim'])->name('tugas.kirim');
    Route::delete('/tugas/{id}', [TugasController::class, 'destroy'])->name('guru.tugas.destroy');
    
});

// guru
    Route::prefix('guru')->middleware(['auth', 'checkRole:guru'])->group(function () {
    Route::get('/guru/menu', [PembelajaranController::class, 'index'])->name('guru.menu');

});
Route::prefix('guru')->middleware(['auth', 'checkRole:guru'])->group(function () {
    Route::get('/ujian', [UjianController::class, 'index'])->name('guru.ujian.index');
    Route::post('/ujian', [UjianController::class, 'store'])->name('guru.ujian.store');
    Route::delete('/ujian/{id}', [UjianController::class, 'destroy'])->name('guru.ujian.destroy');
    Route::put('/ujian/{id}', [UjianController::class, 'update'])->name('guru.ujian.update');
    Route::put('/guru/ujian/kirim/{id}', [UjianController::class, 'kirim'])->name('guru.ujian.kirim');
});
//penilaina 
Route::prefix('guru')->middleware(['auth', 'checkRole:guru'])->group(function () {
    Route::get('/nilai', [PenilaianController::class, 'index'])->name('guru.penilaian.index');
    Route::get('/nilai/create', [PenilaianController::class, 'create'])->name('guru.penilaian.create');
    Route::post('/nilai', [PenilaianController::class, 'store'])->name('guru.penilaian.store');
    Route::get('/nilai/{id}/edit', [PenilaianController::class, 'edit'])->name('guru.penilaian.edit');
    Route::put('/nilai/{id}', [PenilaianController::class, 'update'])->name('guru.penilaian.update');
    Route::delete('/nilai/{id}', [PenilaianController::class, 'destroy'])->name('guru.penilaian.destroy');
    Route::get('/', [PenilaianController::class, 'index'])->name('index');
    Route::get('/input', [PenilaianController::class, 'inputForm'])->name('input');
    Route::post('/store', [PenilaianController::class, 'store'])->name('store');
    Route::get('/guru/penilaian/form', [PenilaianController::class, 'formPartial'])->name('guru.penilaian._form');
    Route::put('/guru/penilaian/update-multiple', [PenilaianController::class, 'updateMultiple'])->name('guru.penilaian.updateMultiple');
    Route::get('/guru/nilai/input/{relasi_id}', [PenilaianController::class, 'create'])->name('penilaian.create');
    Route::post('/guru/nilai/simpan', [PenilaianController::class, 'store'])->name('penilaian.store');
});
Route::prefix('guru')->middleware(['auth', 'checkRole:guru'])->group(function () {
    Route::get('absensi', [AbsensiController::class, 'index'])->name('guru.absensi.index');
    Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('guru.absensi.create');
    Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('guru.absensi.store');
    Route::post('/guru/absensi/update', [AbsensiController::class, 'update'])->name('guru.absensi.update');
});
//siswa
Route::prefix('siswa')->middleware(['auth', 'checkRole:siswa'])->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('siswa.siswadashboard');
    Route::get('/mapel', [SiswaController::class, 'mapel'])->name('siswa.mapel.index');
Route::get('/siswa/mapel/{id}', [SiswaController::class, 'show'])->name('siswa.mapel.index');
    Route::get('/siswa/materi/{id}', [SiswaController::class, 'materi'])->name('siswa.materi.index');
    Route::get('/mapel/{id}/materi', [SiswaController::class, 'materi'])->name('siswa.mapel.index');
    Route::get('{id}/tugas', [SiswaController::class, 'tugas'])->name('tugas');
    Route::get('{id}/ujian', [SiswaController::class, 'ujian'])->name('ujian');
    Route::get('{id}/video', [SiswaController::class, 'video'])->name('video');
    Route::get('/siswa/absensi', [SiswaController::class, 'absensi'])->name('siswa.absensi.index');
    Route::get('/siswa/nilai', [SiswaController::class, 'nilai'])->name('siswa.nilai.index');

   Route::get('/siswa/materi/popup/{id}', [SiswaController::class, 'materiByMapelPopup']);
// routes/web.php
Route::get('/siswa/materi/{id}', [SiswaController::class, 'materiByMapel'])->name('siswa.materi.index');
Route::get('/tugas', [TugasSiswaController::class, 'index'])->name('siswa.tugas.index');
     Route::get('/tugas', [TugasSiswaController::class, 'index'])->name('siswa.tugas.index');
    Route::post('/tugas/{id}', [TugasSiswaController::class, 'submit'])->name('siswa.tugas.submit');

 });
 Route::middleware(['auth', 'checkRole:siswa'])->prefix('siswa')->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'absensiSiswa'])->name('siswa.absensi.index');
    
});
Route::middleware(['auth', 'checkRole:siswa'])->prefix('siswa')->group(function () {
Route::get('/siswa/materi', [MateriSiswaController::class, 'index'])->name('siswa.materi.index');
Route::get('/siswa/materi/mapel/{mapel_id}', [MateriSiswaController::class, 'showByMapel'])->name('siswa.materi.mapel');
Route::get('/siswa/ujian', [UjianSiswaController::class, 'index'])->name('siswa.ujian.index');
});