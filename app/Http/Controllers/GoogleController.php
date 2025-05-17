<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        /** @var \Laravel\Socialite\Two\GoogleProvider $googleProvider */
        $googleProvider = Socialite::driver('google');
        $googleUser = $googleProvider->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Daftarkan akun baru jika belum ada
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(16)), // password acak
                'role' => 'investor', // default, bisa disesuaikan
            ]);
        }

        Auth::login($user);

        return redirect()->route('produk.rekomendasi'); // arahkan ke home atau dashboard
    }
}
