<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Admin;
use App\Models\Pembudidaya;

class LoginRegisterController extends Controller
{
    public function __construct()
    {
        // Guest middleware agar tidak bisa akses login saat sudah login
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:pembudidaya')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm(Request $request)
    {
        // Ambil tipe dari URL, misal ?tipe=usaha/investor
        $tipe = $request->query('tipe', 'investor'); // default ke investor
        return view('register', compact('tipe'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'tipe'     => 'required|in:investor,usaha',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validasi unik email di seluruh guard
        $email = $request->email;
        if (
            User::where('email', $email)->exists() ||
            Pembudidaya::where('email', $email)->exists() ||
            Admin::where('email', $email)->exists()
        ) {
            return back()->withErrors(['email' => 'Email sudah digunakan'])->withInput();
        }

        $data = $validator->validated();

        // Buat akun berdasarkan tipe
        if ($data['tipe'] === 'usaha') {
            $user = Pembudidaya::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            Auth::guard('pembudidaya')->login($user);
            return redirect()->route('pembudidaya.profil');
        }

        if ($data['tipe'] === 'investor') {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            Auth::guard('web')->login($user);
            return redirect()->route('home');
        }

        return back()->withErrors(['tipe' => 'Tipe tidak valid.'])->withInput();
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $validator->validated();

        // Login urut berdasarkan guard
        if (Admin::where('email', $credentials['email'])->exists()) {
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }
        }

        if (Pembudidaya::where('email', $credentials['email'])->exists()) {
            if (Auth::guard('pembudidaya')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('pembudidaya.detail_usaha');
            }
        }

        if (User::where('email', $credentials['email'])->exists()) {
            if (Auth::guard('web')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('home');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        // Logout dari guard yang sedang aktif
        foreach (['admin', 'web', 'pembudidaya'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
                break;
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('profile.index')->with('success', 'Berhasil logout');
    }
}
