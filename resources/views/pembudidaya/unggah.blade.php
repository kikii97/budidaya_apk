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

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="alamat" class="form-label small">Alamat Lengkap</label>
                        <input type="text" class="form-control form-control-sm" id="alamat" name="address"
                            placeholder="Ketik alamat..." required />
                        <ul id="suggestion-list" class="list-group mt-2"></ul>
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="kecamatan" class="form-label small">Kecamatan</label>
                        <input type="text" class="form-control form-control-sm" id="kecamatan" name="kecamatan" required
                            readonly />
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="desa" class="form-label small">Desa</label>
                        <input type="text" class="form-control form-control-sm" id="desa" name="desa" required
                            readonly />
                    </div>
                </div>

                <!-- Perbaikan tampilan peta -->
                <div id="map">
                    <label id="use-location-container"
                        style="
                            position: absolute;
                            top: 10px;
                            left: 10px;
                            padding: 6px 7px;
                            border-radius: 6px;
                            box-shadow: 0 1px 4px rgba(0,0,0,0.3);
                            font-size: 14px;
                            z-index: 10;
                            cursor: pointer;">
                            <input type="checkbox" id="use-location" 
                            name="use_geolocation" value="1" />Gunakan Lokasi Saya
                    </label>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="latitude" class="form-label small">Latitude</label>
                        <input type="text" id="latitude" name="latitude" class="form-control form-control-sm" readonly
                            required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="longitude" class="form-label small">Longitude</label>
                        <input type="text" id="longitude" name="longitude" class="form-control form-control-sm" readonly
                            required />
                    </div>
                </div>

                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label for="production_capacity" class="form-label small">Kapasitas Produksi per Bulan
                            (kg)</label>
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

                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label for="harvest_prediction" class="form-label small">Prediksi Panen</label>
                        <input type="text" class="form-control form-control-sm" id="harvest_prediction"
                            name="harvest_prediction" placeholder="Contoh: 21 April 2025" autocomplete="off">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label small">Nomor Telepon</label>
                        <input type="text" class="form-control form-control-sm" name="phone" required
                            oninvalid="this.setCustomValidity('Harap isi nomor telepon yang valid.')"
                            oninput="this.setCustomValidity('')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="details" class="form-label small">Detail Komoditas</label>
                    <textarea class="form-control form-control-sm" id="details" name="details" rows="4"
                        oninvalid="this.setCustomValidity('Harap isi detail Komoditas dengan informasi yang lengkap.')"
                        oninput="this.setCustomValidity('')"></textarea>
                </div>

                <!-- Tambahkan ini di dalam <body> -->
                <div id="dropzone" style="display:none;"></div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-sm">Unggah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Flatpickr Bahasa Indonesia -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <!-- Mapbox JS -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>

    <script>
        // Inisialisasi Flatpickr
        flatpickr("#harvest_prediction", {
            dateFormat: "d F Y",
            locale: "id",
            allowInput: true
        });

        // Inisialisasi Mapbox
        mapboxgl.accessToken = 'pk.eyJ1Ijoia2lraWtzMjMiLCJhIjoiY205dDZiZDgyMDgzdzJtcTk1bW81ZG4wOCJ9.2KzfsbK1tXHs7vuAkwMsKQ';

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [108.321601, -6.326467],
            zoom: 12,
            maxBounds: [
                [107.98, -6.60],
                [108.50, -6.00]
            ]
        });

        map.addControl(new mapboxgl.NavigationControl());

        // Deklarasi marker sebagai variabel global dalam scope map.on('load')
        let marker;
        let previousCenter = null;
        let previousZoom = null;
        let previousMarker = null;

        map.on('load', () => {
            marker = new mapboxgl.Marker({
                    draggable: true
                })
                .setLngLat([108.321601, -6.326467])
                .addTo(map);

            const inputAlamat = document.getElementById('alamat');
            const inputLat = document.getElementById('latitude');
            const inputLng = document.getElementById('longitude');
            const inputKecamatan = document.getElementById('kecamatan');
            const inputDesa = document.getElementById('desa');

            // Fungsi untuk mengatur lokasi berdasarkan geolokasi
            function setUserLocation(position) {
                const lngLat = [position.coords.longitude, position.coords.latitude];
                if (isWithinBounds(lngLat)) {
                    map.flyTo({
                        center: lngLat,
                        zoom: 14
                    });
                    placeMarker(lngLat[0], lngLat[1]);
                    updateInputs([lngLat[1], lngLat[0]]); // lat, lng
                    reverseGeocodeAndUpdate([lngLat[1], lngLat[0]]);
                } else {
                    alert('Lokasi Anda di luar wilayah Indramayu. Menggunakan lokasi default.');
                    const defaultLngLat = [108.321601, -6.326467];
                    map.flyTo({
                        center: defaultLngLat,
                        zoom: 12
                    });
                    placeMarker(defaultLngLat[0], defaultLngLat[1]);
                    updateInputs(defaultLngLat);
                    reverseGeocodeAndUpdate(defaultLngLat);
                }
            }

            // Tangani error geolokasi
            function handleLocationError(error) {
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
                        alert('Terjadi error yang tidak diketahui. Menggunakan lokasi default.');
                        break;
                }
                const defaultLngLat = [108.321601, -6.326467];
                map.flyTo({
                    center: defaultLngLat,
                    zoom: 12
                });
                placeMarker(defaultLngLat[0], defaultLngLat[1]);
            }

            // Dapatkan lokasi pengguna saat peta dimuat
            document.getElementById('use-location').addEventListener('change', function(e) {
                if (e.target.checked) {
                    // Simpan posisi saat ini SEBELUM ke lokasi pengguna
                    previousCenter = map.getCenter();
                    previousZoom = map.getZoom();
                    previousMarker = marker.getLngLat();

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(setUserLocation, handleLocationError, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        });
                    } else {
                        alert('Geolokasi tidak didukung oleh browser ini.');
                    }
                } else {
                    // Balik ke posisi sebelumnya (jika ada)
                    if (previousCenter && previousZoom !== null && previousMarker) {
                        map.flyTo({
                            center: [previousCenter.lng, previousCenter.lat],
                            zoom: previousZoom
                        });

                        placeMarker(previousMarker.lng, previousMarker.lat); // balikin markernya

                        // update input & reverse geocode
                        updateInputs([previousMarker.lat, previousMarker.lng]);
                        reverseGeocodeAndUpdate([previousMarker.lat, previousMarker.lng]);
                    }

                }
            });

            // Fungsi yang sebelumnya kamu pakai
            function setUserLocation(position) {
                const userLng = position.coords.longitude;
                const userLat = position.coords.latitude;
                const userLocation = [userLng, userLat];

                map.flyTo({
                    center: userLocation,
                    zoom: 14
                });
                placeMarker(userLng, userLat);
                updateInputs([userLat, userLng]);
                reverseGeocodeAndUpdate([userLat, userLng]);
            }

            function handleLocationError(error) {
                alert('Gagal mendapatkan lokasi Anda.');
            }

            // if (navigator.geolocation) {
            //     navigator.geolocation.getCurrentPosition(setUserLocation, handleLocationError, {
            //         enableHighAccuracy: true,
            //         timeout: 10000,
            //         maximumAge: 0
            //     });
            // } else {
            //     alert('Geolokasi tidak didukung oleh browser ini. Menggunakan lokasi default.');
            //     const defaultLngLat = [108.3247, -6.3265];
            //     map.flyTo({
            //         center: defaultLngLat,
            //         zoom: 12
            //     });
            //     placeMarker(defaultLngLat[0], defaultLngLat[1]);
            // }

            // Klik peta untuk menempatkan marker
            map.on('click', (e) => {
                const lng = e.lngLat.lng;
                const lat = e.lngLat.lat;
                if (isWithinBounds([lng, lat])) {
                    placeMarker(lng, lat);
                    updateInputs([lat, lng]);
                    reverseGeocodeAndUpdate([lat, lng]);
                } else {
                    alert('Lokasi di luar wilayah Indramayu. Menggunakan lokasi default.');
                    const defaultLngLat = [108.321601, -6.326467];
                    map.flyTo({
                        center: defaultLngLat,
                        zoom: 12
                    });
                    placeMarker(defaultLngLat[0], defaultLngLat[1]);
                    updateInputs(defaultLngLat);
                }
            });

            // Fungsi untuk menempatkan dan memperbarui marker
            function placeMarker(lng, lat) {
                if (marker) marker.remove();
                marker = new mapboxgl.Marker({
                        draggable: true
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
                        alert('Marker di luar wilayah Indramayu. Mengembalikan ke posisi default.');
                        const defaultLngLat = [108.321601, -6.326467];
                        map.flyTo({
                            center: defaultLngLat,
                            zoom: 12
                        });
                        placeMarker(defaultLngLat[0], defaultLngLat[1]);
                        updateInputs(defaultLngLat);
                    }
                });
            }

            // Fungsi cari alamat
            async function geocode(query) {
                const url = `https://nominatim.openstreetmap.org/search?` +
                    `q=${encodeURIComponent(query)}&format=json&addressdetails=1&countrycodes=ID&limit=5` +
                    `&viewbox=107.98,-6.00,108.50,-6.60&bounded=1`;
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

            async function reverseGeocode(lat, lng) {
                const url =
                    `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}&types=address,place,locality,region,district&language=id`;
                const response = await fetch(url);
                return response.json();
            }

            async function reverseGeocodeWithNominatim(lat, lon) {
                const url =
                    `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json&addressdetails=1`;
                const response = await fetch(url, {
                    headers: {
                        'Accept-Language': 'id'
                    }
                });
                const data = await response.json();
                return data;
            }

            function normalizeInput(query) {
                let q = query.toLowerCase().trim();
                q = q.replace(/^jl\.?\s+/g, 'jalan ');
                q = q.replace(/^jln\.?\s+/g, 'jalan ');
                q = q.replace(/\s+/g, ' ');
                return q;
            }

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
                                        map.flyTo({
                                            center: [lon, lat],
                                            zoom: 14
                                        });
                                        placeMarker(lon, lat);
                                        updateInputs([lat, lon]);
                                    } else {
                                        alert(
                                            'Lokasi di luar wilayah Indramayu. Menggunakan lokasi default.'
                                        );
                                        const defaultLngLat = [108.322028, -
                                            6.3267936
                                        ];
                                        map.flyTo({
                                            center: defaultLngLat,
                                            zoom: 12
                                        });
                                        placeMarker(defaultLngLat[0],
                                            defaultLngLat[1]);
                                        updateInputs(defaultLngLat);
                                    }
                                    inputAlamat.value = item.display_name;
                                    suggestionList.innerHTML = '';
                                    reverseGeocodeAndUpdate([lat, lon]);
                                });
                                suggestionList.appendChild(li);
                            });
                        }
                    }, 400);
                } else {
                    document.getElementById('suggestion-list').innerHTML = '';
                }
            });

            function isWithinBounds(lngLat) {
                const [lng, lat] = lngLat;
                return lng >= 107.98 && lng <= 108.50 && lat >= -6.60 && lat <= -6.00;
            }

            function updateInputs(lngLat) {
                const [lat, lng] = lngLat;
                inputLat.value = lat.toFixed(6);
                inputLng.value = lng.toFixed(6);
            }

            async function reverseGeocodeAndUpdate(lngLat) {
                const [lat, lng] = lngLat;
                const data = await reverseGeocodeWithNominatim(lat, lng);
                console.log("Data hasil reverse geocode:", data); // <--- Tambahkan ini
                if (data && data.address) {
                    inputAlamat.value = data.display_name || '-';
                    inputKecamatan.value = data.address.county || data.address.city || '-';
                    inputDesa.value = data.address.village || data.address.hamlet || data.address.suburb || data
                        .address.neighbourhood || data.address.locality || '-';
                }
            }
        });

        map.on('error', (e) => {
            console.error('Error loading map:', e.error);
            alert('Terjadi error saat memuat peta. Silakan coba lagi.');
        });
    </script>

    <style>
        .img-thumbnail {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        input[type="text"].flatpickr-input {
            background-color: #fff !important;
            cursor: text;
        }

        @media (max-width: 576px) {
            .img-thumbnail {
                width: 80px;
                height: 80px;
            }
        }

        #map {
            width: 100%;
            height: 260px;
            margin-top: 0rem;
            position: relative;
            overflow: hidden;
        }
    </style>
@endsection
