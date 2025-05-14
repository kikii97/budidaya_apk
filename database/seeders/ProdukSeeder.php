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

        $kecamatanIndramayu = [
            'Anjatan', 'Arahan', 'Balongan', 'Bangodua', 'Bongas', 'Cantigi',
            'Cikedung', 'Gabuswetan', 'Gantar', 'Haurgeulis', 'Indramayu',
            'Jatibarang', 'Juntinyuat', 'Kandanghaur', 'Karangampel', 'Kedokan Bunder',
            'Kertasemaya', 'Krangkeng', 'Kroya', 'Lelea', 'Lohbener', 'Losarang',
            'Pasekan', 'Patrol', 'Sindang', 'Sliyeg', 'Sukagumiwang', 'Sukra',
            'Terisi', 'Tukdana', 'Widasari'
        ];

        $komoditas = [
            'Udang',
            'Rumput Laut',
            'Ikan Bandeng',
            'Ikan Gurame',
            'Ikan Lele',
            'Ikan Nila'
        ];

        foreach ($pembudidayas as $pembudidaya) {
            for ($i = 1; $i <= 4; $i++) {
                $komoditasTerpilih = $komoditas[array_rand($komoditas)];
                Produk::create([
                    'gambar' => json_encode(['img1.jpg', 'img2.jpg']),
                    'telepon' => '08123456789',
                    'alamat_lengkap' => "Jl. Mawar No. $i",
                    'kecamatan' => $kecamatanIndramayu[array_rand($kecamatanIndramayu)], // Mengambil nama kecamatan secara acak dari Indramayu
                    'jenis_komoditas' => $komoditasTerpilih,
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
