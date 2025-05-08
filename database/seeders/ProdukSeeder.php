<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Pembudidaya;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $pembudidayas = Pembudidaya::where('is_approved', 1)->get(); // hanya ambil pembudidaya yang disetujui
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        foreach ($pembudidayas as $pembudidaya) {
            for ($i = 1; $i <= 3; $i++) {
                Produk::create([
                    'gambar' => json_encode(['img1.jpg', 'img2.jpg']),
                    'telepon' => '08123456789',
                    'alamat_lengkap' => "Jl. Mawar No. $i",
                    'kecamatan' => "Kecamatan $i",
                    'jenis_komoditas' => "Komoditas $i",
                    'jenis_spesifik_komoditas' => "Spesifik $i",
                    'kapasitas_produksi' => rand(100, 500),
                    'masa_produksi_puncak' => $bulan[array_rand($bulan)],
                    'kisaran_harga_min' => 10000 + $i * 500,
                    'kisaran_harga_max' => 15000 + $i * 500,
                    'prediksi_panen' => now()->addDays(rand(10, 60)),
                    'detail' => "Detail produk $i",
                    'is_approved' => rand(0, 1),
                    'pembudidaya_id' => $pembudidaya->id,
                ]);
            }
        }
    }
}
