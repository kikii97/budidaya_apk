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
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Validasi banyak file
        ]);
    
        // Simpan pembudidaya
        $pembudidaya = Pembudidaya::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role' => 'pembudidaya',
        ]);
    
        // Proses upload dokumen kalau ada
        $documents = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                // Simpan file ke storage/public/documents_pembudidaya/
                $filePath = $file->store('dokumen', 'public');
                $documents[] = $filePath;  // Menyimpan path ke dalam array
            }
        }
    
        // Update pembudidaya dengan dokumen yang sudah diupload
        if (!empty($documents)) {
            $pembudidaya->update(['documents' => json_encode($documents)]);  // Menyimpan path dokumen sebagai JSON
        }
    
        // Login otomatis setelah register
        Auth::guard('pembudidaya')->login($pembudidaya);
    
        return redirect()->route('profil_pembudidaya')->with('success', 'Registrasi berhasil. Selamat datang!');
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

            // Simpan ID Pembudidaya ke dalam sesi
            session(['pembudidaya_id' => Auth::guard('pembudidaya')->user()->id]);

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
