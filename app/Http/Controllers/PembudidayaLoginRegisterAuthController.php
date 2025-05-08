<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembudidaya;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PembudidayaLoginRegisterAuthController extends Controller
{
    // Menampilkan halaman profil pembudidaya
    public function index()
    {
        $pembudidaya = Auth::guard('pembudidaya')->user(); // ambil data pembudidaya yang login
        $produk = $pembudidaya->produk; // ambil semua produk milik pembudidaya ini
    
        return view('detail_usaha', compact('pembudidaya', 'produk'));
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
    
        $pembudidaya = Pembudidaya::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role' => 'pembudidaya',
            'is_approved' => null,
        ]);
    
        // Upload dokumen
        $documents = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $filePath = $file->store('dokumen', 'public');
                $documents[] = $filePath;
            }
        }
    
        if (!empty($documents)) {
            $pembudidaya->update(['documents' => $documents]);
        }
    
        // ✅ Redirect ke halaman login dengan info bahwa akun sedang menunggu persetujuan
        return view('pembudidaya.waiting-approval', ['pembudidaya' => $pembudidaya]);
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
    
            // Cek status persetujuan
            if (is_null($pembudidaya->is_approved)) {
                Auth::guard('pembudidaya')->logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum disetujui oleh admin.',
                ])->withInput();
            }
    
            if ($pembudidaya->is_approved === 0) {
                Auth::guard('pembudidaya')->logout();
                return back()->withErrors([
                    'email' => 'Akun Anda telah ditolak oleh admin.',
                ])->withInput();
            }
    
            // Jika is_approved === 1 (disetujui), lanjutkan
            session(['pembudidaya_id' => $pembudidaya->id]);
    
            return redirect()->route('pembudidaya.detail_usaha')->with('success', 'Login berhasil.');
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
