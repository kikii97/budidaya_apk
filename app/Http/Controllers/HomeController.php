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

        // Ambil data lokasi untuk peta
        $lokasi = Produk::where('is_approved', true)->get([
            'id',
            'gambar',
            'jenis_komoditas',
            'kecamatan',
            'desa',
            'telepon',
            'alamat_lengkap as alamat',
            'latitude',
            'longitude'
        ]);

        // Jika tidak ada filter, tampilkan produk terbaru
        if (!$isFiltered) {
            $produkList = Produk::with('pembudidaya')
                ->where('is_approved', true)
                ->latest()
                ->take(8)
                ->get();

            return view('home', [
                'recommendedProducts' => $produkList,
                'filters' => [],
                'lokasi' => $lokasi
            ]);
        }

        // Ambil semua produk disetujui
        $produkList = Produk::with('pembudidaya')
            ->where('is_approved', true)
            ->get();

        // Bobot kriteria (total 100%)
        $bobotKriteria = [
            'jenis' => 0.2,
            'harga' => 0.2,
            'kapasitas' => 0.2,
            'kecamatan' => 0.2,
            'panen' => 0.2,
        ];

        // Hitung skor tiap produk
        $produkTerbobot = $produkList->map(function ($produk) use ($jenis, $hargaMin, $hargaMax, $kapasitas, $kecamatan, $prediksi, $bobotKriteria) {
            $totalBobot = 0;

            // Jenis Komoditas
            if ($jenis && is_array($jenis) && in_array(strtolower($produk->jenis_komoditas), array_map('strtolower', $jenis))) {
                $totalBobot += $bobotKriteria['jenis'];
            }

            // Harga
            if ($hargaMin && $hargaMax) {
                $hargaPreferensi = ($hargaMin + $hargaMax) / 2;
                $hargaProduk = ($produk->kisaran_harga_min + $produk->kisaran_harga_max) / 2;
                $selisih = abs($hargaPreferensi - $hargaProduk);
                $skorHarga = 1 / (1 + $selisih);
                $totalBobot += $skorHarga * $bobotKriteria['harga'];
            }

            // Kapasitas
            if ($kapasitas && $kapasitas > 0) {
                $skorKapasitas = min($produk->kapasitas_produksi / $kapasitas, 1);
                $totalBobot += $skorKapasitas * $bobotKriteria['kapasitas'];
            }

            // Kecamatan
            if ($kecamatan && is_array($kecamatan) && in_array(strtolower($produk->kecamatan), array_map('strtolower', $kecamatan))) {
                $totalBobot += $bobotKriteria['kecamatan'];
            }

            // Prediksi Panen
            if ($prediksi && $produk->prediksi_panen) {
                $selisihHari = abs(strtotime($produk->prediksi_panen) - strtotime($prediksi)) / 86400;
                $skorPanen = 1 / (1 + $selisihHari);
                $totalBobot += $skorPanen * $bobotKriteria['panen'];
            }

            $produk->bobot = round($totalBobot, 4);
            return $produk;
        });

        // Urutkan dari bobot tertinggi, ambil 8 terbaik
        $sortedProduk = $produkTerbobot->sortByDesc('bobot')->take(8)->values();

        return view('home', [
            'recommendedProducts' => $sortedProduk,
            'filters' => $request->all(),
            'lokasi' => $lokasi
        ]);
    }
}