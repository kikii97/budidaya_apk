<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Komoditas</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pembudidaya.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nomor Telepon:</label>
            <input type="text" name="phone" value="{{ old('phone', $produk->telepon) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Kecamatan:</label>
            <select name="kecamatan" class="form-control" required>
                @foreach($kecamatanList as $kecamatan)
                    <option value="{{ $kecamatan }}" {{ $produk->kecamatan == $kecamatan ? 'selected' : '' }}>{{ $kecamatan }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Alamat Lengkap:</label>
            <input type="text" name="address" value="{{ old('address', $produk->alamat_lengkap) }}" class="form-control" required>
        </div>

        <!-- Jenis Komoditas (Dropdown) -->
        <div class="form-group">
            <label for="commodity_type" class="form-label">Jenis Komoditas</label>
            <select class="form-control" id="commodity_type" name="commodity_type" required
                    oninvalid="this.setCustomValidity('Harap pilih jenis komoditas.')"
                    oninput="this.setCustomValidity('')">
                <option value="" disabled {{ old('commodity_type', $produk->jenis_komoditas) == null ? 'selected' : '' }}>Pilih Jenis Komoditas</option>
                <option value="Rumput Laut" {{ old('commodity_type', $produk->jenis_komoditas) == 'Rumput Laut' ? 'selected' : '' }}>Rumput Laut</option>
                <option value="Udang" {{ old('commodity_type', $produk->jenis_komoditas) == 'Udang' ? 'selected' : '' }}>Udang</option>
                <option value="Ikan Gurame" {{ old('commodity_type', $produk->jenis_komoditas) == 'Ikan Gurame' ? 'selected' : '' }}>Ikan Gurame</option>
                <option value="Ikan Bandeng" {{ old('commodity_type', $produk->jenis_komoditas) == 'Ikan Bandeng' ? 'selected' : '' }}>Ikan Bandeng</option>
                <option value="Ikan Lele" {{ old('commodity_type', $produk->jenis_komoditas) == 'Ikan Lele' ? 'selected' : '' }}>Ikan Lele</option>
                <option value="Ikan Nila" {{ old('commodity_type', $produk->jenis_komoditas) == 'Ikan Nila' ? 'selected' : '' }}>Ikan Nila</option>
            </select>
        </div>

        <div class="form-group">
            <label>Jenis Spesifik Komoditas:</label>
            <input type="text" name="specific_commodity_type" value="{{ old('specific_commodity_type', $produk->jenis_spesifik_komoditas) }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Kapasitas Produksi:</label>
            <input type="number" name="production_capacity" value="{{ old('production_capacity', $produk->kapasitas_produksi) }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Masa Produksi Puncak:</label>
            <input type="text" name="peak_production_period" value="{{ old('peak_production_period', $produk->masa_produksi_puncak) }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Kisaran Harga Minimum:</label>
            <input type="number" name="price_range_min" value="{{ old('price_range_min', $produk->kisaran_harga_min) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Kisaran Harga Maksimum:</label>
            <input type="number" name="price_range_max" value="{{ old('price_range_max', $produk->kisaran_harga_max) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Prediksi Panen (DD-MM-YYYY):</label>
            <input type="text" name="harvest_prediction" value="{{ old('harvest_prediction', \Carbon\Carbon::parse($produk->prediksi_panen)->format('d-m-Y')) }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Detail:</label>
            <textarea name="details" class="form-control">{{ old('details', $produk->detail) }}</textarea>
        </div>

        <div class="form-group">
            <label>Gambar Baru (optional, akan menggantikan gambar lama):</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('pembudidaya.profil') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>
