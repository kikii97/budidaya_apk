<?php

namespace App\Http\Controllers;

use App\Models\DokumenPembudidaya;
use App\Models\Produk;
use App\Models\User;
use App\Models\Pembudidaya;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Jumlah total
        $jumlahPengguna = User::count();
        $jumlahPembudidaya = Pembudidaya::count();
        $jumlahKomoditas = Produk::count();

        // Jumlah yang menunggu persetujuan
        $jumlahDokumenMenunggu = DokumenPembudidaya::where('status', 'menunggu')->count();
        $jumlahProdukMenunggu = Produk::whereNull('is_approved')->count();

        // List pembudidaya menunggu persetujuan (pakai paginate)
        $pembudidayaMenunggu = Pembudidaya::whereHas('dokumenPembudidaya', function ($query) {
            $query->where('status', 'menunggu');
        })->with('dokumenPembudidaya')->paginate(5, ['*'], 'pembudidaya_page');

        // List produk menunggu persetujuan (pakai paginate)
        $produkMenunggu = Produk::whereNull('is_approved')
            ->with('pembudidaya')
            ->paginate(5, ['*'], 'produk_page');

        return view('admin.dashboard', compact(
            'jumlahPengguna',
            'jumlahPembudidaya',
            'jumlahKomoditas',
            'jumlahDokumenMenunggu',
            'jumlahProdukMenunggu',
            'pembudidayaMenunggu',
            'produkMenunggu'
        ));
    }
}
