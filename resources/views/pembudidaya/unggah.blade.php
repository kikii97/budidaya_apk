{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Komoditas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


    <style>
        /* Memastikan gambar preview tidak terlalu besar */
        .img-thumbnail {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        /*Custom CSS untuk memastikan input tidak terlihat abu-abu */
        input[type="text"].flatpickr-input {
        background-color: #fff !important;
        cursor: text;
        }

        /* Tampilan gambar dengan margin di mobile */
        @media (max-width: 576px) {
            .img-thumbnail {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Unggah Komoditas</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
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
                                'The phone field must not be greater than 20 characters.'
                            ],
                            [
                                'Kolom nomor telepon harus terdiri dari 10 hingga 15 digit.',
                                'Kolom alamat wajib diisi.',
                                'Kolom jenis Komoditas wajib diisi.',
                                'Kolom kisaran harga jual wajib diisi.',
                                'Kolom foto Komoditas wajib diunggah.',
                                'Kolom nomor telepon harus tidak lebih dari 20 angka.'
                            ],
                            $error
                        ) }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('pembudidaya.unggah.simpan') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="pembudidaya_id" value="{{ session('pembudidaya_id') }}">

            <!-- Unggah Foto Komoditas (Multiple Images) -->
            <div class="mb-3">
                <label class="form-label">Unggah Gambar</label>
                <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*" onchange="previewImages(event)">
                <div id="imagePreview" class="mt-3 d-flex flex-wrap"></div>
            </div>
                    
            <!-- Nomor Telepon -->
            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" required
                oninvalid="this.setCustomValidity('Harap isi nomor telepon yang valid.')" 
                oninput="this.setCustomValidity('')">
            </div>

            <!-- Kecamatan -->
            <div class="mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <select class="form-select" id="kecamatan" name="kecamatan" required
                    oninvalid="this.setCustomValidity('Harap pilih kecamatan.')" 
                    oninput="this.setCustomValidity('')">
                    <option value="" disabled selected>Pilih Kecamatan</option>
                    @foreach ($kecamatanList as $kecamatan)
                        <option value="{{ $kecamatan }}" {{ old('kecamatan') == $kecamatan ? 'selected' : '' }}>
                            {{ $kecamatan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Alamat Lengkap -->
            <div class="mb-3">
                <label for="address" class="form-label">Alamat Lengkap</label>
                <textarea class="form-control" id="address" name="address" rows="3" required
                placeholder="Tuliskan alamat lengkap tanpa kecamatan"
                oninvalid="this.setCustomValidity('Harap isi alamat lengkap.')" 
                oninput="this.setCustomValidity('')"></textarea>
            </div>

            <!-- Jenis Komoditas (Dropdown) -->
            <div class="mb-3">
                <label for="commodity_type" class="form-label">Jenis Komoditas</label>
                <select class="form-select" id="commodity_type" name="commodity_type" required
                oninvalid="this.setCustomValidity('Harap pilih jenis komoditas.')" 
                oninput="this.setCustomValidity('')">
                    <option value="" disabled selected>Pilih Jenis Komoditas</option>
                    <option value="Rumput Laut">Rumput Laut</option>
                    <option value="Udang">Udang</option>
                    <option value="Ikan Gurame">Ikan Gurame</option>
                    <option value="Ikan Bandeng">Ikan Bandeng</option>
                    <option value="Ikan Lele">Ikan Lele</option>
                    <option value="Ikan Nila">Ikan Nila</option>
                </select>
            </div>

            <!-- Jenis Spesifik Komoditas -->
            <div class="mb-3">
                <label for="specific_commodity_type" class="form-label">Jenis Spesifik Komoditas</label>
                <input type="text" class="form-control" id="specific_commodity_type" name="specific_commodity_type"
                oninvalid="this.setCustomValidity('Harap isi jenis spesifik Komoditas.')" 
                oninput="this.setCustomValidity('')">
            </div>

            <!-- Kapasitas Produksi per Bulan -->
            <div class="mb-3">
                <label for="production_capacity" class="form-label">Kapasitas Produksi per Bulan (kg)</label>
                <input type="number" class="form-control" id="production_capacity" name="production_capacity"
                oninvalid="this.setCustomValidity('Harap isi kapasitas produksi per bulan dengan angka yang benar.')" 
                oninput="this.setCustomValidity('')">
            </div>

            <!-- Masa Produksi Puncak -->
            <div class="mb-3">
                <label for="peak_production_period" class="form-label">Masa Produksi Puncak</label>
                <input type="text" class="form-control" id="peak_production_period" name="peak_production_period"
                oninvalid="this.setCustomValidity('Harap isi masa produksi puncak Komoditas.')" 
                oninput="this.setCustomValidity('')">
            </div>

            <!-- Kisaran Harga Jual -->
            <div class="mb-3 d-flex">
                <div class="flex-grow-1">
                    <label for="price_range_min" class="form-label">Kisaran Harga Jual (Dari Rp)</label>
                    <input type="number" class="form-control" id="price_range_min" name="price_range_min" min="0" step="1" required
                    placeholder="1000"
                    oninvalid="this.setCustomValidity('Harap isi harga jual minimum.')"
                    oninput="this.setCustomValidity('')">
                </div>
                <div class="ms-2 flex-grow-1">
                    <label for="price_range_max" class="form-label">Kisaran Harga Jual (Hingga Rp)</label>
                    <input type="number" class="form-control" id="price_range_max" name="price_range_max" min="0" step="1" required
                    placeholder="3000"
                    oninvalid="this.setCustomValidity('Harap isi harga jual maksimum.')"
                    oninput="this.setCustomValidity('')">
                </div>
            </div>

            <!-- Prediksi Panen -->
            <div class="mb-3">
                <label for="harvest_prediction" class="form-label">Prediksi Panen</label>
                <input type="text" 
                       class="form-control" 
                       id="harvest_prediction" 
                       name="harvest_prediction" 
                       placeholder="Contoh: 21 April 2025"
                       autocomplete="off">
            </div>

            <!-- Detail Komoditas -->
            <div class="mb-3">
                <label for="details" class="form-label">Detail Komoditas</label>
                <textarea class="form-control" id="details" name="details" rows="4"
                oninvalid="this.setCustomValidity('Harap isi detail Komoditas dengan informasi yang lengkap.')" 
                oninput="this.setCustomValidity('')"></textarea>
            </div>

            <!-- Tombol Submit -->
            <div class="mb-3 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Unggah Komoditas</button>
                <a href="{{ route('pembudidaya.profil') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tambahkan JavaScript Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Tambahkan Bahasa Indonesia -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>


    <script>
        flatpickr("#harvest_prediction", {
            dateFormat: "d-m-Y",
            locale: "id",
            allowInput: true // supaya bisa ketik manual
        });
    </script>
    <script>
        let selectedFiles = [];
    
        function previewImages(event) {
            let preview = document.getElementById('imagePreview');
            let files = event.target.files;
    
            for (let file of files) {
                // Cek apakah file sudah ada di daftar
                if (!selectedFiles.some(f => f.name === file.name)) {
                    selectedFiles.push(file);
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let div = document.createElement('div');
                        div.classList.add('image-container', 'position-relative', 'm-2');
                        div.innerHTML = `
                            <img src="${e.target.result}" width="100" height="100" class="border rounded">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" onclick="removeImage('${file.name}', this)">X</button>
                        `;
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            }
    
            updateFileInput();
        }
    
        function removeImage(fileName, button) {
            // Hapus file dari daftar
            selectedFiles = selectedFiles.filter(file => file.name !== fileName);
            button.parentElement.remove();
            updateFileInput();
        }
    
        function updateFileInput() {
            let input = document.getElementById('images');
            let dataTransfer = new DataTransfer();
    
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
    
            input.files = dataTransfer.files;
        }
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("uploadForm"); // Pastikan ID form benar
        const minPrice = document.getElementById("price_range_min");
        const maxPrice = document.getElementById("price_range_max");
    
        form.addEventListener("submit", function(event) {
            let errorMessage = "";
    
            // Cek apakah input kosong
            if (!minPrice.value.trim()) {
                errorMessage = "Harap isi harga jual minimum.";
            } else if (!maxPrice.value.trim()) {
                errorMessage = "Harap isi harga jual maksimum.";
            }
            if (errorMessage) {
                event.preventDefault(); // Batalkan submit
                alert(errorMessage); // Tampilkan pesan error
            }
        });
    });
    </script>
    

    </body>
</html> --}}

