<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LocationController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\BudidayaController;
use App\Http\Controllers\LoginPenggunaAuthController;
use App\Http\Controllers\RegisterPenggunaAuthController;
use App\Http\Controllers\PembudidayaLoginRegisterAuthController;
use App\Http\Controllers\AdminLoginAuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminPenggunaController;
use App\Http\Controllers\AdminPembudidayaController;


Route::get('/', fn () => view('beranda'))->name('beranda');
Route::get('/beranda', fn () => view('beranda')); // alias
Route::get('/welcome', fn () => view('welcome'));
Route::get('/home', fn () => view('home'));

// Halaman informasi umum
Route::view('/tentangkami', 'tentangkami')->name('tentangkami');
Route::view('/daftar_pembudidaya', 'daftar_pembudidaya')->name('daftar_pembudidaya');
Route::view('/detail_pembudidaya', 'detail_pembudidaya')->name('detail_pembudidaya');

Route::get('/lokasi', [LocationController::class, 'showLocations']);


Route::resource('commodity', KomoditasController::class);
Route::resource('budidaya', BudidayaController::class);

<<<<<<< Updated upstream
=======
Route::get('/location', [LocationController::class, 'showLocations']);
>>>>>>> Stashed changes

Route::middleware(['guest'])->group(function () {
    Route::get('/login', fn () => view('login'))->name('login');
    Route::post('/login', [LoginPenggunaAuthController::class, 'authenticate'])->name('login.post');

    Route::get('/register', [RegisterPenggunaAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterPenggunaAuthController::class, 'register'])->name('register.post');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
});


Route::post('/logout', function () {
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } elseif (Auth::guard('pembudidaya')->check()) {
        Auth::guard('pembudidaya')->logout();
    } else {
        Auth::logout(); // default guard
    }

<<<<<<< Updated upstream
    request()->session()->invalidate();
    request()->session()->regenerateToken();
=======
// 🔸 Informasi Pembudidaya
Route::get('/daftar_pembudidaya', fn () => view('daftar_pembudidaya'))->name('daftar_pembudidaya');
Route::get('/katalog', fn () => view('katalog'))->name('katalog');
Route::get('/detail_pembudidaya', fn () => view('detail_pembudidaya'))->name('detail_pembudidaya');
Route::get('/detail', fn () => view('detail'))->name('detail');
Route::get('/profil_pembudidaya', fn () => view('profil_pembudidaya'))->name('profil_pembudidaya');
>>>>>>> Stashed changes

    return redirect()->route('beranda');
})->name('logout');


// 🔐 Login Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginAuthController::class, 'login'])->name('login.post');
});

// 🔐 Setelah Login Admin
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

    Route::resource('pengguna', AdminPenggunaController::class);
    Route::resource('produk', AdminProdukController::class);
    Route::resource('pembudidaya', AdminPembudidayaController::class);

    Route::post('/produk/{id}/approve', [AdminProdukController::class, 'approve'])->name('produk.approve');
    Route::post('/produk/{id}/reject', [AdminProdukController::class, 'reject'])->name('produk.reject');

    Route::post('/pembudidaya/{id}/approve', [AdminPembudidayaController::class, 'approve'])->name('pembudidaya.approve');
    Route::post('/pembudidaya/{id}/reject', [AdminPembudidayaController::class, 'reject'])->name('pembudidaya.reject');

});


// 🔐 Login & Register
Route::prefix('pembudidaya')->name('pembudidaya.')->group(function () {
    Route::get('/login', [PembudidayaLoginRegisterAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PembudidayaLoginRegisterAuthController::class, 'login'])->name('login.post');

    Route::get('/register', [PembudidayaLoginRegisterAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [PembudidayaLoginRegisterAuthController::class, 'register'])->name('register.post');

    Route::middleware(['auth:pembudidaya'])->group(function () {
        Route::get('/waiting', fn () => view('pembudidaya.waiting-approval'))->name('waiting');
        Route::get('/unggah', [ProdukController::class, 'create'])->name('unggah');
        Route::post('/unggah', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/profil', [ProdukController::class, 'index'])->name('profil');
        Route::get('/profil_pembudidaya', [PembudidayaLoginRegisterAuthController::class, 'index'])->name('profil_pembudidaya');
        Route::get('/unggah', [ProdukController::class, 'create'])->name('unggah');
        Route::post('/unggah', [ProdukController::class, 'store'])->name('unggah.simpan');

        // CRUD tambahan (jika edit dan delete diperlukan)
        Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    });
});
