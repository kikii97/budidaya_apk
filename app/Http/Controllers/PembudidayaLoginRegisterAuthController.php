<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembudidaya;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PembudidayaLoginRegisterAuthController extends Controller
{

    public function index()
{
    return view('profil_pembudidaya'); // Pastikan ada file 'profil_pembudidaya.blade.php' di views
}

    // Menampilkan form register
    public function showRegisterForm()
    {
        return view('pembudidaya.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pembudidaya,email',
            'password' => 'required|min:6|confirmed',
            'address' => 'required|string',
        ]);
    
        $pembudidaya = Pembudidaya::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role' => 'pembudidaya'
        ]);
    
        // Login otomatis dengan guard pembudidaya
        Auth::guard('pembudidaya')->login($pembudidaya);
    
        return redirect()->route('profil_pembudidaya')->with('success', 'Registrasi berhasil. Selamat datang!');
    }    

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('pembudidaya.login');
    }

    // Proses login
// Proses login
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Cek kredensial dan login menggunakan guard 'pembudidaya'
    if (Auth::guard('pembudidaya')->attempt($credentials)) {
        $request->session()->regenerate();

        // Simpan ID Pembudidaya ke dalam sesi
        session(['pembudidaya_id' => Auth::guard('pembudidaya')->user()->id]);

        // Redirect ke halaman profil atau halaman yang diinginkan
        return redirect()->route('profil_pembudidaya')->with('success', 'Login berhasil.');
    }

    return back()->withErrors(['email' => 'Email atau kata sandi salah.'])->withInput();
}

    }
