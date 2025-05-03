<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user) {
            $preferences = UserPreference::where('user_id', $user->id)->first();
    
            if (!$preferences) {
                $recommendedProducts = Produk::latest()->take(10)->get();
            } else {
                $recommendedProducts = Produk::query()
                    ->when($preferences->komoditas, function ($query) use ($preferences) {
                        $query->where('komoditas', $preferences->komoditas);
                    })
                    ->when($preferences->harga_min, function ($query) use ($preferences) {
                        $query->where('harga', '>=', $preferences->harga_min);
                    })
                    ->when($preferences->harga_max, function ($query) use ($preferences) {
                        $query->where('harga', '<=', $preferences->harga_max);
                    })
                    ->when($preferences->kecamatan, function ($query) use ($preferences) {
                        $query->where('kecamatan', $preferences->kecamatan);
                    })
                    ->when($preferences->prediksi_panen, function ($query) use ($preferences) {
                        $query->whereDate('tanggal_panen', $preferences->prediksi_panen);
                    })
                    ->when($preferences->kapasitas_produksi, function ($query) use ($preferences) {
                        $query->where('kapasitas', '>=', $preferences->kapasitas_produksi);
                    })
                    ->latest()
                    ->take(10)
                    ->get();
            }
        } else {
            // fallback: misal pengguna tidak login
            $recommendedProducts = Produk::latest()->take(10)->get();
        }
    
        return view('home', compact('recommendedProducts'));
    }
}    
