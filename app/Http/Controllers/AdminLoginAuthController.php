<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginAuthController extends Controller
{
    // Menampilkan Form Login Admin
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Proses Autentikasi Admin
    public function authenticate(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Menggunakan guard('admin') untuk login
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke dashboard admin
            return redirect()->intended(route('admin.dashboard'));
        }

        // Jika login gagal, kembali dengan error
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }
}
