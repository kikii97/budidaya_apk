<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preferensi Rekomendasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto shadow-sm" style="max-width: 600px;">
            <div class="card-body">
                <h4 class="mb-4 text-center text-primary fw-bold">Preferensi Rekomendasi</h4>
                <form action="{{ route('preferensi.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="komoditas" class="form-label">Jenis Komoditas</label>
                        <input type="text" name="komoditas" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="harga_min" class="form-label">Harga Minimum (Rp)</label>
                        <input type="number" name="harga_min" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="harga_max" class="form-label">Harga Maksimum (Rp)</label>
                        <input type="number" name="harga_max" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <select name="kecamatan" class="form-control">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach (['Anjatan', 'Arahan', 'Balongan', 'Bangodua', 'Bongas'] as $kec)
                                <option value="{{ $kec }}">{{ $kec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="prediksi_panen" class="form-label">Prediksi Panen</label>
                        <input type="date" name="prediksi_panen" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="kapasitas_produksi" class="form-label">Kapasitas Produksi (kg/bulan)</label>
                        <input type="number" name="kapasitas_produksi" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Preferensi</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
