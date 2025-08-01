<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Komoditas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- AdminLTE & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">

    <!-- Flatpickr & Mapbox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css">

    <style>
        .img-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-right: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .remove-img, .delete-old-image {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-size: 14px;
            line-height: 24px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: background-color 0.2s, transform 0.2s;
        }
        .remove-img:hover, .delete-old-image:hover {
            background: #cc0000;
            transform: scale(1.1);
        }
        input[type="text"].flatpickr-input {
            background-color: #fff !important;
            cursor: text;
        }
        @media (max-width: 576px) {
            .img-preview {
                width: 80px;
                height: 80px;
            }
            .remove-img, .delete-old-image {
                width: 20px;
                height: 20px;
                font-size: 12px;
                line-height: 20px;
            }
        }
        #map {
            width: 100%;
            height: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
        }
        #suggestion-list {
            position: absolute;
            z-index: 1000;
            top: 100%;
            left: 0;
            max-height: 200px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }
        #imagePreview, #existingImagePreview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .location-group {
            margin-bottom: 15px;
        }
        .location-group .form-group {
            margin-bottom: 10px;
        }
        .readonly-input {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        .row-layout {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .row-layout .form-group {
            flex: 1;
            margin-right: 10px;
        }
        .row-layout .form-group:last-child {
            margin-right: 0;
        }
        .img-wrapper {
            position: relative;
            display: inline-block;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('admin.partials.navbar')
    @include('admin.partials.sidebar')

    <div class="content-wrapper">
        <section class="content pt-4">
            <div class="container-fluid">
                <h2 class="mb-4">Edit Komoditas</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.produk.update', $produk->id) }}"
        method="POST" enctype="multipart/form-data" class="mb-5">
    @csrf
    @method('PUT')

    <!-- Hidden container for removed images -->
    <div id="removedImagesContainer" style="display: none;"></div>

    <div class="form-group">
        <label for="pembudidaya_id">Pembudidaya</label>
        <select class="form-control" id="pembudidaya_id" name="pembudidaya_id" required
            oninvalid="this.setCustomValidity('Harap pilih pembudidaya.')" oninput="this.setCustomValidity('')">
            <option value="" disabled {{ old('pembudidaya_id', $produk->pembudidaya_id) ? '' : 'selected' }}>Pilih
                Pembudidaya</option>
            @foreach ($pembudidayas as $pembudidaya)
                <option value="{{ $pembudidaya->id }}"
                    {{ old('pembudidaya_id', $produk->pembudidaya_id) == $pembudidaya->id ? 'selected' : '' }}>
                    {{ $pembudidaya->name }}</option>
            @endforeach
        </select>
        @error('pembudidaya_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Image Upload Section -->
    <div class="mb-3">
        <label class="form-label small">Unggah Gambar</label>
        <input type="file" id="images" name="images[]" class="form-control form-control-sm" multiple
            accept="image/*">
        <div id="imagePreview"></div>
        @error('images')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <!-- Existing Images Section -->
    <div id="existingImagePreview" class="d-flex gap-2 flex-wrap">
        @foreach ($produk->gambar as $gambar)
            <div class="img-wrapper">
                <img src="{{ asset('storage/images/' . $gambar) }}" class="img-preview">
                <button type="button" class="delete-old-image" data-filename="{{ $gambar }}">×</button>
            </div>
        @endforeach
    </div>
    <div id="removedImagesContainer"></div>

    <div class="form-group mt-2">
        <label>Nomor Telepon</label>
        <input type="text" class="form-control" name="phone" value="{{ old('phone', $produk->telepon) }}" required
            oninvalid="this.setCustomValidity('Harap isi nomor telepon.')" oninput="this.setCustomValidity('')">
        @error('phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Location Group -->
    <div class="location-group">
        <div class="row-layout">
            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" class="form-control readonly-input" id="kecamatan" name="kecamatan"
                    value="{{ old('kecamatan', $produk->kecamatan) }}" readonly required
                    oninvalid="this.setCustomValidity('Harap pilih lokasi pada peta.')"
                    oninput="this.setCustomValidity('')">
                @error('kecamatan')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="desa">Desa</label>
                <input type="text" class="form-control readonly-input" id="desa" name="desa"
                    value="{{ old('desa', $produk->desa) }}" readonly required
                    oninvalid="this.setCustomValidity('Harap pilih lokasi pada peta.')"
                    oninput="this.setCustomValidity('')">
                @error('desa')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group mt-2">
            <label for="address">Alamat Lengkap</label>
            <input type="text" class="form-control" id="address" name="address"
                value="{{ old('address', $produk->alamat_lengkap) }}" required
                oninvalid="this.setCustomValidity('Harap isi alamat lengkap.')" oninput="this.setCustomValidity('')">
            <ul id="suggestion-list" class="list-group mt-1"></ul>
            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mt-2">
            <label>Lokasi pada Peta</label>
            <div id="map"></div>
        </div>
    </div>

    <div class="row-layout">
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" id="latitude" name="latitude" class="form-control readonly-input"
                value="{{ old('latitude', $produk->latitude) }}" readonly required
                oninvalid="this.setCustomValidity('Harap pilih lokasi pada peta.')"
                oninput="this.setCustomValidity('')">
            @error('latitude')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" id="longitude" name="longitude" class="form-control readonly-input"
                value="{{ old('longitude', $produk->longitude) }}" readonly required
                oninvalid="this.setCustomValidity('Harap pilih lokasi pada peta.')"
                oninput="this.setCustomValidity('')">
            @error('longitude')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group mt-2">
        <label for="commodity_type">Jenis Komoditas</label>
        <select class="form-control" id="commodity_type" name="commodity_type" required
            oninvalid="this.setCustomValidity('Harap pilih jenis komoditas.')" oninput="this.setCustomValidity('')">
            <option value="" disabled {{ old('commodity_type', $produk->jenis_komoditas) ? '' : 'selected' }}>
                Pilih Jenis Komoditas</option>
            <option value="Rumput Laut"
                {{ old('commodity_type', $produk->jenis_komoditas) == 'Rumput Laut' ? 'selected' : '' }}>Rumput Laut
            </option>
            <option value="Udang" {{ old('commodity_type', $produk->jenis_komoditas) == 'Udang' ? 'selected' : '' }}>
                Udang</option>
            <option value="Ikan Gurame"
                {{ old('commodity_type', $produk->jenis_komoditas) == 'Ikan Gurame' ? 'selected' : '' }}>Ikan Gurame
            </option>
            <option value="Ikan Bandeng"
                {{ old('commodity_type', $produk->jenis_komoditas) == 'Ikan Bandeng' ? 'selected' : '' }}>Ikan Bandeng
            </option>
            <option value="Ikan Lele"
                {{ old('commodity_type', $produk->jenis_komoditas) == 'Ikan Lele' ? 'selected' : '' }}>Ikan Lele
            </option>
            <option value="Ikan Nila"
                {{ old('commodity_type', $produk->jenis_komoditas) == 'Ikan Nila' ? 'selected' : '' }}>Ikan Nila
            </option>
        </select>
        @error('commodity_type')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mt-2">
        <label for="specific_commodity_type">Jenis Spesifik Komoditas</label>
        <input type="text" class="form-control" name="specific_commodity_type"
            value="{{ old('specific_commodity_type', $produk->jenis_spesifik_komoditas) }}">
        @error('specific_commodity_type')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="row-layout">
        <div class="form-group">
            <label for="production_capacity">Kapasitas Produksi per Bulan (kg)</label>
            <input type="number" class="form-control" id="production_capacity" name="production_capacity"
                value="{{ old('production_capacity', $produk->kapasitas_produksi) }}">
            @error('production_capacity')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Masa Produksi Puncak</label>
            <select class="form-control" name="peak_production_period" required
                oninvalid="this.setCustomValidity('Harap pilih masa produksi puncak.')"
                oninput="this.setCustomValidity('')">
                <option value="">-- Pilih Bulan --</option>
                @php
                    $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    $selectedBulan = old('peak_production_period', $produk->masa_produksi_puncak);
                @endphp
                @foreach ($bulan as $b)
                    <option value="{{ $b }}" {{ $selectedBulan == $b ? 'selected' : '' }}>{{ $b }}</option>
                @endforeach
            </select>
            @error('peak_production_period')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="row-layout">
        <div class="form-group">
            <label for="price_range_min">Kisaran Harga Jual (Dari Rp)</label>
            <input type="number" class="form-control" id="price_range_min" name="price_range_min"
                min="0" step="500" required placeholder="1000"
                value="{{ old('price_range_min', $produk->kisaran_harga_min) }}"
                oninvalid="this.setCustomValidity('Harap isi harga minimum.')"
                oninput="this.setCustomValidity('')">
            @error('price_range_min')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="price_range_max">Kisaran Harga Jual (Hingga Rp)</label>
            <input type="number" class="form-control" id="price_range_max" name="price_range_max"
                min="0" step="500" required placeholder="3000"
                value="{{ old('price_range_max', $produk->kisaran_harga_max) }}"
                oninvalid="this.setCustomValidity('Harap isi harga maksimum.')"
                oninput="this.setCustomValidity('')">
            @error('price_range_max')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group mt-2">
        <label for="harvest_prediction">Prediksi Panen</label>
        <input type="text" class="form-control" id="harvest_prediction" name="harvest_prediction"
            value="{{ old('harvest_prediction', $produk->prediksi_panen) }}" placeholder="Contoh: 21 April 2025"
            autocomplete="off">
        @error('harvest_prediction')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mt-2">
        <label for="details">Detail Komoditas</label>
        <textarea class="form-control" id="details" name="details" rows="4">{{ old('details', $produk->detail) }}</textarea>
        @error('details')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save"></i> Simpan</button>
    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i>
        Kembali</a>
    </form>
    </div>
    </section>
    </div>

    <footer class="main-footer text-sm text-center">
        <strong>&copy; {{ date('Y') }} Admin Panel.</strong> All rights reserved.
    </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Flatpickr
            flatpickr("#harvest_prediction", {
                dateFormat: "d F Y",
                locale: "id",
                allowInput: true
            });

            // Initialize Mapbox
            mapboxgl.accessToken =
                'pk.eyJ1Ijoia2lraWtzMjMiLCJhIjoiY205dDZiZDgyMDgzdzJtcTk1bW81ZG4wOCJ9.2KzfsbK1tXHs7vuAkwMsKQ';
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [{{ old('longitude', $produk->longitude) ?: 108.3247 }},
                    {{ old('latitude', $produk->latitude) ?: -6.3265 }}
                ],
                zoom: 14,
                maxBounds: [
                    [107.98, -6.60],
                    [108.50, -6.00]
                ]
            });

            map.addControl(new mapboxgl.NavigationControl());

            let marker;
            map.on('load', () => {
                // Initial marker at existing product location or default
                marker = new mapboxgl.Marker({
                        draggable: true,
                        color: '#FF0000'
                    })
                    .setLngLat([{{ old('longitude', $produk->longitude) ?: 108.3247 }},
                        {{ old('latitude', $produk->latitude) ?: -6.3265 }}
                    ])
                    .addTo(map);

                const inputAlamat = document.getElementById('address');
                const inputLat = document.getElementById('latitude');
                const inputLng = document.getElementById('longitude');
                const inputKecamatan = document.getElementById('kecamatan');
                const inputDesa = document.getElementById('desa');

                // Function to set user location
                function setUserLocation(position) {
                    const lngLat = [position.coords.longitude, position.coords.latitude];
                    if (isWithinBounds(lngLat)) {
                        map.flyTo({
                            center: lngLat,
                            zoom: 14
                        });
                        placeMarker(lngLat[0], lngLat[1]);
                        updateInputs([lngLat[1], lngLat[0]]);
                        reverseGeocodeAndUpdate([lngLat[1], lngLat[0]]);
                    } else {
                        alert('Lokasi Anda di luar wilayah Indramayu. Menggunakan lokasi default.');
                        const defaultLngLat = [108.3247, -6.3265];
                        map.flyTo({
                            center: defaultLngLat,
                            zoom: 12
                        });
                        placeMarker(defaultLngLat[0], defaultLngLat[1]);
                        updateInputs([defaultLngLat[1], defaultLngLat[0]]);
                        reverseGeocodeAndUpdate([defaultLngLat[1], defaultLngLat[0]]);
                    }
                }

                // Handle geolocation errors
                function handleLocationError(error) {
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            alert('Izin geolokasi ditolak oleh pengguna. Menggunakan lokasi default.');
                            break;
                        case error.POSITION_UNAVAILABLE:
                            alert('Informasi lokasi tidak tersedia. Menggunakan lokasi default.');
                            break;
                        case error.TIMEOUT:
                            alert(
                                'Waktu habis saat mencoba mendapatkan lokasi. Menggunakan lokasi default.');
                            break;
                        default:
                            alert('Terjadi error tidak dikenal. Menggunakan lokasi default.');
                            break;
                    }
                    const defaultLngLat = [108.3247, -6.3265];
                    map.flyTo({
                        center: defaultLngLat,
                        zoom: 12
                    });
                    placeMarker(defaultLngLat[0], defaultLngLat[1]);
                    updateInputs([defaultLngLat[1], defaultLngLat[0]]);
                    reverseGeocodeAndUpdate([defaultLngLat[1], defaultLngLat[0]]);
                }

                // Get user location on load
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(setUserLocation, handleLocationError, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    });
                } else {
                    alert('Geolokasi tidak didukung oleh browser ini. Menggunakan lokasi default.');
                    const defaultLngLat = [108.3247, -6.3265];
                    map.flyTo({
                        center: defaultLngLat,
                        zoom: 12
                    });
                    placeMarker(defaultLngLat[0], defaultLngLat[1]);
                    updateInputs([defaultLngLat[1], defaultLngLat[0]]);
                    reverseGeocodeAndUpdate([defaultLngLat[1], defaultLngLat[0]]);
                }

                // Click event to place marker
                map.on('click', (e) => {
                    const lng = e.lngLat.lng;
                    const lat = e.lngLat.lat;
                    if (isWithinBounds([lng, lat])) {
                        placeMarker(lng, lat);
                        updateInputs([lat, lng]);
                        reverseGeocodeAndUpdate([lat, lng]);
                    } else {
                        alert('Lokasi di luar wilayah Indramayu. Menggunakan lokasi default.');
                        const defaultLngLat = [108.3247, -6.3265];
                        map.flyTo({
                            center: defaultLngLat,
                            zoom: 12
                        });
                        placeMarker(defaultLngLat[0], defaultLngLat[1]);
                        updateInputs([defaultLngLat[1], defaultLngLat[0]]);
                        reverseGeocodeAndUpdate([defaultLngLat[1], defaultLngLat[0]]);
                    }
                });

                // Place marker function
                function placeMarker(lng, lat) {
                    if (marker) marker.remove();
                    marker = new mapboxgl.Marker({
                            draggable: true,
                            color: '#FF0000'
                        })
                        .setLngLat([lng, lat])
                        .addTo(map);
                    marker.on('dragend', () => {
                        const lngLat = marker.getLngLat();
                        if (isWithinBounds([lngLat.lng, lngLat.lat])) {
                            map.flyTo({
                                center: [lngLat.lng, lngLat.lat],
                                zoom: 14
                            });
                            updateInputs([lngLat.lat, lngLat.lng]);
                            reverseGeocodeAndUpdate([lngLat.lat, lngLat.lng]);
                        } else {
                            alert(
                                'Marker di luar wilayah Indramayu. Mengembalikan ke posisi default.');
                            const defaultLngLat = [108.3247, -6.3265];
                            map.flyTo({
                                center: defaultLngLat,
                                zoom: 12
                            });
                            placeMarker(defaultLngLat[0], defaultLngLat[1]);
                            updateInputs([defaultLngLat[1], defaultLngLat[0]]);
                            reverseGeocodeAndUpdate([defaultLngLat[1], defaultLngLat[0]]);
                        }
                    });
                }

                // Geocode function
                async function geocode(query) {
                    const url =
                        `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&addressdetails=1&countrycodes=ID&limit=5&viewbox=107.98,-6.00,108.50,-6.60&bounded=1`;
                    try {
                        const response = await fetch(url);
                        const data = await response.json();
                        return data.filter(item =>
                            item.address && (
                                item.address.county?.toLowerCase().includes('indramayu') ||
                                item.address.city?.toLowerCase().includes('indramayu') ||
                                item.display_name.toLowerCase().includes('indramayu')
                            )
                        );
                    } catch (error) {
                        console.error('Geocode error:', error);
                        return [];
                    }
                }

                // Reverse geocode with Nominatim
                async function reverseGeocodeWithNominatim(lat, lon) {
                    const url =
                        `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json&addressdetails=1`;
                    try {
                        const response = await fetch(url, {
                            headers: {
                                'Accept-Language': 'id'
                            }
                        });
                        return await response.json();
                    } catch (error) {
                        console.error('Reverse geocode error:', error);
                        return {};
                    }
                }

                // Normalize input
                function normalizeInput(query) {
                    let q = query.toLowerCase().trim();
                    q = q.replace(/^jl\.?\s+/g, 'jalan ');
                    q = q.replace(/^jln\.?\s+/g, 'jalan ');
                    q = q.replace(/\s+/g, ' ');
                    return q;
                }

                // Address input suggestion
                let typingTimer;
                inputAlamat.addEventListener('input', () => {
                    clearTimeout(typingTimer);
                    const raw = inputAlamat.value;
                    if (raw.length > 1) {
                        typingTimer = setTimeout(async () => {
                            const query = normalizeInput(raw);
                            const data = await geocode(query);
                            const suggestionList = document.getElementById(
                                'suggestion-list');
                            suggestionList.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const li = document.createElement('li');
                                    li.className =
                                        'list-group-item list-group-item-action';
                                    li.textContent = item.display_name;
                                    li.addEventListener('click', async () => {
                                        const lat = parseFloat(item
                                            .lat);
                                        const lon = parseFloat(item
                                            .lon);
                                        if (isWithinBounds([lon,
                                                lat])) {
                                            map.flyTo({
                                                center: [
                                                    lon,
                                                    lat
                                                ],
                                                zoom: 14
                                            });
                                            placeMarker(lon, lat);
                                            updateInputs([lat,
                                            lon]);
                                            reverseGeocodeAndUpdate(
                                                [lat, lon]);
                                            inputAlamat.value = item
                                                .display_name;
                                            suggestionList
                                                .innerHTML = '';
                                        } else {
                                            alert(
                                                'Lokasi di luar wilayah Indramayu. Menggunakan lokasi default.');
                                            const defaultLngLat = [
                                                108.3247, -
                                                6.3265
                                            ];
                                            map.flyTo({
                                                center: defaultLngLat,
                                                zoom: 12
                                            });
                                            placeMarker(
                                                defaultLngLat[
                                                0],
                                                defaultLngLat[1]
                                                );
                                            updateInputs([
                                                defaultLngLat[
                                                    1],
                                                defaultLngLat[
                                                    0]
                                            ]);
                                            reverseGeocodeAndUpdate(
                                                [defaultLngLat[
                                                        1],
                                                    defaultLngLat[
                                                        0]
                                                ]);
                                            inputAlamat.value = '';
                                            suggestionList
                                                .innerHTML = '';
                                        }
                                    });
                                    suggestionList.appendChild(li);
                                });
                            }
                        }, 400);
                    } else {
                        document.getElementById('suggestion-list').innerHTML = '';
                    }
                });

                // Check if coordinates are within bounds
                function isWithinBounds(lngLat) {
                    const [lng, lat] = lngLat;
                    return lng >= 107.98 && lng <= 108.50 && lat >= -6.60 && lat <= -6.00;
                }

                // Update input fields
                function updateInputs(lngLat) {
                    const [lat, lng] = lngLat;
                    inputLat.value = lat.toFixed(6);
                    inputLng.value = lng.toFixed(6);
                    inputDesa.value = ''; // Clear desa before updating
                    inputKecamatan.value = ''; // Clear kecamatan before updating
                }

                // Reverse geocode and update address
                async function reverseGeocodeAndUpdate(lngLat) {
                    const [lat, lng] = lngLat;
                    const data = await reverseGeocodeWithNominatim(lat, lng);
                    if (data && data.address) {
                        inputAlamat.value = data.display_name || '-';
                        inputKecamatan.value = data.address.county || data.address.city || '-';
                        inputDesa.value = data.address.village || data.address?.hamlet || data.address
                            ?.suburb || data.address?.neighbourhood || data.address?.locality || '-';
                    } else {
                        inputAlamat.value = '-';
                        inputKecamatan.value = '-';
                        inputDesa.value = '-';
                    }
                }
            });

            map.on('error', (e) => {
                console.error('Error loading map:', e.error);
                alert('Terjadi error saat memuat peta. Silakan coba lagi.');
            });

            // Image handling
            let selectedFiles = [];
            const imageInput = document.getElementById('images');
            const previewContainer = document.getElementById('imagePreview');
            const removedImagesContainer = document.getElementById('removedImagesContainer');
            const existingImages = Array.from(document.querySelectorAll('.delete-old-image')).map(btn => btn
                .getAttribute('data-filename'));

            function updateFileInput() {
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                imageInput.files = dataTransfer.files;
                console.log('Updated file input:', imageInput.files);
            }

            function renderPreview() {
                previewContainer.innerHTML = '';
                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'img-wrapper';
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-preview');
                        const btn = document.createElement('button');
                        btn.innerHTML = '×';
                        btn.className = 'remove-img';
                        btn.type = 'button';
                        btn.onclick = () => {
                            selectedFiles.splice(index, 1);
                            updateFileInput();
                            renderPreview();
                        };
                        wrapper.appendChild(img);
                        wrapper.appendChild(btn);
                        previewContainer.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });
            }

            function previewImages(event) {
                console.log('Files selected:', event.target.files);
                const newFiles = Array.from(event.target.files);
                if (newFiles.length > 0) {
                    newFiles.forEach(newFile => {
                        if (newFile.type.startsWith('image/') && ['image/jpeg', 'image/png', 'image/jpg']
                            .includes(newFile.type)) {
                            const exists = selectedFiles.some(file => file.name === newFile.name && file
                                .size === newFile.size);
                            if (!exists) {
                                selectedFiles.push(newFile);
                            }
                        } else {
                            alert(
                                `File ${newFile.name} bukan gambar yang valid (hanya JPEG, PNG, atau JPG yang diperbolehkan).`);
                        }
                    });
                    updateFileInput();
                    renderPreview();
                }
            }

            if (imageInput) {
                imageInput.addEventListener('change', previewImages);
            }

            // Handle existing image removal
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('delete-old-image')) {
                    const filename = e.target.getAttribute('data-filename');
                    const wrapper = e.target.parentElement;
                    wrapper.remove();
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'images_remove[]';
                    hiddenInput.value = filename;
                    removedImagesContainer.appendChild(hiddenInput);
                    console.log('Removed image:', filename);
                }
            });

            // Ensure at least one image remains before submission
            document.querySelector('form').addEventListener('submit', (e) => {
                const currentExistingImages = Array.from(document.querySelectorAll('.delete-old-image'))
                    .map(btn => btn.getAttribute('data-filename'));
                console.log('Selected files:', selectedFiles);
                console.log('Current existing images:', currentExistingImages);
                if (selectedFiles.length === 0 && currentExistingImages.length === 0) {
                    e.preventDefault();
                    alert('Harap unggah setidaknya satu gambar atau pertahankan gambar yang ada.');
                }
            });
        });
    </script>
    </body>

</html>
