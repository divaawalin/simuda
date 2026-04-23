<?php

use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\KontenController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Anggota\AbsensiController as AnggotaAbsensiController;
use App\Http\Controllers\Anggota\AnggotaDashboardController;
use App\Http\Controllers\Anggota\KontenController as AnggotaKontenController;
use App\Http\Controllers\Anggota\ProfileController as AnggotaProfileController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/lupa-password', [AuthController::class, 'showLupaPassword'])->name('password.request');
    Route::post('/lupa-password', [AuthController::class, 'lupaPassword']);
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Auth required
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Area (Admin, Sekretaris, Ketua)
    Route::middleware('role:admin,sekretaris,ketua')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Manajemen Kegiatan
        Route::resource('/kegiatan', KegiatanController::class);

        // Manajemen Anggota
        Route::resource('/anggota', AnggotaController::class);
        Route::post('/anggota/{id}/toggle-status', [AnggotaController::class, 'toggleStatus'])->name('anggota.toggle-status');

        // Manajemen Absensi
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/absensi/{kegiatan_id}/invite', [AbsensiController::class, 'invite'])->name('absensi.invite');
        Route::post('/absensi/{kegiatan_id}/invite', [AbsensiController::class, 'storeInvite'])->name('absensi.store-invite');
        Route::get('/absensi/{kegiatan_id}/sesi', [AbsensiController::class, 'sesi'])->name('absensi.sesi');
        Route::post('/absensi/{kegiatan_id}/sesi/mulai', [AbsensiController::class, 'mulaiSesi'])->name('absensi.sesi-mulai');
        Route::post('/absensi/{kegiatan_id}/sesi/akhiri', [AbsensiController::class, 'akhiriSesi'])->name('absensi.sesi-akhiri');
        Route::get('/absensi/{kegiatan_id}/qr', [AbsensiController::class, 'qr'])->name('absensi.qr');
        Route::post('/absensi/{kegiatan_id}/scan', [AbsensiController::class, 'scan'])->name('absensi.scan');
        Route::get('/absensi/{kegiatan_id}/rekap', [AbsensiController::class, 'rekap'])->name('absensi.rekap');
        Route::get('/absensi/rekap-global', [AbsensiController::class, 'rekapGlobal'])->name('absensi.rekapGlobal');

        // Manajemen User Admin
        Route::resource('/users', UserAdminController::class);

        // Manajemen Konten
        Route::resource('/konten', KontenController::class);

        // Profile
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.password');
    });

    // Anggota Area
    Route::middleware('role:anggota')->prefix('anggota')->group(function () {
        Route::get('/dashboard', [AnggotaDashboardController::class, 'index'])->name('anggota.dashboard');

        // Absensi Anggota
        Route::get('/absensi', [AnggotaAbsensiController::class, 'index'])->name('anggota.absensi.index');
        Route::get('/absensi/{kegiatan_id}', [AnggotaAbsensiController::class, 'detail'])->name('anggota.absensi.detail');
        Route::get('/absensi/{kegiatan_id}/qr', [AnggotaAbsensiController::class, 'qr'])->name('anggota.absensi.qr');
        Route::post('/absensi/{kegiatan_id}/absen', [AnggotaAbsensiController::class, 'absen'])->name('anggota.absensi.submit');

        // Konten Anggota
        Route::get('/konten', [AnggotaKontenController::class, 'index'])->name('anggota.konten.index');

        // Profile
        Route::get('/profile', [AnggotaProfileController::class, 'index'])->name('anggota.profile');
        Route::put('/profile', [AnggotaProfileController::class, 'update'])->name('anggota.profile.update');
        Route::put('/profile/password', [AnggotaProfileController::class, 'updatePassword'])->name('anggota.profile.password');
    });
});

// Storage Routes
Route::get('/storage/profiles/{filename}', function ($filename) {
    $path = storage_path('profiles/'.$filename);
    if (! File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header('Content-Type', $type);
})->name('storage.profiles');

Route::get('/storage/konten/{filename}', function ($filename) {
    $path = storage_path('konten/'.$filename);
    if (! File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header('Content-Type', $type);
})->name('storage.konten');
