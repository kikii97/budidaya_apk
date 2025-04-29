<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\BudidayaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginPenggunaAuthController;
use App\Http\Controllers\RegisterPenggunaAuthController;
use App\Http\Controllers\PembudidayaLoginRegisterAuthController;
use App\Http\Controllers\AdminLoginAuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminPenggunaController;
use App\Http\Controllers\AdminPembudidayaController;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::resource('commodity', KomoditasController::class);
Route::resource('budidaya', BudidayaController::class);

Route::get('/', [LocationController::class, 'showLocations']);

/*
|--------------------------------------------------------------------------|
| 🔐 AUTH LOGIC (SEMUA JENIS USER)                                        |
|--------------------------------------------------------------------------|
*/

// 🔸 Logout (semua guard)
Route::post('/logout', function () {
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } elseif (Auth::guard('pembudidaya')->check()) {
        Auth::guard('pembudidaya')->logout();
    } else {
        Auth::logout(); // default web guard
    }

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('beranda');
})->name('logout');

/*
|--------------------------------------------------------------------------|
| 🔹 ADMIN ROUTES                                                         |
|--------------------------------------------------------------------------|
*/

// 🔓 Login Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginAuthController::class, 'login'])->name('login.post');
});

// 🔐 Setelah Login Admin
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    Route::resource('pengguna', AdminPenggunaController::class);
    Route::resource('produk', AdminProdukController::class)->names('produk');
    Route::resource('pembudidaya', AdminPembudidayaController::class)->names('pembudidaya');
});

// Tambahkan di dalam route admin (yang pakai middleware ['auth:admin'])
Route::post('/admin/produk/{id}/approve', [AdminProdukController::class, 'approve'])->name('admin.produk.approve');
Route::post('/admin/produk/{id}/reject', [AdminProdukController::class, 'reject'])->name('admin.produk.reject');


/*
|--------------------------------------------------------------------------|
| 🔹 PEMBUDIDAYA ROUTES                                                   |
|--------------------------------------------------------------------------|
*/

// 🔓 Login & Register Pembudidaya
Route::prefix('pembudidaya')->name('pembudidaya.')->group(function () {
    // Rute login
    Route::get('/login', [PembudidayaLoginRegisterAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PembudidayaLoginRegisterAuthController::class, 'login'])->name('login.post');

    // Rute registrasi
    Route::get('/register', [PembudidayaLoginRegisterAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [PembudidayaLoginRegisterAuthController::class, 'register'])->name('register.post');

    // Setelah login
    Route::middleware(['auth:pembudidaya'])->group(function () {
        // 🔄 Mengarahkan unggah ke ProdukController
        Route::get('/unggah', [ProdukController::class, 'create'])->name('unggah');
        Route::post('/unggah', [ProdukController::class, 'store'])->name('produk.store');
        
        // 🔸 Lihat daftar produk miliknya
        Route::get('/profil', [ProdukController::class, 'index'])->name('profil');
    });
});

/*
|--------------------------------------------------------------------------|
| 🔹 PENGGUNA UMUM (PEMBELI)                                              |
|--------------------------------------------------------------------------|
*/

// Rute untuk login dan register untuk pengguna umum
Route::middleware(['guest'])->group(function () {
    Route::get('/login', fn () => view('login'))->name('login');
    Route::post('/login', [LoginPenggunaAuthController::class, 'authenticate'])->name('login.post');

    Route::get('/register', [RegisterPenggunaAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterPenggunaAuthController::class, 'register'])->name('register.post');
});

// Rute untuk profil pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
});

/*
|--------------------------------------------------------------------------|
| 🔹 ROUTE UMUM / PUBLIK                                                   |
|--------------------------------------------------------------------------|
*/

// 🔸 Beranda
Route::get('/', fn () => view('beranda'))->name('beranda');
Route::get('/beranda', fn () => view('beranda'))->name('beranda.duplikat');

// 🔸 Informasi Pembudidaya
Route::get('/daftar_pembudidaya', fn () => view('daftar_pembudidaya'))->name('daftar_pembudidaya');
Route::get('/detail_pembudidaya', fn () => view('detail_pembudidaya'))->name('detail_pembudidaya');
Route::get('/profil_pembudidaya', fn () => view('profil_pembudidaya'))->name('profil_pembudidaya');

// 🔸 Halaman Informasi Tambahan
Route::get('/tentangkami', fn () => view('tentangkami'))->name('tentangkami');

