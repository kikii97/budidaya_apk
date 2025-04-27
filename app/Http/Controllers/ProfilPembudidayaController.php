<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilPembudidaya;
use App\Models\Produk;

class ProfilPembudidayaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:pembudidaya');
    }

    public function index()
    {
        $pembudidaya = Auth::guard('pembudidaya')->user();

        if (!$pembudidaya) {
            return redirect()->route('pembudidaya.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $profil = $pembudidaya->profil; // Asumsi sudah ada relasi profil() di Model Pembudidaya
        $produk = Produk::where('pembudidaya_id', $pembudidaya->id)->get();

        return view('profil_pembudidaya', compact('pembudidaya', 'profil', 'produk'));
    }
}
