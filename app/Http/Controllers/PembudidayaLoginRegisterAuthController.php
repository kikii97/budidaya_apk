<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembudidaya;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PembudidayaLoginRegisterAuthController extends Controller
{
    // Menampilkan halaman profil pembudidaya
    public function index()
    {
        return view('profil_pembudidaya');
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
            'documents' => 'required|array',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // Simpan pembudidaya
        $pembudidaya = Pembudidaya::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role' => 'pembudidaya',
            'is_approved' => null, // Default belum disetujui
        ]);

        // Proses upload dokumen kalau ada
        $documents = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $filePath = $file->store('dokumen', 'public');
                $documents[] = $filePath;
            }
        }

        // Update pembudidaya dengan dokumen yang sudah diupload
        if (!empty($documents)) {
            $pembudidaya->update(['documents' => $documents]);
        }

        // Tidak login otomatis, arahkan ke login dengan pesan
        return redirect()->route('pembudidaya.waiting')->with('success', 'Pendaftaran berhasil. Akun Anda sedang menunggu persetujuan admin.');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('pembudidaya.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('pembudidaya')->attempt($credentials)) {
            $request->session()->regenerate();

            $pembudidaya = Auth::guard('pembudidaya')->user();

            // Cek apakah sudah disetujui admin
            if (!$pembudidaya->is_approved) {
                Auth::guard('pembudidaya')->logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum disetujui oleh admin.',
                ])->withInput();
            }

            session(['pembudidaya_id' => $pembudidaya->id]);

            return redirect()->route('profil_pembudidaya')->with('success', 'Login berhasil.');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->withInput();
    }

    // Logout pembudidaya
    public function logout(Request $request)
    {
        Auth::guard('pembudidaya')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pembudidaya.login')->with('success', 'Berhasil keluar.');
    }
}
