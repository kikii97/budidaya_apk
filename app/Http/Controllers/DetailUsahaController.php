<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Produk;

class DetailUsahaController extends Controller
{
    public function __construct()
    {
        // Tidak perlu middleware auth di sini jika akses publik diperbolehkan
    }

    public function index()
    {
        // Periksa apakah pembudidaya sudah login
        $pembudidaya = Auth::guard('pembudidaya')->user();

        if (!$pembudidaya) {
            return redirect()->route('pembudidaya.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Menampilkan profil dan produk yang sudah disetujui
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

    public function show($id)
    {
        // Mendapatkan pembudidaya berdasarkan ID
        $pembudidaya = \App\Models\Pembudidaya::with('profil')->findOrFail($id);

        // Mendapatkan produk yang disetujui oleh admin
        $produk = Produk::where('pembudidaya_id', $id)
            ->where('is_approved', 1)
            ->get();

        // Menambahkan gambar utama untuk setiap produk
        foreach ($produk as $item) {
            $gambarArray = json_decode($item->gambar, true);
            $item->gambar_utama = $gambarArray[0] ?? 'default.jpg';
        }

        // Memeriksa apakah pembudidaya yang login adalah pemilik usaha
        $isOwner = Auth::guard('pembudidaya')->check() && Auth::guard('pembudidaya')->id() == $id;

        return view('detail_usaha', compact('pembudidaya', 'produk', 'isOwner'));
    }
}
