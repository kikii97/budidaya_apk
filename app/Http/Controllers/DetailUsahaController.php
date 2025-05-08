<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Produk;

class DetailUsahaController extends Controller
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
    
        $profil = $pembudidaya->profil; 
        $produk = Produk::where('pembudidaya_id', $pembudidaya->id)
        ->where('is_approved', 1)
        ->get();

        // Menambahkan gambar utama untuk setiap produk
        foreach ($produk as $item) {
            $gambarArray = json_decode($item->gambar, true);
            $item->gambar_utama = $gambarArray[0] ?? 'default.jpg'; 
        }
    
        return view('detail_usaha', compact('pembudidaya', 'profil', 'produk'));
    }
}
