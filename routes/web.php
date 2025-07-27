<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect()->route('home');
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('superadmin')) {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('dashboard');

    Route::get('/superadmin/dashboard', function () {
        return view('superadmin.pages.dashboard');
    })->name('superadmin.dashboard');
    Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::view('/laporan', 'superadmin.pages.components.laporan-user')->name('superadmin.laporan');
    Route::view('/buat-admin', 'superadmin.pages.components.buat-admin')->name('superadmin.buat-admin');
    Route::view('/buat-user', 'superadmin.pages.components.buat-user')->name('superadmin.buat-user');
    Route::view('/cek-bug', 'superadmin.pages.components.cek-bug')->name('superadmin.cek-bug');
    Route::view('/upload-berita', 'superadmin.pages.components.upload-berita')->name('superadmin.upload-berita');
    Route::view('/tracking', 'superadmin.pages.components.tracking-ip')->name('superadmin.tracking');
    });


    Route::get('/admin/dashboard', function () {
        return view('admin.pages.dashboard');
    })->name('admin.dashboard');

    Route::get('/user/dashboard', function () {
        return view('user.pages.dashboard');
    })->name('user.dashboard');
});