<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rincian Pesanan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; }
        .container { width: 90%; margin: 0 auto; }
        h1 { text-align: center; font-size: 16pt; }
        .section { margin-bottom: 20px; }
        .section-title { font-weight: bold; font-size: 14pt; margin-bottom: 10px; }
        .detail { margin-bottom: 5px; }
        .detail-label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rincian Pesanan</h1>

        <div class="section">
            <div class="section-title">Detail Pesanan</div>
            <div class="detail">
                <span class="detail-label">ID Pesanan:</span> {{ $order_id }}
            </div>
            <div class="detail">
                <span class="detail-label">Nama Customer:</span> {{ $nama_customer }}
            </div>
            <div class="detail">
                <span class="detail-label">No. HP Customer:</span> {{ $no_hp_customer }}
            </div>
            <div class="detail">
                <span class="detail-label">Jumlah Dipesan:</span> {{ $jumlah }} kg
            </div>
            <div class="detail">
                <span class="detail-label">Tanggal Order:</span> {{ $tanggal_order }}
            </div>
            <div class="detail">
                <span class="detail-label">Catatan:</span> {{ $keterangan }}
            </div>
        </div>

        <div class="section">
            <div class="section-title">Detail Produk</div>
            <div class="detail">
                <span class="detail-label">Jenis Komoditas:</span> {{ $jenis_komoditas }}
            </div>
            <div class="detail">
                <span class="detail-label">Jenis Spesifik Komoditas:</span> {{ $jenis_spesifik_komoditas ?? '-' }}
            </div>
            <div class="detail">
                <span class="detail-label">Kapasitas Produksi:</span> {{ $kapasitas_produksi }} kg
            </div>
            <div class="detail">
                <span class="detail-label">Masa Produksi Puncak:</span> {{ $masa_produksi_puncak ?? '-' }}
            </div>
            <div class="detail">
                <span class="detail-label">Prediksi Panen:</span> {{ $prediksi_panen }}
            </div>
            <div class="detail">
                <span class="detail-label">Kisaran Harga:</span> 
                @if ($kisaran_harga_min !== null && $kisaran_harga_max !== null)
                    Rp {{ number_format($kisaran_harga_min, 0, ',', '.') }} - Rp {{ number_format($kisaran_harga_max, 0, ',', '.') }}
                @else
                    -
                @endif
            </div>
            <div class="detail">
                <span class="detail-label">Detail Tambahan:</span> {{ $detail ?? '-' }}
            </div>
            <div class="detail">
                <span class="detail-label">Telepon:</span> {{ $telepon }}
            </div>
            <div class="detail">
                <span class="detail-label">Alamat Lengkap:</span> {{ $alamat_lengkap }}
            </div>
            <div class="detail">
                <span class="detail-label">Kecamatan:</span> {{ $kecamatan }}
            </div>
            <div class="detail">
                <span class="detail-label">Desa:</span> {{ $desa }}
            </div>
            <div class="detail">
                <span class="detail-label">Koordinat:</span> {{ $latitude }}, {{ $longitude }}
            </div>
            <div class="detail">
                <span class="detail-label">Tanggal Diunggah:</span> {{ $tanggal_diunggah }}
            </div>
        </div>
    </div>
</body>
</html>