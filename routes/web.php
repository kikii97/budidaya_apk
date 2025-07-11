<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\BudidayaController;
use App\Http\Controllers\LoginRegisterController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminPenggunaController;
use App\Http\Controllers\AdminPembudidayaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailUsahaController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PembudidayaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\DokumenPembudidayaController;
use App\Http\Controllers\AdminDashboardController;


// ─── Halaman Umum ─────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'rekomendasi'])->name('produk.rekomendasi');
Route::get('/welcome', fn () => view('welcome'));

// Halaman informasi publik
Route::view('/tentangkami', 'tentangkami')->name('tentangkami');
Route::get('/katalog', [ProdukController::class, 'katalog'])->name('katalog');
Route::view('/profile', 'profile')->name('profile');
Route::view('/registrasi', 'registrasi')->name('registrasi');
Route::get('/produk/{id}/detail', [ProdukController::class, 'show'])->name('produk.detail');
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/produk/{id}/detail', [ProdukController::class, 'show'])->name('produk.detail');


// Rute untuk melihat detail usaha pembudidaya
Route::get('/detail_usaha/{id}', [DetailUsahaController::class, 'show'])->name('usaha.detail');
Route::middleware(['auth:pembudidaya'])->group(function () {
    Route::get('/profil/edit', [PembudidayaController::class, 'edit'])->name('pembudidaya.edit');
    Route::post('/profil/update', [PembudidayaController::class, 'update'])->name('pembudidaya.update');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotifikasiController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/clear', [NotifikasiController::class, 'clearAll'])->name('notifications.clearAll');
    Route::get('/notifications/{id}', [NotifikasiController::class, 'show']);

});

// Rute otomatis ke detail usaha pembudidaya yang sedang login
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

// Google Auth untuk investor/usaha
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/auth/google/{tipe}', [GoogleController::class, 'redirectToGoogle'])->name('login.google.with.tipe');

// ─── Auth Pengguna Umum ───────────────────────────────────────────────────────
// Asumsikan controller untuk login/register user umum adalah LoginRegisterController
Route::middleware(['guest:web', 'no.cache'])->group(function () {
    Route::get('/login', [LoginRegisterController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginRegisterController::class, 'login'])->name('login.post');

    Route::get('/register', [LoginRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginRegisterController::class, 'register'])->name('register.post');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// ─── Logout untuk semua guard ───────────────────────────────────────────────
Route::post('/logout', function () {
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } elseif (Auth::guard('pembudidaya')->check()) {
        Auth::guard('pembudidaya')->logout();
    } elseif (Auth::guard('web')->check()) {
        Auth::guard('web')->logout();
    }

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('produk.rekomendasi');
})->name('logout');

// ─── Login & Register Admin ───────────────────────────────────────────────────
// Asumsikan controller admin login juga LoginRegisterController, 
// atau sesuaikan dengan controller login admin Anda sekarang
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('/login', [LoginRegisterController::class, 'showAdminLoginForm'])->name('login');
        Route::post('/login', [LoginRegisterController::class, 'login'])->name('login.post');
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard'); 
        Route::resource('pengguna', AdminPenggunaController::class);
        Route::resource('produk', AdminProdukController::class);
        Route::resource('pembudidaya', AdminPembudidayaController::class);

        Route::post('/produk/{id}/approve', [AdminProdukController::class, 'approve'])->name('produk.approve');
        Route::post('/produk/{id}/reject', [AdminProdukController::class, 'reject'])->name('produk.reject');
        Route::get('/produk/{id}/detail', [AdminProdukController::class, 'show'])->name('produk.detail');
        Route::post('/dokumen/{id}/approve', [AdminPembudidayaController::class, 'approve'])->name('dokumen.approve');
        Route::post('/dokumen/{id}/reject', [AdminPembudidayaController::class, 'reject'])->name('dokumen.reject');
        Route::get('/dokumen/{id}', [AdminPembudidayaController::class, 'show'])->name('dokumen.show');
    });
});

// ─── Login & Register Pembudidaya ─────────────────────────────────────────────
// Asumsikan controller pembudidaya login juga di LoginRegisterController
Route::prefix('pembudidaya')->name('pembudidaya.')->group(function () {
    Route::middleware(['guest:pembudidaya'])->group(function () {
        Route::get('/login', [LoginRegisterController::class, 'showPembudidayaLoginForm'])->name('login');
        Route::post('/login', [LoginRegisterController::class, 'login'])->name('login.post');

        Route::get('/register', [LoginRegisterController::class, 'showPembudidayaRegisterForm'])->name('register');
        Route::post('/register', [LoginRegisterController::class, 'pembudidayaRegister'])->name('register.post');
    });

    Route::middleware(['auth:pembudidaya'])->group(function () {
        Route::get('/waiting', fn () => view('pembudidaya.waiting-approval'))->name('waiting');
        Route::get('/unggah', [ProdukController::class, 'create'])->name('unggah');
        Route::post('/unggah', [ProdukController::class, 'store'])->name('unggah.simpan');
        Route::get('/profil', [ProdukController::class, 'index'])->name('profil');
        Route::get('/profil', [DetailUsahaController::class, 'index'])->name('profil');

        // Dokumen Pembudidaya
        Route::get('/dokumen/create', [DokumenPembudidayaController::class, 'create'])->name('dokumen.create');
        Route::post('/dokumen', [DokumenPembudidayaController::class, 'store'])->name('dokumen.store');

        // CRUD produk tambahan
        Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::delete('/produk/delete/multiple', [ProdukController::class, 'destroyMultiple'])->name('pembudidaya.produk.destroy.multiple');
    });
});
