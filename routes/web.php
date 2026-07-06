<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\LaporanAkhirController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\Mentor\AnakMagangController;
use App\Http\Controllers\Mentor\VerifikasiLogbookController;
use App\Http\Controllers\Mentor\VerifikasiLaporanAkhirController;
use App\Http\Controllers\Mentor\PenilaianAkhirController;
use App\Http\Controllers\Mentor\ProfilController as MentorProfilController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ValidasiPendaftaranController;
use App\Http\Controllers\Admin\ManajemenPesertaController;
use App\Http\Controllers\Admin\ManajemenMentorController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\SertifikatController as AdminSertifikatController;
use App\Http\Controllers\Admin\PengaturanController;

// ================= UMUM =================
Route::get('/', function () {
    return view('welcome');
});

// ================= AUTH (hanya untuk yang belum login) =================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ================= PESERTA (harus login) =================
Route::middleware(['auth', 'role.peserta'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/logbook', [LogbookController::class, 'index'])->name('logbook.index');
    Route::get('/logbook/create', [LogbookController::class, 'create'])->name('logbook.create');
    Route::post('/logbook', [LogbookController::class, 'store'])->name('logbook.store');
    Route::get('/logbook/{id}/edit', [LogbookController::class, 'edit'])->name('logbook.edit');
    Route::put('/logbook/{id}', [LogbookController::class, 'update'])->name('logbook.update');
    Route::get('/laporan-akhir', [LaporanAkhirController::class, 'index'])->name('laporan-akhir.index');
    Route::post('/laporan-akhir', [LaporanAkhirController::class, 'store'])->name('laporan-akhir.store');
    Route::get('/sertifikat', [SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::post('/sertifikat/klaim', [SertifikatController::class, 'klaim'])->name('sertifikat.klaim');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password.update');
    Route::delete('/profil/hapus-akun', [ProfilController::class, 'hapusAkun'])->name('profil.hapus-akun');
});

// ================= MENTOR (harus login) =================
Route::middleware(['auth', 'role.mentor'])->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/anak-magang', [AnakMagangController::class, 'index'])->name('anak-magang');
    Route::get('/verifikasi-logbook', [VerifikasiLogbookController::class, 'index'])->name('verifikasi-logbook');
    Route::get('/verifikasi-logbook/{id}', [VerifikasiLogbookController::class, 'show'])->name('verifikasi-logbook.show');
    Route::post('/verifikasi-logbook/{id}/setujui', [VerifikasiLogbookController::class, 'setujui'])->name('verifikasi-logbook.setujui');
    Route::post('/verifikasi-logbook/{id}/revisi', [VerifikasiLogbookController::class, 'mintaRevisi'])->name('verifikasi-logbook.minta-revisi');
    Route::get('/verifikasi-laporan-akhir', [VerifikasiLaporanAkhirController::class, 'index'])->name('verifikasi-laporan-akhir');
    Route::get('/verifikasi-laporan-akhir/{id}', [VerifikasiLaporanAkhirController::class, 'show'])->name('verifikasi-laporan-akhir.show');
    Route::post('/verifikasi-laporan-akhir/{id}/setujui', [VerifikasiLaporanAkhirController::class, 'setujui'])->name('verifikasi-laporan-akhir.setujui');
    Route::post('/verifikasi-laporan-akhir/{id}/revisi', [VerifikasiLaporanAkhirController::class, 'mintaRevisi'])->name('verifikasi-laporan-akhir.minta-revisi');
    Route::get('/penilaian-akhir', [PenilaianAkhirController::class, 'index'])->name('penilaian-akhir');
    Route::get('/penilaian-akhir/{id}', [PenilaianAkhirController::class, 'show'])->name('penilaian-akhir.show');
    Route::post('/penilaian-akhir/{id}', [PenilaianAkhirController::class, 'store'])->name('penilaian-akhir.store');
    Route::get('/profil', [MentorProfilController::class, 'index'])->name('profil');
    Route::get('/profil/edit', [MentorProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/edit', [MentorProfilController::class, 'updateInfo'])->name('profil.edit.update');
    Route::put('/profil', [MentorProfilController::class, 'update'])->name('profil.update');
});

// ================= ADMIN (harus login) =================
Route::middleware(['auth', 'role.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/validasi-pendaftaran', [ValidasiPendaftaranController::class, 'index'])->name('validasi-pendaftaran');
    Route::get('/validasi-pendaftaran/{id}', [ValidasiPendaftaranController::class, 'show'])->name('validasi-pendaftaran.show');
    Route::post('/validasi-pendaftaran/{id}', [ValidasiPendaftaranController::class, 'update'])->name('validasi-pendaftaran.update');
    Route::get('/manajemen-peserta', [ManajemenPesertaController::class, 'index'])->name('manajemen-peserta');
    Route::get('/manajemen-peserta/{id}/edit', [ManajemenPesertaController::class, 'edit'])->name('manajemen-peserta.edit');
    Route::post('/manajemen-peserta/{id}', [ManajemenPesertaController::class, 'update'])->name('manajemen-peserta.update');
    Route::get('/manajemen-mentor', [ManajemenMentorController::class, 'index'])->name('manajemen-mentor');
    Route::get('/manajemen-mentor/tambah', [ManajemenMentorController::class, 'create'])->name('manajemen-mentor.create');
    Route::post('/manajemen-mentor', [ManajemenMentorController::class, 'store'])->name('manajemen-mentor.store');
    Route::get('/manajemen-mentor/{id}/edit', [ManajemenMentorController::class, 'edit'])->name('manajemen-mentor.edit');
    Route::post('/manajemen-mentor/{id}', [ManajemenMentorController::class, 'update'])->name('manajemen-mentor.update');
    Route::delete('/manajemen-mentor/{id}', [ManajemenMentorController::class, 'destroy'])->name('manajemen-mentor.destroy');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
    Route::get('/monitoring/{id}', [MonitoringController::class, 'show'])->name('monitoring.show');
    Route::get('/sertifikat', [AdminSertifikatController::class, 'index'])->name('sertifikat');
    Route::get('/sertifikat/{id}', [AdminSertifikatController::class, 'show'])->name('sertifikat.show');
    Route::post('/sertifikat/{id}/terbitkan', [AdminSertifikatController::class, 'terbitkan'])->name('sertifikat.terbitkan');
    Route::get('/sertifikat/{id}/download', [AdminSertifikatController::class, 'download'])->name('sertifikat.download');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan', [PengaturanController::class, 'store'])->name('pengaturan.store');
    Route::put('/pengaturan/{id}', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::delete('/pengaturan/{id}', [PengaturanController::class, 'destroy'])->name('pengaturan.destroy');
    
});

Route::get('/serti-template/{filename}', function ($filename) {
    $allowed = ['53.svg', '54.svg'];
    if (!in_array($filename, $allowed, true)) {
        abort(404);
    }

    $path = base_path('serti-template/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path, ['Content-Type' => 'image/svg+xml']);
})->name('serti-template.file');