@extends('layouts.app')

@section('title', 'Unggah Komoditas')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="container py-4" style="padding-top: 1rem !important;">
        <a href="{{ url('/detail_usaha/' . session('pembudidaya_id')) }}" class="text-muted small">
            <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>

        <div class="card p-3 mt-3" style="font-size: 0.85rem;"> <!-- font size kecil -->

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
                                    $error,
                                ) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pembudidaya.unggah.simpan') }}" method="POST" enctype="multipart/form-data"
                style="font-size: 0.9rem;">
                @csrf
                <input type="hidden" name="pembudidaya_id" value="{{ session('pembudidaya_id') }}">

                <div class="mb-3">
                    <label class="form-label small">Unggah Gambar</label>
                    <input type="file" id="images" name="images[]" class="form-control form-control-sm" multiple
                        accept="image/*" onchange="previewImages(event)">
                    <div id="imagePreview" class="mt-2 d-flex flex-wrap"></div>
                </div>

                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label class="form-label small">Nomor Telepon</label>
                        <input type="text" class="form-control form-control-sm" name="phone" required
                            oninvalid="this.setCustomValidity('Harap isi nomor telepon yang valid.')"
                            oninput="this.setCustomValidity('')">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="kecamatan" class="form-label small">Kecamatan</label>
                        <select class="form-select form-select-sm" id="kecamatan" name="kecamatan" required
                            oninvalid="this.setCustomValidity('Harap pilih kecamatan.')"
                            oninput="this.setCustomValidity('')">
                            <option value="" disabled selected>Pilih Kecamatan</option>
                            @foreach ($kecamatanList as $kecamatan)
                                <option value="{{ $kecamatan }}" {{ old('kecamatan') == $kecamatan ? 'selected' : '' }}>
                                    {{ $kecamatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label small">Alamat Lengkap</label>
                    <textarea class="form-control form-control-sm" id="address" name="address" rows="3" required
                        placeholder="Tuliskan alamat lengkap tanpa kecamatan"
                        oninvalid="this.setCustomValidity('Harap isi alamat lengkap.')" oninput="this.setCustomValidity('')"></textarea>
                </div>

                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label for="commodity_type" class="form-label small">Jenis Komoditas</label>
                        <select class="form-select form-select-sm" id="commodity_type" name="commodity_type" required
                            oninvalid="this.setCustomValidity('Harap pilih jenis komoditas.')"
                            oninput="this.setCustomValidity('')">
                            <option value="" disabled selected>Pilih Jenis Komoditas</option>
                            <option value="Rumput Laut">Rumput Laut</option>
                            <option value="Udang">Udang</option>
                            <option value="Ikan Gurame">Ikan Gurame</option>
                            <option value="Ikan Bandeng">Ikan Bandeng</option>
                            <option value="Ikan Lele">Ikan Lele</option>
                            <option value="Ikan Nila">Ikan Nila</option>
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="specific_commodity_type" class="form-label small">Jenis Spesifik Komoditas</label>
                        <input type="text" class="form-control form-control-sm" name="specific_commodity_type"
                            oninvalid="this.setCustomValidity('Harap isi jenis spesifik Komoditas.')"
                            oninput="this.setCustomValidity('')">
                    </div>
                </div>

                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label for="production_capacity" class="form-label small">Kapasitas Produksi per Bulan (kg)</label>
                        <input type="number" class="form-control form-control-sm" id="production_capacity"
                            name="production_capacity"
                            oninvalid="this.setCustomValidity('Harap isi kapasitas produksi per bulan dengan angka yang benar.')"
                            oninput="this.setCustomValidity('')">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label small">Masa Produksi Puncak</label>
                        <input type="text" class="form-control form-control-sm" name="peak_production_period"
                            oninvalid="this.setCustomValidity('Harap isi masa produksi puncak Komoditas.')"
                            oninput="this.setCustomValidity('')">
                    </div>
                </div>

                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label for="price_range_min" class="form-label small">Kisaran Harga Jual (Dari Rp)</label>
                        <input type="number" class="form-control form-control-sm" id="price_range_min"
                            name="price_range_min" min="0" step="1" required placeholder="1000"
                            oninvalid="this.setCustomValidity('Harap isi harga jual minimum.')"
                            oninput="this.setCustomValidity('')">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="price_range_max" class="form-label small">Kisaran Harga Jual (Hingga Rp)</label>
                        <input type="number" class="form-control form-control-sm" id="price_range_max"
                            name="price_range_max" min="0" step="1" required placeholder="3000"
                            oninvalid="this.setCustomValidity('Harap isi harga jual maksimum.')"
                            oninput="this.setCustomValidity('')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="harvest_prediction" class="form-label small">Prediksi Panen</label>
                    <input type="text" class="form-control form-control-sm" id="harvest_prediction" name="harvest_prediction"
                        placeholder="Contoh: 21 April 2025" autocomplete="off">
                </div>

                <div class="mb-3">
                    <label for="details" class="form-label small">Detail Komoditas</label>
                    <textarea class="form-control form-control-sm" id="details" name="details" rows="4" oninvalid="this.setCustomValidity('Harap isi detail Komoditas dengan informasi yang lengkap.')" 
                oninput="this.setCustomValidity('')"></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-sm">Unggah</button>
                </div>
            </form>
        </div>
    </div>
@endsection
