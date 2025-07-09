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
        $pembudidaya = \App\Models\Pembudidaya::with('profil')->find(Auth::guard('pembudidaya')->id());

        if (!$pembudidaya) {
            return redirect()->route('pembudidaya.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $profil = $pembudidaya->profil;

        $produk = Produk::where('pembudidaya_id', $pembudidaya->id)
            ->where('is_approved', 1)
            ->get();

        foreach ($produk as $item) {
            $gambarArray = json_decode($item->gambar, true);
            $item->gambar_utama = $gambarArray[0] ?? 'default.jpg';
        }

        $user = $pembudidaya;

        return view('detail_usaha', compact('pembudidaya', 'profil', 'produk', 'user'));
    }

    public function show($id)
    {
        $pembudidaya = \App\Models\Pembudidaya::with('profil')->find(Auth::guard('pembudidaya')->id());

        $produk = Produk::where('pembudidaya_id', $id)
            ->where('is_approved', 1)
            ->get();

        foreach ($produk as $item) {
            $gambarArray = json_decode($item->gambar, true);
            $item->gambar_utama = $gambarArray[0] ?? 'default.jpg';
        }

        $isOwner = Auth::guard('pembudidaya')->check() && Auth::guard('pembudidaya')->id() == $id;

        $user = Auth::guard('pembudidaya')->user(); // bisa null jika pengunjung

        return view('detail_usaha', compact('pembudidaya', 'produk', 'isOwner', 'user'));
    }

}
