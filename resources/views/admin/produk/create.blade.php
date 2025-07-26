<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unggah Komoditas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- AdminLTE & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">

    <!-- Flatpickr & Mapbox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css">

    <style>
        .img-preview { width: 100px; height: 100px; object-fit: cover; margin-right: 5px; position: relative; }
        .remove-img { position: absolute; top: -5px; right: -5px; background: #ff4444; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 20px; text-align: center; }
        input[type="text"].flatpickr-input { background-color: #fff !important; cursor: text; }
        @media (max-width: 576px) { .img-preview { width: 80px; height: 80px; } }
        #map { position: relative; width: 100%; height: 258px; margin-top: 0rem; border: 1px solid #ccc; z-index: 1; overflow: hidden; }
        #map-container { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; }
        #suggestion-list { position: absolute; z-index: 999; top: 100%; left: 0; max-height: 200px; overflow-y: auto; background: #fff; border: 1px solid #ddd; border-radius: 4px; width: 100%; }

        /* Adjusted layout styling */
        .location-group { margin-bottom: 15px; }
        .location-group .form-group { margin-bottom: 10px; }
        .readonly-input { background-color: #f8f9fa; cursor: not-allowed; }
        .row-layout { display: flex; justify-content: space-between; margin-bottom: 15px; }
        .row-layout .form-group { flex: 1; margin-right: 10px; }
        .row-layout .form-group:last-child { margin-right: 0; }
    </style>
    <style>
        .img-wrapper {
            position: relative;
            margin: 5px;
        }

        .img-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .remove-btn {
            position: absolute;
            top: 2px;
            right: 2px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 14px;
            cursor: pointer;
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
                <h2 class="mb-4">Unggah Komoditas</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="mb-5">
                    @csrf

                    <div class="form-group">
                        <label for="pembudidaya_id">Pembudidaya</label>
                        <select class="form-control" id="pembudidaya_id" name="pembudidaya_id" required
                                oninvalid="this.setCustomValidity('Harap pilih pembudidaya.')"
                                oninput="this.setCustomValidity('')">
                            <option value="" disabled {{ old('pembudidaya_id') ? '' : 'selected' }}>Pilih Pembudidaya</option>
                            @foreach ($pembudidayas as $pembudidaya)
                                <option value="{{ $pembudidaya->id }}" {{ old('pembudidaya_id') == $pembudidaya->id ? 'selected' : '' }}>{{ $pembudidaya->name }}</option>
                            @endforeach
                        </select>
                        @error('pembudidaya_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Unggah Gambar</label>
                        <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">
                        <div id="imagePreview" class="mt-2 d-flex flex-wrap gap-2"></div>
                        @error('images')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-2">
                        <label>Nomor Telepon</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required
                               oninvalid="this.setCustomValidity('Harap isi nomor telepon.')"
                               oninput="this.setCustomValidity('')">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Location Group -->
                    <div class="location-group">
                        <div class="row-layout">
                            <div class="form-group">
                                <label for="kecamatan">Kecamatan</label>
                                <input type="text" class="form-control readonly-input" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" readonly required
                                       oninvalid="this.setCustomValidity('Harap pilih lokasi pada peta.')"
                                       oninput="this.setCustomValidity('')">
                                @error('kecamatan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="desa">Desa</label>
                                <input type="text" class="form-control readonly-input" id="desa" name="desa" value="{{ old('desa') }}" readonly required
                                       oninvalid="this.setCustomValidity('Harap pilih lokasi pada peta.')"
                                       oninput="this.setCustomValidity('')">
                                @error('desa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label for="address">Alamat Lengkap</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required
                                   oninvalid="this.setCustomValidity('Harap isi alamat lengkap.')"
                                   oninput="this.setCustomValidity('')">
                            <ul id="suggestion-list" class="list-group mt-1"></ul>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label>Lokasi pada Peta</label>
                            <div id="map" class="mb-3">
                                <div id="map-container"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row-layout">
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" id="latitude" name="latitude" class="form-control readonly-input" value="{{ old('latitude') }}" readonly required
                                   oninvalid="this.setCustomValidity('Harap pilih lokasi pada peta.')"
                                   oninput="this.setCustomValidity('')">
                            @error('latitude')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" id="longitude" name="longitude" class="form-control readonly-input" value="{{ old('longitude') }}" readonly required
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
                                oninvalid="this.setCustomValidity('Harap pilih jenis komoditas.')"
                                oninput="this.setCustomValidity('')">
                            <option value="" disabled {{ old('commodity_type') ? '' : 'selected' }}>Pilih Jenis Komoditas</option>
                            <option value="Rumput Laut" {{ old('commodity_type') == 'Rumput Laut' ? 'selected' : '' }}>Rumput Laut</option>
                            <option value="Udang" {{ old('commodity_type') == 'Udang' ? 'selected' : '' }}>Udang</option>
                            <option value="Ikan Gurame" {{ old('commodity_type') == 'Ikan Gurame' ? 'selected' : '' }}>Ikan Gurame</option>
                            <option value="Ikan Bandeng" {{ old('commodity_type') == 'Ikan Bandeng' ? 'selected' : '' }}>Ikan Bandeng</option>
                            <option value="Ikan Lele" {{ old('commodity_type') == 'Ikan Lele' ? 'selected' : '' }}>Ikan Lele</option>
                            <option value="Ikan Nila" {{ old('commodity_type') == 'Ikan Nila' ? 'selected' : '' }}>Ikan Nila</option>
                        </select>
                        @error('commodity_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-2">
                        <label for="specific_commodity_type">Jenis Spesifik Komoditas</label>
                        <input type="text" class="form-control" name="specific_commodity_type" value="{{ old('specific_commodity_type') }}">
                        @error('specific_commodity_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row-layout">
                        <div class="form-group">
                            <label for="production_capacity">Kapasitas Produksi per Bulan (kg)</label>
                            <input type="number" class="form-control" id="production_capacity" name="production_capacity" value="{{ old('production_capacity') }}">
                            @error('production_capacity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Masa Produksi Puncak</label>
                            <input type="text" class="form-control" name="peak_production_period" value="{{ old('peak_production_period') }}">
                            @error('peak_production_period')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row-layout">
                        <div class="form-group">
                            <label for="price_range_min">Kisaran Harga Jual (Dari Rp)</label>
                            <input type="number" class="form-control" id="price_range_min" name="price_range_min" min="0" step="1" required placeholder="1000" value="{{ old('price_range_min', ) }}" required
                                   oninvalid="this.setCustomValidity('Harap isi harga minimum.')"
                                   oninput="this.setCustomValidity('')">
                            @error('price_range_min')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price_range_max">Kisaran Harga Jual (Hingga Rp)</label>
                            <input type="number" class="form-control" id="price_range_max" name="price_range_max" min="0" step="1" required placeholder="3000" value="{{ old('price_range_max', ) }}" required
                                   oninvalid="this.setCustomValidity('Harap isi harga maksimum.')"
                                   oninput="this.setCustomValidity('')">
                            @error('price_range_max')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label for="harvest_prediction">Prediksi Panen</label>
                        <input type="text" class="form-control" id="harvest_prediction" name="harvest_prediction" value="{{ old('harvest_prediction') }}" placeholder="Contoh: 21 April 2025" autocomplete="off">
                        @error('harvest_prediction')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-2">
                        <label for="details">Detail Komoditas</label>
                        <textarea class="form-control" id="details" name="details" rows="4">{{ old('details') }}</textarea>
                        @error('details')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        flatpickr("#harvest_prediction", {
            dateFormat: "d F Y",
            locale: "id",
            allowInput: true
        });

        // Initialize Mapbox
        mapboxgl.accessToken = 'pk.eyJ1Ijoia2lraWtzMjMiLCJhIjoiY205dDZiZDgyMDgzdzJtcTk1bW81ZG4wOCJ9.2KzfsbK1tXHs7vuAkwMsKQ';
        const map = new mapboxgl.Map({
            container: 'map-container',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [108.3247, -6.3265], // Default center
            zoom: 12,
            maxBounds: [[107.98, -6.60], [108.50, -6.00]]
        });

        map.addControl(new mapboxgl.NavigationControl());

        let marker;
        map.on('load', () => {
            // Initial marker at default location
            marker = new mapboxgl.Marker({ draggable: true, color: '#FF0000' })
                .setLngLat([108.3247, -6.3265])
                .addTo(map);

            const inputAlamat = document.getElementById('address');
            const inputLat = document.getElementById('latitude');
            const inputLng = document.getElementById('longitude');
            const inputKecamatan = document.getElementById('kecamatan');
            const inputDesa = document.getElementById('desa');

            // Function to set user location
            function setUserLocation(position) {
                const lngLat = [position.coords.longitude, position.coords.latitude];
                console.log('User location:', lngLat); // Debug log
                if (isWithinBounds(lngLat)) {
                    map.flyTo({ center: lngLat, zoom: 14 });
                    placeMarker(lngLat[0], lngLat[1]);
                    updateInputs([lngLat[1], lngLat[0]]);
                    reverseGeocodeAndUpdate([lngLat[1], lngLat[0]]);
                } else {
                    alert('Lokasi Anda di luar wilayah Indramayu. Menggunakan lokasi default.');
                    const defaultLngLat = [108.3247, -6.3265];
                    map.flyTo({ center: defaultLngLat, zoom: 12 });
                    placeMarker(defaultLngLat[0], defaultLngLat[1]);
                    updateInputs([defaultLngLat[1], defaultLngLat[0]]);
                    reverseGeocodeAndUpdate([defaultLngLat[1], defaultLngLat[0]]);
                }
            }

            // Handle geolocation errors
            function handleLocationError(error) {
                console.error('Geolocation error:', error); // Debug log
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        alert('Izin geolokasi ditolak oleh pengguna. Menggunakan lokasi default.');
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert('Informasi lokasi tidak tersedia. Menggunakan lokasi default.');
                        break;
                    case error.TIMEOUT:
                        alert('Waktu habis saat mencoba mendapatkan lokasi. Menggunakan lokasi default.');
                        break;
                    default:
                        alert('Terjadi error tidak dikenal. Menggunakan lokasi default.');
                        break;
                }
                const defaultLngLat = [108.3247, -6.3265];
                map.flyTo({ center: defaultLngLat, zoom: 12 });
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
                map.flyTo({ center: defaultLngLat, zoom: 12 });
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
                    map.flyTo({ center: defaultLngLat, zoom: 12 });
                    placeMarker(defaultLngLat[0], defaultLngLat[1]);
                    updateInputs([defaultLngLat[1], defaultLngLat[0]]);
                    reverseGeocodeAndUpdate([defaultLngLat[1], defaultLngLat[0]]);
                }
            });

            // Place marker function
            function placeMarker(lng, lat) {
                if (marker) marker.remove();
                marker = new mapboxgl.Marker({ draggable: true, color: '#FF0000' })
                    .setLngLat([lng, lat])
                    .addTo(map);
                marker.on('dragend', () => {
                    const lngLat = marker.getLngLat();
                    if (isWithinBounds([lngLat.lng, lngLat.lat])) {
                        map.flyTo({ center: [lngLat.lng, lngLat.lat], zoom: 14 });
                        updateInputs([lngLat.lat, lngLat.lng]);
                        reverseGeocodeAndUpdate([lngLat.lat, lngLat.lng]);
                    } else {
                        alert('Marker di luar wilayah Indramayu. Mengembalikan ke posisi default.');
                        const defaultLngLat = [108.3247, -6.3265];
                        map.flyTo({ center: defaultLngLat, zoom: 12 });
                        placeMarker(defaultLngLat[0], defaultLngLat[1]);
                        updateInputs([defaultLngLat[1], defaultLngLat[0]]);
                        reverseGeocodeAndUpdate([defaultLngLat[1], defaultLngLat[0]]);
                    }
                });
            }

            // Geocode function
            async function geocode(query) {
                const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&addressdetails=1&countrycodes=ID&limit=5&viewbox=107.98,-6.00,108.50,-6.00&bounded=1`;
                const response = await fetch(url);
                const data = await response.json();
                const filtered = data.filter(item =>
                    item.address && (
                        item.address.county?.toLowerCase().includes('indramayu') ||
                        item.address.city?.toLowerCase().includes('indramayu') ||
                        item.display_name.toLowerCase().includes('indramayu')
                    )
                );
                return filtered;
            }

            // Reverse geocode with Nominatim
            async function reverseGeocodeWithNominatim(lat, lon) {
                const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json&addressdetails=1`;
                const response = await fetch(url, { headers: { 'Accept-Language': 'id' } });
                const data = await response.json();
                return data;
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
                        const suggestionList = document.getElementById('suggestion-list');
                        suggestionList.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                const li = document.createElement('li');
                                li.className = 'list-group-item list-group-item-action';
                                li.textContent = item.display_name;
                                li.addEventListener('click', async () => {
                                    const lat = parseFloat(item.lat);
                                    const lon = parseFloat(item.lon);
                                    if (isWithinBounds([lon, lat])) {
                                        map.flyTo({ center: [lon, lat], zoom: 14 });
                                        placeMarker(lon, lat);
                                        updateInputs([lat, lon]);
                                        reverseGeocodeAndUpdate([lat, lon]);
                                    } else {
                                        alert('Lokasi di luar wilayah Indramayu. Menggunakan lokasi default.');
                                        const defaultLngLat = [108.3247, -6.3265];
                                        map.flyTo({ center: defaultLngLat, zoom: 12 });
                                        placeMarker(defaultLngLat[0], defaultLngLat[1]);
                                        updateInputs([defaultLngLat[1], defaultLngLat[0]]);
                                        reverseGeocodeAndUpdate([defaultLngLat[1], defaultLngLat[0]]);
                                    }
                                    inputAlamat.value = item.display_name;
                                    suggestionList.innerHTML = '';
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
            }

            // Reverse geocode and update address
            async function reverseGeocodeAndUpdate(lngLat) {
                const [lat, lng] = lngLat;
                const data = await reverseGeocodeWithNominatim(lat, lng);
                if (data && data.address) {
                    inputAlamat.value = data.display_name || '-';
                    inputKecamatan.value = data.address.county || data.address.city || '-';
                    inputDesa.value = data.address.village || data.address.hamlet || data.address.suburb || data.address.neighbourhood || data.address.locality || '-';
                }
            }

            // Preview images
            function previewImages(event) {
                const files = event.target.files;
                const previewContainer = document.getElementById('imagePreview');
                const fileInput = document.getElementById('images');
                const dataTransfer = new DataTransfer();

                // Append all existing files to dataTransfer
                if (fileInput.files.length > 0) {
                    Array.from(fileInput.files).forEach(file => dataTransfer.items.add(file));
                }
                // Add new files
                Array.from(files).forEach(file => dataTransfer.items.add(file));

                // Update file input with all files
                fileInput.files = dataTransfer.files;

                // Clear and regenerate previews
                previewContainer.innerHTML = '';
                Array.from(fileInput.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.classList.add('position-relative');
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-preview');
                        const removeBtn = document.createElement('button');
                        removeBtn.classList.add('remove-img');
                        removeBtn.innerHTML = '&times;';
                        removeBtn.onclick = function() {
                            const dt = new DataTransfer();
                            Array.from(fileInput.files).forEach((f, i) => {
                                if (i !== index) dt.items.add(f);
                            });
                            fileInput.files = dt.files;
                            previewImages({ target: { files: fileInput.files } });
                        };
                        div.appendChild(img);
                        div.appendChild(removeBtn);
                        previewContainer.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        map.on('error', (e) => {
            console.error('Error loading map:', e.error);
            alert('Terjadi error saat memuat peta. Silakan coba lagi.');
        });
    });
</script>
<script>
    let selectedFiles = [];

    document.getElementById('images').addEventListener('change', function (event) {
        const newFiles = Array.from(event.target.files);

        // Tambahkan file baru ke daftar tanpa menghapus yang lama
        selectedFiles = selectedFiles.concat(newFiles);
        updateFileInput();
        renderPreview();
    });

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        document.getElementById('images').files = dataTransfer.files;
    }

    function renderPreview() {
        const previewContainer = document.getElementById('imagePreview');
        previewContainer.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'img-wrapper';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-preview');

                const btn = document.createElement('button');
                btn.innerHTML = '×';
                btn.className = 'remove-btn';
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
</script>
</body>
</html>