<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Superadmin\AkunAdminController;
use App\Http\Controllers\Superadmin\AkunUserController;
use App\Http\Controllers\Superadmin\BeritaController;
use App\Http\Controllers\Superadmin\CekBugController;
use App\Http\Controllers\Superadmin\IpTrackingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\LaporanController;
use App\Http\Controllers\Superadmin\LaporanController as SuperadminLaporanController;

// ===================== PUBLIC ============================
Route::get('/', fn () => redirect()->route('home'));
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/berita/{id}', [HomeController::class, 'show'])->name('berita.show');

// ===================== AUTH ============================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ===================== AUTHENTICATED ============================
Route::middleware('auth')->group(function () {

    // Role-based redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('superadmin')) return redirect()->route('superadmin.dashboard');
        if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // ===================== FOTO PROFIL ============================
    Route::get('/user/foto/{filename}', function ($filename) {
        $pathPublic = storage_path('app/public/profil/' . $filename);
        if (file_exists($pathPublic)) {
            return Response::file($pathPublic);
        }
        $pathDefault = storage_path('app/private/profil/gambarfoto.jpg');
        if (file_exists($pathDefault)) {
            return Response::file($pathDefault);
        }
        abort(404, 'Foto tidak ditemukan.');
    })->name('user.profil')->middleware(['role:user']);

    // Profil default
    Route::get('/profil/default', fn () => redirect(asset('images/default-profile.jpg')))
        ->name('profil.default');

    // ===================== SUPERADMIN ============================
    Route::middleware('role:superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::view('/dashboard', 'superadmin.pages.dashboard')->name('dashboard');

        // Laporan
        Route::get('/laporan', [SuperadminLaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/{id}', [SuperadminLaporanController::class, 'show'])->name('laporan.show');
        Route::get('/laporan/{id}/pdf', [SuperadminLaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('/laporan/{id}/print', [SuperadminLaporanController::class, 'print'])->name('laporan.print');
        Route::get('/laporan-user', [SuperadminLaporanController::class, 'laporanUser'])->name('laporan-user');

        // Admin Management
        Route::get('/buat-admin', [AkunAdminController::class, 'showAdminForm'])->name('buat-admin');
        Route::post('/simpan-admin', [AkunAdminController::class, 'storeAdmin'])->name('simpan-admin');
        Route::get('/edit-admin/{id}', [AkunAdminController::class, 'edit'])->name('edit-admin');
        Route::put('/update-admin/{id}', [AkunAdminController::class, 'update'])->name('update-admin');
        Route::delete('/hapus-admin/{id}', [AkunAdminController::class, 'destroy'])->name('hapus-admin');

        // User Management
        Route::get('/buat-user', [AkunUserController::class, 'showForm'])->name('buat-user');
        Route::post('/simpan-user', [AkunUserController::class, 'store'])->name('simpan-user');
        Route::get('/edit-user/{id}', [AkunUserController::class, 'edit'])->name('edit-user');
        Route::put('/update-user/{id}', [AkunUserController::class, 'update'])->name('update-user');
        Route::delete('/hapus-user/{id}', [AkunUserController::class, 'destroy'])->name('hapus-user');

        // Cek Bug
        Route::get('/cek-bug', [CekBugController::class, 'index'])->name('cek-bug');
        Route::post('/cek-bug/scan', [CekBugController::class, 'scan'])->name('cek-bug.scan');
        Route::post('/cek-bug/fix/{id}', [CekBugController::class, 'fix'])->name('cek-bug.fix');

        // Berita
        Route::get('/berita', [BeritaController::class, 'index'])->name('upload-berita');
        Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
        Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
        Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
        Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
        Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');

        // Tracking IP
        Route::get('/tracking', [IpTrackingController::class, 'index'])->name('tracking');
        Route::get('/tracking-ip/export', [IpTrackingController::class, 'export'])->name('tracking.export');
        Route::delete('/tracking-ip/clear', [IpTrackingController::class, 'clearOldLogs'])->name('tracking.clearOldLogs');
    });

    // ===================== ADMIN ============================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    //menerrima laporan user
        Route::get('/laporan/pending', [AdminController::class, 'laporanPending'])->name('laporan.pending');
        Route::get('/laporan/{id}', [AdminController::class, 'show'])->name('components.show');
        Route::post('/laporan/{id}/terima', [AdminController::class, 'terimaLaporan'])->name('components.terima');
        Route::post('/laporan/{id}/tolak', [AdminController::class, 'tolakLaporan'])->name('components.tolak');

    // Berita
        Route::get('/berita', [AdminController::class, 'index'])->name('upload-berita');
        Route::get('/berita/create', [AdminController::class, 'create'])->name('berita.create');
        Route::post('/berita', [AdminController::class, 'store'])->name('berita.store');
        Route::get('/berita/{id}/edit', [AdminController::class, 'edit'])->name('berita.edit');
        Route::put('/berita/{id}', [AdminController::class, 'update'])->name('berita.update');
        Route::delete('/berita/{id}', [AdminController::class, 'destroy'])->name('berita.destroy');

      //data usr  
        Route::get('/users', [UserAdminController::class, 'index'])->name('users.data');

        //profil
         Route::get('/admin/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/admin/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::delete('/admin/profil/hapus-foto', [ProfilController::class, 'hapusFoto'])->name('profil.hapusFoto');

    });

    // ===================== USER ============================
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/profil', [UserController::class, 'editProfil'])->name('profil');
        Route::post('/profil', [UserController::class, 'updateProfil'])->name('profil.update');
        Route::delete('/profil/hapus-foto', [UserController::class, 'hapusFoto'])->name('profil.hapusFoto');

        // Laporan
        Route::get('/laporan/kirim/{adminId}', [LaporanController::class, 'create'])->name('laporan.kirim');
        Route::post('/laporan/store/{adminId}', [LaporanController::class, 'store'])->name('laporan.store');
        Route::get('/laporan/riwayat', [LaporanController::class, 'riwayat'])->name('laporan.riwayat');
        Route::get('/laporan/detail/{laporanId}', [LaporanController::class, 'detail'])->name('laporan.detail');
    });
});
