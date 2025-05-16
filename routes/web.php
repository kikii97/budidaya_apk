<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\BudidayaController;
use App\Http\Controllers\LoginRegisterUserController;
use App\Http\Controllers\PembudidayaLoginRegisterAuthController;
use App\Http\Controllers\AdminLoginAuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminPenggunaController;
use App\Http\Controllers\AdminPembudidayaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailUsahaController;

// ─── Halaman Umum ─────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'rekomendasi'])->name('produk.rekomendasi');
Route::get('/welcome', fn () => view('welcome'));

// Halaman informasi publik
Route::view('/tentangkami', 'tentangkami')->name('tentangkami');
Route::get('/katalog', [ProdukController::class, 'katalog'])->name('katalog');
Route::view('/profile', 'profile')->name('profile');
Route::view('/registrasi', 'registrasi')->name('registrasi');
Route::get('/produk/{id}/detail', [ProdukController::class, 'show'])->name('produk.detail');

// Rute untuk melihat detail usaha pembudidaya
Route::get('/detail_usaha/{id}', [DetailUsahaController::class, 'show'])->name('usaha.detail');

// Rute tambahan jika ingin otomatis mengarahkan ke detail usaha pembudidaya yang sedang login
Route::get('/detail_usaha', function () {
    $id = Auth::guard('pembudidaya')->id();
    return redirect()->route('usaha.detail', $id);
})->middleware('auth:pembudidaya')->name('pembudidaya.detail_usaha');

// Lokasi
Route::get('/lokasi', [LocationController::class, 'showLocations']);
Route::get('/location', [LocationController::class, 'showLocations']); // alias

// ─── Komoditas dan Budidaya (CRUD) ────────────────────────────────────────────
Route::resource('commodity', KomoditasController::class);
Route::resource('budidaya', BudidayaController::class);

// ─── Auth Pengguna Umum ───────────────────────────────────────────────────────
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginRegisterUserController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginRegisterUserController::class, 'authenticate'])->name('login.post');

    Route::get('/register', [LoginRegisterUserController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginRegisterUserController::class, 'register'])->name('register.post');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// ─── Logout (untuk semua guard) ───────────────────────────────────────────────
Route::post('/logout', function () {
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } elseif (Auth::guard('pembudidaya')->check()) {
        Auth::logout(); // default guard
    }

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
})->name('logout');

// ─── Login & Register Admin ───────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginAuthController::class, 'login'])->name('login.post');
});

// ─── Setelah Login Admin ──────────────────────────────────────────────────────
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

// ─── Login & Register Pembudidaya ─────────────────────────────────────────────
Route::prefix('pembudidaya')->name('pembudidaya.')->group(function () {
    Route::get('/login', [PembudidayaLoginRegisterAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PembudidayaLoginRegisterAuthController::class, 'login'])->name('login.post');

    Route::get('/register', [PembudidayaLoginRegisterAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [PembudidayaLoginRegisterAuthController::class, 'register'])->name('register.post');

    Route::post('/logout', function () {
    Auth::guard('pembudidaya')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');


    Route::middleware(['auth:pembudidaya'])->group(function () {
        Route::get('/waiting', fn () => view('pembudidaya.waiting-approval'))->name('waiting');
        Route::get('/unggah', [ProdukController::class, 'create'])->name('unggah');
        Route::post('/unggah', [ProdukController::class, 'store'])->name('unggah.simpan');
        Route::get('/profil', [ProdukController::class, 'index'])->name('profil');
        // CRUD produk tambahan
        Route::get('/produk/{id}/detail', [ProdukController::class, 'show'])->name('produk.detail');
        Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    });
});
