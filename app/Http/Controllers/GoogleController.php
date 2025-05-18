<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembudidaya;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle($tipe)
    {
        if (!in_array($tipe, ['investor', 'usaha'])) {
            abort(400, 'Tipe login tidak valid.');
        }

        session(['login_tipe' => $tipe]);
        return Socialite::driver('google')->redirect();
    }

public function handleGoogleCallback()
{
    $tipe = session('login_tipe');

    if (!in_array($tipe, ['investor', 'usaha'])) {
        abort(400, 'Tipe login tidak valid.');
    }

    $googleUser = Socialite::driver('google')->stateless()->user();

    if (!$googleUser->getEmail()) {
        abort(403, 'Email Google tidak ditemukan atau belum terverifikasi.');
    }

    $email = $googleUser->getEmail();

    // Cek di tabel admin dulu
    $admin = \App\Models\Admin::where('email', $email)->first();
    if ($admin) {
        Auth::guard('admin')->login($admin);
        session()->forget('login_tipe');
        return redirect()->route('admin.dashboard');
    }

    // Cek di tabel pembudidaya
    $pembudidaya = Pembudidaya::where('email', $email)->first();
    if ($pembudidaya) {
        Auth::guard('pembudidaya')->login($pembudidaya);
        session()->forget('login_tipe');
        return redirect()->route('pembudidaya.profil');
    }

    // Cek di tabel user
    $user = User::where('email', $email)->first();
    if ($user) {
        Auth::guard('web')->login($user);
        session()->forget('login_tipe');
        return redirect()->route('produk.rekomendasi');
    }

    // Jika belum ada di semua tabel, buat akun baru sesuai tipe login
    // Namun cek dulu apakah email sudah ada di tabel lain sebelum buat akun baru

    if ($tipe === 'investor') {
        // Jika email sudah ada di pembudidaya atau admin, tolak registrasi baru
        if (Pembudidaya::where('email', $email)->exists() || \App\Models\Admin::where('email', $email)->exists()) {
            abort(403, 'Email ini sudah terdaftar sebagai pembudidaya atau admin. Tidak dapat mendaftar sebagai investor.');
        }

        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $email,
            'password' => bcrypt(Str::random(16)),
            'role' => 'user',
        ]);
        Auth::guard('web')->login($user);
        session()->forget('login_tipe');
        return redirect()->route('produk.rekomendasi');
    }

    if ($tipe === 'usaha') {
        // Jika email sudah ada di user atau admin, tolak registrasi baru
        if (User::where('email', $email)->exists() || \App\Models\Admin::where('email', $email)->exists()) {
            abort(403, 'Email ini sudah terdaftar sebagai investor atau admin. Tidak dapat mendaftar sebagai pembudidaya.');
        }

        $pembudidaya = Pembudidaya::create([
            'name' => $googleUser->getName(),
            'email' => $email,
            'password' => bcrypt(Str::random(16)),
            // Tambahkan field lain jika perlu
        ]);
        Auth::guard('pembudidaya')->login($pembudidaya);
        session()->forget('login_tipe');
        return redirect()->route('pembudidaya.profil');
    }

    abort(400, 'Terjadi kesalahan saat proses login.');
}

}
