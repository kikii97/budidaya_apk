<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function showKomoditas()
{
    if (!Auth::guard('pembudidaya')->check()) {
        return redirect()->route('login'); // Mengarahkan pengguna ke halaman login jika belum login
    }

    return view('komoditas.index');
}
}

