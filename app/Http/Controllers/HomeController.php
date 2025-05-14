<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class HomeController extends Controller
{
public function rekomendasi(Request $request)
{
    // Ambil input dari form pencarian
    $jenis = $request->input('jenis_komoditas');
    $hargaMin = $request->input('harga_min');
    $hargaMax = $request->input('harga_max');
    $kapasitas = $request->input('kapasitas');
    $kecamatan = $request->input('kecamatan');
    $prediksi = $request->input('prediksi_panen');

    $isFiltered = $jenis || $hargaMin || $hargaMax || $kapasitas || $kecamatan || $prediksi;

    if (!$isFiltered) {
        $produkList = Produk::with('pembudidaya')
            ->where('is_approved', true)
            ->latest()
            ->take(8)
            ->get();

        return view('home', [
            'recommendedProducts' => $produkList,
            'filters' => [],
        ]);
    }

    // Ambil semua produk disetujui untuk dibandingkan menggunakan bobot
    $produkList = Produk::with('pembudidaya')
        ->where('is_approved', true)
        ->get();

    $produkTerbobot = $produkList->map(function ($produk) use ($jenis, $hargaMin, $hargaMax, $kapasitas, $kecamatan, $prediksi) {
        $bobot = 0;

        // Bobot masing-masing kriteria
        $bobotJenis = 0.2;
        $bobotHarga = 0.2;
        $bobotKapasitas = 0.2;
        $bobotKecamatan = 0.2;
        $bobotPrediksi = 0.2;

        // Jenis Komoditas
        if ($jenis && strtolower($produk->jenis_komoditas) == strtolower($jenis)) {
            $bobot += $bobotJenis;
        }

        // Harga
        if ($hargaMin && $hargaMax) {
            $hargaRata2 = ($produk->kisaran_harga_min + $produk->kisaran_harga_max) / 2;
            $preferensiHarga = ($hargaMin + $hargaMax) / 2;
            $selisih = abs($preferensiHarga - $hargaRata2);
            $skorHarga = 1 / (1 + $selisih);
            $bobot += $skorHarga * $bobotHarga;
        }

        // Kapasitas Produksi
        if ($kapasitas) {
            $skorKapasitas = min($produk->kapasitas_produksi / $kapasitas, 1);
            $bobot += $skorKapasitas * $bobotKapasitas;
        }

        // Kecamatan
        if ($kecamatan && strtolower($produk->kecamatan) == strtolower($kecamatan)) {
            $bobot += $bobotKecamatan;
        }

        // Prediksi Panen
        if ($prediksi) {
            $selisihHari = abs(strtotime($produk->prediksi_panen) - strtotime($prediksi)) / 86400;
            $skorPrediksi = 1 / (1 + $selisihHari);
            $bobot += $skorPrediksi * $bobotPrediksi;
        }

        $produk->bobot = round($bobot, 4); // untuk display/debug
        return $produk;
    });

    // Urutkan dan ambil maksimal 8 produk
    $sortedProduk = $produkTerbobot->sortByDesc('bobot')->take(8)->values();

    return view('home', [
        'recommendedProducts' => $sortedProduk,
        'filters' => $request->all(),
    ]);
}
}
