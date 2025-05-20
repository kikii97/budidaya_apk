@extends('layouts.app')

@section('title', 'Edit Komoditas')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="container py-4" style="padding-top: 1rem !important;">
    <a href="{{ url('/detail_usaha/' . session('pembudidaya_id')) }}" class="text-muted small">
        <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>

    <div class="card p-3 mt-3" style="font-size: 0.85rem;">
        @if (session('success'))
            <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ str_replace(
                                [
                                    'The phone field must be between 10 and 15 digits.',
                                    'The address field is required.',
                                    'The commodity type field is required.',
                                    'The price range field is required.',
                                    'The image field is required.',
                                    'The phone field must not be greater than 20 characters.',
                                ],
                                [
                                    'Kolom nomor telepon harus terdiri dari 10 hingga 15 digit.',
                                    'Kolom alamat wajib diisi.',
                                    'Kolom jenis Komoditas wajib diisi.',
                                    'Kolom kisaran harga jual wajib diisi.',
                                    'Kolom foto Komoditas wajib diunggah.',
                                    'Kolom nomor telepon harus tidak lebih dari 20 angka.',
                                ],
                                $error
                            ) }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pembudidaya.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" style="font-size: 0.9rem;">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="mb-3 col-md-6">
                    <label class="form-label small">Nomor Telepon</label>
                    <input type="text" class="form-control form-control-sm" name="phone" value="{{ old('phone', $produk->telepon) }}" required
                        oninvalid="this.setCustomValidity('Harap isi nomor telepon yang valid.')" oninput="this.setCustomValidity('')">
                </div>

                <div class="mb-3 col-md-6">
                    <label for="kecamatan" class="form-label small">Kecamatan</label>
                    <select class="form-select form-select-sm" id="kecamatan" name="kecamatan" required
                        oninvalid="this.setCustomValidity('Harap pilih kecamatan.')" oninput="this.setCustomValidity('')">
                        @foreach($kecamatanList as $kecamatan)
                            <option value="{{ $kecamatan }}" {{ $produk->kecamatan == $kecamatan ? 'selected' : '' }}>
                                {{ $kecamatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small">Alamat Lengkap</label>
                <textarea class="form-control form-control-sm" name="address" rows="3" required
                    oninvalid="this.setCustomValidity('Harap isi alamat lengkap.')" oninput="this.setCustomValidity('')">{{ old('address', $produk->alamat_lengkap) }}</textarea>
            </div>

            <div class="row g-3">
                <div class="mb-3 col-md-6">
                    <label class="form-label small">Jenis Komoditas</label>
                    <select class="form-select form-select-sm" name="commodity_type" required
                        oninvalid="this.setCustomValidity('Harap pilih jenis komoditas.')" oninput="this.setCustomValidity('')">
                        <option value="" disabled>Pilih Jenis Komoditas</option>
                        @foreach(['Rumput Laut', 'Udang', 'Ikan Gurame', 'Ikan Bandeng', 'Ikan Lele', 'Ikan Nila'] as $komoditas)
                            <option value="{{ $komoditas }}" {{ $produk->jenis_komoditas == $komoditas ? 'selected' : '' }}>{{ $komoditas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label small">Jenis Spesifik Komoditas</label>
                    <input type="text" class="form-control form-control-sm" name="specific_commodity_type" value="{{ old('specific_commodity_type', $produk->jenis_spesifik_komoditas) }}">
                </div>
            </div>

            <div class="row g-3">
                <div class="mb-3 col-md-6">
                    <label class="form-label small">Kapasitas Produksi</label>
                    <input type="number" class="form-control form-control-sm" name="production_capacity" value="{{ old('production_capacity', $produk->kapasitas_produksi) }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label small">Masa Produksi Puncak</label>
                    <input type="text" class="form-control form-control-sm" name="peak_production_period" value="{{ old('peak_production_period', $produk->masa_produksi_puncak) }}">
                </div>
            </div>

            <div class="row g-3">
                <div class="mb-3 col-md-6">
                    <label class="form-label small">Kisaran Harga Minimum</label>
                    <input type="number" class="form-control form-control-sm" name="price_range_min" value="{{ old('price_range_min', $produk->kisaran_harga_min) }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label small">Kisaran Harga Maksimum</label>
                    <input type="number" class="form-control form-control-sm" name="price_range_max" value="{{ old('price_range_max', $produk->kisaran_harga_max) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small">Prediksi Panen (DD-MM-YYYY)</label>
                <input type="text" class="form-control form-control-sm" name="harvest_prediction"
                    value="{{ old('harvest_prediction', \Carbon\Carbon::parse($produk->prediksi_panen)->format('d-m-Y')) }}">
            </div>

            <div class="mb-3">
                <label class="form-label small">Detail</label>
                <textarea class="form-control form-control-sm" name="details" rows="3">{{ old('details', $produk->detail) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label small">Gambar Baru (optional, akan menggantikan gambar lama)</label>
                <input type="file" name="images[]" class="form-control form-control-sm" multiple>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success btn-sm">Simpan Perubahan</button>
                <a href="{{ route('pembudidaya.profil') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>

        </form>
    </div>
</div>
@endsection
