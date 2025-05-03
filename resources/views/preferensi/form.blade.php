<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preferensi Rekomendasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto shadow-sm" style="max-width: 600px;">
            <div class="card-body">
                <h4 class="mb-4 text-center text-primary fw-bold">Preferensi Rekomendasi</h4>
                <form action="{{ route('preferensi.store') }}" method="POST">
                    @csrf

                    <!-- Jenis Komoditas -->
                    <div class="mb-3">
                        <label for="komoditas" class="form-label">Jenis Komoditas</label>
                        <select name="komoditas" id="komoditas" class="form-select" required>
                            <option value="" disabled selected>Pilih Jenis Komoditas</option>
                            <option value="Rumput Laut">Rumput Laut</option>
                            <option value="Udang">Udang</option>
                            <option value="Ikan Gurame">Ikan Gurame</option>
                            <option value="Ikan Bandeng">Ikan Bandeng</option>
                            <option value="Ikan Lele">Ikan Lele</option>
                            <option value="Ikan Nila">Ikan Nila</option>
                        </select>
                    </div>

                    <!-- Harga -->
                    <div class="mb-3">
                        <label for="harga_min" class="form-label">Harga Minimum (Rp)</label>
                        <input type="number" name="harga_min" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="harga_max" class="form-label">Harga Maksimum (Rp)</label>
                        <input type="number" name="harga_max" class="form-control">
                    </div>

                    <!-- Kecamatan -->
                    <div class="mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="form-select" required>
                            <option value="" disabled selected>Pilih Kecamatan</option>
                            @foreach($kecamatanList as $kecamatan)
                                <option value="{{ $kecamatan }}">{{ $kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Prediksi Panen -->
                    <div class="mb-3">
                        <label for="prediksi_panen" class="form-label">Prediksi Panen</label>
                        <input type="text" name="prediksi_panen" id="prediksi_panen" class="form-control" placeholder="Contoh: 21-04-2025" autocomplete="off">
                    </div>

                    <!-- Kapasitas Produksi -->
                    <div class="mb-3">
                        <label for="kapasitas_produksi" class="form-label">Kapasitas Produksi (kg/bulan)</label>
                        <input type="number" name="kapasitas_produksi" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan Preferensi</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script>
        flatpickr("#prediksi_panen", {
            dateFormat: "d-m-Y",
            locale: "id",
            allowInput: true
        });
    </script>
</body>
</html>
