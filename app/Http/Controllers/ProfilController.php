<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function showKomoditas()
    {
        if (!Auth::guard('pembudidaya')->check()) {
            return redirect()->route('login');
        }
    
        return view('komoditas.index');
    }
    
}

