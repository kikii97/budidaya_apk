<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user) {
            // Ambil preferensi langsung dari kolom users
            $recommendedProducts = Produk::with('pembudidaya')
                ->when($user->komoditas, function ($query) use ($user) {
                    $query->where('jenis_komoditas', $user->komoditas); // Pastikan field sesuai
                })
                ->when($user->harga_min, function ($query) use ($user) {
                    $query->where('kisaran_harga_max', '>=', $user->harga_min);
                })
                ->when($user->harga_max, function ($query) use ($user) {
                    $query->where('kisaran_harga_min', '<=', $user->harga_max);
                })
                ->when($user->kecamatan, function ($query) use ($user) {
                    $query->where('kecamatan', $user->kecamatan);
                })
                ->when($user->prediksi_panen, function ($query) use ($user) {
                    $query->whereDate('prediksi_panen', $user->prediksi_panen);
                })
                ->when($user->kapasitas_produksi, function ($query) use ($user) {
                    $query->where('kapasitas_produksi', '>=', $user->kapasitas_produksi);
                })
                ->latest()
                ->take(10)
                ->get();
        } else {
            $recommendedProducts = Produk::with('pembudidaya')->latest()->take(10)->get();
        }

        return view('home', compact('recommendedProducts'));
    }
}
