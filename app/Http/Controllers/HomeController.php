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

        // Tentukan kriteria yang aktif (tidak kosong)
        $activeCriteria = [];
        if ($jenis) $activeCriteria['jenis'] = 0.2; // Handle as string, not array
        if ($hargaMin && $hargaMax) $activeCriteria['harga'] = 0.2;
        if ($kapasitas && $kapasitas > 0) $activeCriteria['kapasitas'] = 0.2;
        if ($kecamatan) $activeCriteria['kecamatan'] = 0.2; // Handle as string, not array
        if ($prediksi) $activeCriteria['panen'] = 0.2;

        // Normalisasi bobot jika ada kriteria aktif
        $totalBobotKriteria = array_sum($activeCriteria);
        if ($totalBobotKriteria > 0) {
            foreach ($activeCriteria as $key => $value) {
                $activeCriteria[$key] = $value / $totalBobotKriteria; // Normalisasi ke 100%
            }
        }

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

        // Ambil semua produk disetujui
        $produkList = Produk::with('pembudidaya')
            ->where('is_approved', true)
            ->get();

        // Jika tidak ada filter, tampilkan produk terbaru
        if (empty($activeCriteria)) {
            $produkList = $produkList->sortByDesc('created_at')->take(8);
            return view('home', [
                'recommendedProducts' => $produkList,
                'filters' => [], // No filters applied
                'lokasi' => $lokasi
            ]);
        }

        // Hitung skor tiap produk berdasarkan kriteria aktif
        $produkTerbobot = $produkList->map(function ($produk) use ($jenis, $hargaMin, $hargaMax, $kapasitas, $kecamatan, $prediksi, $activeCriteria) {
            $totalBobot = 0;

            // Jenis Komoditas
            if (isset($activeCriteria['jenis'])) {
                if ($jenis && strtolower($produk->jenis_komoditas) === strtolower($jenis)) {
                    $totalBobot += $activeCriteria['jenis'];
                }
            }

            // Harga
            if (isset($activeCriteria['harga'])) {
                $hargaPreferensi = ($hargaMin + $hargaMax) / 2;
                $hargaProduk = ($produk->kisaran_harga_min + $produk->kisaran_harga_max) / 2;
                $selisih = abs($hargaPreferensi - $hargaProduk);
                $skorHarga = 1 / (1 + $selisih / max($hargaPreferensi, 1)); // Hindari pembagian nol
                $totalBobot += $skorHarga * $activeCriteria['harga'];
            }

            // Kapasitas
            if (isset($activeCriteria['kapasitas'])) {
                if ($kapasitas > 0) {
                    $skorKapasitas = min($produk->kapasitas_produksi / $kapasitas, 1);
                    $totalBobot += $skorKapasitas * $activeCriteria['kapasitas'];
                }
            }

            // Kecamatan
            if (isset($activeCriteria['kecamatan'])) {
                if ($kecamatan && strtolower($produk->kecamatan) === strtolower($kecamatan)) {
                    $totalBobot += $activeCriteria['kecamatan'];
                }
            }

            // Prediksi Panen
            if (isset($activeCriteria['panen'])) {
                if ($produk->prediksi_panen) {
                    $selisihHari = abs(strtotime($produk->prediksi_panen) - strtotime($prediksi)) / 86400;
                    $skorPanen = 1 / (1 + $selisihHari / 30); // Normalisasi berdasarkan 30 hari
                    $totalBobot += $skorPanen * $activeCriteria['panen'];
                }
            }

            $produk->bobot = round($totalBobot, 4);
            return $produk;
        });

        // Urutkan dari bobot tertinggi, ambil 8 terbaik
        $sortedProduk = $produkTerbobot->sortByDesc('bobot')->take(8)->values();

        // Jika hasil kosong, fallback ke produk terbaru
        if ($sortedProduk->isEmpty()) {
            $sortedProduk = Produk::with('pembudidaya')
                ->where('is_approved', true)
                ->latest()
                ->take(8)
                ->get();
        }

        return view('home', [
            'recommendedProducts' => $sortedProduk,
            'filters' => $request->all(),
            'lokasi' => $lokasi
        ]);
    }
}