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
                <label for="harvest_prediction" class="form-label small">Prediksi Panen</label>
                <input type="text"
                    class="form-control form-control-sm"
                    id="harvest_prediction"
                    name="harvest_prediction"
                    placeholder="Contoh: 21 April 2025"
                    autocomplete="off"
                    value="{{ old('harvest_prediction', $produk->prediksi_panen ? \Carbon\Carbon::parse($produk->prediksi_panen)->translatedFormat('d F Y') : '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label small">Detail</label>
                <textarea class="form-control form-control-sm" name="details" rows="3">{{ old('details', $produk->detail) }}</textarea>
            </div>

            {{-- Bagian unggah gambar baru --}}
            <div class="mb-3">
                <label class="form-label small">Unggah Gambar</label>
                <input type="file" id="images" name="images[]" class="form-control form-control-sm" multiple accept="image/*" onchange="previewImages(event)">
                <div id="imagePreview" class="mt-2"></div>
            </div>

            {{-- Bagian gambar lama (jika ada) --}}
            @if ($produk->gambar && is_array(json_decode($produk->gambar, true)))
                <div class="mb-3">
                    <label class="form-label small">Gambar Sebelumnya</label>
                    <div class="row g-2">
                        @foreach (json_decode($produk->gambar, true) as $index => $gambar)
                            <div class="col-4 col-md-2 old-image-wrapper">
                                <div class="image-box">
                                    <img src="{{ asset('apk_gis/public/storage/images/' . $gambar) }}" alt="Gambar Produk">
                                </div>
                                <div class="form-check mt-1 d-flex align-items-center justify-content-center">
                                    <input class="form-check-input" type="checkbox" name="hapus_gambar[]" value="{{ $gambar }}" id="hapus_{{ $index }}">
                                    <label class="form-check-label small mb-0 ms-1" for="hapus_{{ $index }}">Hapus</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success btn-sm">Simpan Perubahan</button>
                <a href="{{ route('pembudidaya.profil') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>

        </form>
    </div>
</div>
<style>
    /* Kontainer tiap gambar */
    .image-box {
        width: 100px;
        height: 100px;
        margin: auto;
        overflow: hidden;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        position: relative;
    }

    .image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-preview {
        position: absolute;
        top: 0;
        right: 0;
        background-color: #f8d7da;
        border: none;
        color: #721c24;
        font-weight: bold;
        line-height: 1;
        padding: 0.25rem 0.5rem;
        cursor: pointer;
        border-radius: 0 0 0 0.25rem;
    }

    /* Flex container agar gambar baru ke samping */
    #imagePreview {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    /* Gambar lama */
    .old-image-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .old-image-wrapper .form-check {
        margin-top: 0.25rem;
    }

    .old-image-wrapper .form-check-input {
        margin-top: 0 !important;
    }

    .old-image-wrapper .form-check-label {
        margin-left: 0.25rem;
    }
</style>

@endsection
