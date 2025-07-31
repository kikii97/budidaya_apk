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
                                    $error,
                                ) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pembudidaya.produk.update', $produk->id) }}" method="POST"
                enctype="multipart/form-data" style="font-size: 0.9rem;">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label class="form-label small">Jenis Komoditas</label>
                        <select class="form-select form-select-sm" name="commodity_type" required
                            oninvalid="this.setCustomValidity('Harap pilih jenis komoditas.')"
                            oninput="this.setCustomValidity('')">
                            <option value="" disabled>Pilih Jenis Komoditas</option>
                            @foreach (['Rumput Laut', 'Udang', 'Ikan Gurame', 'Ikan Bandeng', 'Ikan Lele', 'Ikan Nila'] as $komoditas)
                                <option value="{{ $komoditas }}"
                                    {{ $produk->jenis_komoditas == $komoditas ? 'selected' : '' }}>{{ $komoditas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label small">Jenis Spesifik Komoditas</label>
                        <input type="text" class="form-control form-control-sm" name="specific_commodity_type"
                            value="{{ old('specific_commodity_type', $produk->jenis_spesifik_komoditas) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="alamat" class="form-label small">Alamat Lengkap</label>
                        <input type="text" class="form-control form-control-sm" id="alamat" name="address"
                            value="{{ old('address', $produk->alamat_lengkap) }}" required>
                        <ul id="suggestion-list" class="list-group mt-2"></ul>
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="kecamatan" class="form-label small">Kecamatan</label>
                        <input type="text" class="form-control form-control-sm" id="kecamatan" name="kecamatan"
                            value="{{ old('kecamatan', $produk->kecamatan) }}" required readonly>
                    </div>

                    {{-- <div class="mb-3 col-md-3">
                        <label for="kecamatan" class="form-label small">Kecamatan</label>
                        <select class="form-select form-select-sm" id="kecamatan" name="kecamatan" required
                            oninvalid="this.setCustomValidity('Harap pilih kecamatan.')"
                            oninput="this.setCustomValidity('')">
                            @foreach ($kecamatanList as $kecamatan)
                                <option value="{{ $kecamatan }}"
                                    {{ $produk->kecamatan == $kecamatan ? 'selected' : '' }}>
                                    {{ $kecamatan }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="col-md-3 mb-2">
                        <label for="desa" class="form-label small">Desa</label>
                        <input type="text" class="form-control form-control-sm" id="desa" name="desa"
                            value="{{ old('desa', $produk->desa) }}" required readonly>
                    </div>
                </div>

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
                        <input type="checkbox" id="use-location" />
                        Gunakan Lokasi Saya
                    </label>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="latitude" class="form-label small">Latitude</label>
                        <input type="text" id="latitude" name="latitude" class="form-control form-control-sm"
                            value="{{ old('latitude', $produk->latitude) }}" readonly required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="longitude" class="form-label small">Longitude</label>
                        <input type="text" id="longitude" name="longitude" class="form-control form-control-sm"
                            value="{{ old('longitude', $produk->longitude) }}" readonly required>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label class="form-label small">Kapasitas Produksi</label>
                        <input type="number" class="form-control form-control-sm" name="production_capacity"
                            value="{{ old('production_capacity', $produk->kapasitas_produksi) }}">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label small">Masa Produksi Puncak</label>
                        <input type="text" class="form-control form-control-sm" name="peak_production_period"
                            value="{{ old('peak_production_period', $produk->masa_produksi_puncak) }}">
                    </div>
                </div>

                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label class="form-label small">Kisaran Harga Minimum</label>
                        <input type="number" class="form-control form-control-sm" name="price_range_min"
                            value="{{ old('price_range_min', $produk->kisaran_harga_min) }}" required>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label small">Kisaran Harga Maksimum</label>
                        <input type="number" class="form-control form-control-sm" name="price_range_max"
                            value="{{ old('price_range_max', $produk->kisaran_harga_max) }}" required>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label for="harvest_prediction" class="form-label small">Prediksi Panen</label>
                        <input type="text" class="form-control form-control-sm" id="harvest_prediction"
                            name="harvest_prediction" placeholder="Contoh: 21 April 2025" autocomplete="off"
                            value="{{ old('harvest_prediction', $produk->prediksi_panen ? \Carbon\Carbon::parse($produk->prediksi_panen)->translatedFormat('d F Y') : '') }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label small">Nomor Telepon</label>
                        <input type="text" class="form-control form-control-sm" name="phone"
                            value="{{ old('phone', $produk->telepon) }}" required
                            oninvalid="this.setCustomValidity('Harap isi nomor telepon yang valid.')"
                            oninput="this.setCustomValidity('')">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small">Detail Komoditas</label>
                    <textarea class="form-control form-control-sm" name="details" rows="3">{{ old('details', $produk->detail) }}</textarea>
                </div>

                {{-- Bagian unggah gambar baru --}}
                <div class="mb-3">
                    <label class="form-label small">Unggah Gambar</label>
                    <input type="file" id="images" name="images[]" class="form-control form-control-sm" multiple
                        accept="image/*" onchange="previewImages(event)">
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
                                        <img src="{{ asset('storage/images/' . $gambar) }}"
                                            alt="Gambar Produk" class="img-thumbnail">
                                    </div>
                                    <div class="form-check mt-1 d-flex align-items-center justify-content-center">
                                        <input class="form-check-input" type="checkbox" name="hapus_gambar[]"
                                            value="{{ $gambar }}" id="hapus_{{ $index }}">
                                        <label class="form-check-label small mb-0 ms-1"
                                            for="hapus_{{ $index }}">Hapus</label>
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
            center: [{{ $produk->longitude ?? 108.321601 }}, {{ $produk->latitude ?? -6.326467 }}],
            zoom: 14,
            maxBounds: [
                [107.98, -6.60],
                [108.50, -6.00]
            ]
        });

        map.addControl(new mapboxgl.NavigationControl());

        // Deklarasi marker sebagai variabel global
        let marker;
        let previousCenter = null;
        let previousZoom = null;
        let previousMarker = null;

        map.on('load', () => {
            // Inisialisasi marker dengan posisi awal dari data produk
            marker = new mapboxgl.Marker({
                    draggable: true
                })
                .setLngLat([{{ $produk->longitude ?? 108.321601 }}, {{ $produk->latitude ?? -6.326467 }}])
                .addTo(map);

            const inputAlamat = document.getElementById('alamat');
            const inputLat = document.getElementById('latitude');
            const inputLng = document.getElementById('longitude');
            const inputKecamatan = document.getElementById('kecamatan');
            const inputDesa = document.getElementById('desa');

            // Isi kolom input dengan data awal dari database
            inputAlamat.value = '{{ $produk->alamat ?? 'Indramayu, Jawa Barat, Indonesia' }}';
            inputKecamatan.value = '{{ $produk->kecamatan ?? 'Indramayu' }}';
            inputDesa.value = '{{ $produk->desa ?? '-' }}';
            inputLat.value =
            '{{ $produk->latitude ? number_format($produk->latitude, 6, '.', '') : '-6.326467' }}';
            inputLng.value =
                '{{ $produk->longitude ? number_format($produk->longitude, 6, '.', '') : '108.321601' }}';

            // Panggil reverseGeocodeAndUpdate untuk memverifikasi data berdasarkan koordinat
            reverseGeocodeAndUpdate([{{ $produk->latitude ?? -6.326467 }},
                {{ $produk->longitude ?? 108.321601 }}]);

            // Fungsi untuk memeriksa apakah koordinat dalam batas Indramayu
            function isWithinBounds(lngLat) {
                const [lng, lat] = lngLat;
                return lng >= 107.98 && lng <= 108.50 && lat >= -6.60 && lat <= -6.00;
            }

            // Fungsi untuk memperbarui input fields
            function updateInputs(lngLat) {
                const [lat, lng] = lngLat;
                inputLat.value = lat.toFixed(6);
                inputLng.value = lng.toFixed(6);
            }

            // Fungsi untuk mengekstrak kecamatan dari display_name
            function extractKecamatanFromDisplayName(displayName) {
                if (!displayName) return null;
                const parts = displayName.split(', ').map(part => part.trim().toLowerCase());
                // Daftar kecamatan di Kabupaten Indramayu
                const kecamatanList = [
                    'haurgeulis', 'gantar', 'kroya', 'gabuskulon', 'ciedug',
                    'sliyeg', 'jatibarang', 'balongan', 'indramayu', 'sindang',
                    'cantigi', 'pasekan', 'lohbener', 'arahan', 'juntinyuat',
                    'sukagumiwang', 'bangodua', 'tukdana', 'widasari', 'kertasemaya',
                    'krangkeng', 'karangampel', 'kedokanbunder', 'bongas', 'anjatan',
                    'sukra', 'patrol', 'lelea', 'terisi', 'cendana'
                ];
                for (const part of parts) {
                    if (kecamatanList.includes(part)) {
                        // Kapitalisasi nama kecamatan
                        return part.charAt(0).toUpperCase() + part.slice(1);
                    }
                }
                return null;
            }

            // Fungsi untuk reverse geocoding menggunakan Nominatim
            async function reverseGeocodeWithNominatim(lat, lng) {
                const url =
                    `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&addressdetails=1&zoom=18`;
                const response = await fetch(url, {
                    headers: {
                        'Accept-Language': 'id'
                    }
                });
                return response.json();
            }

            // Fungsi untuk reverse geocoding dan update input
            async function reverseGeocodeAndUpdate(lngLat) {
                const [lat, lng] = lngLat;
                try {
                    const data = await reverseGeocodeWithNominatim(lat, lng);
                    console.log("Data hasil reverse geocode:", data); // Untuk debugging
                    if (data && data.address && (
                            data.address.county?.toLowerCase().includes('indramayu') ||
                            data.address.city?.toLowerCase().includes('indramayu') ||
                            data.display_name.toLowerCase().includes('indramayu')
                        )) {
                        inputAlamat.value = data.display_name || inputAlamat.value;
                        inputKecamatan.value = data.address.sub_district ||
                            data.address.suburb ||
                            data.address.town ||
                            data.address.municipality ||
                            data.address.district ||
                            data.address.city ||
                            extractKecamatanFromDisplayName(data.display_name) ||
                            inputKecamatan.value || '-';
                        inputDesa.value = data.address.village ||
                            data.address.hamlet ||
                            data.address.suburb ||
                            data.address.neighbourhood ||
                            data.address.locality ||
                            inputDesa.value || '-';
                    } else {
                        alert('Lokasi di luar Kabupaten Indramayu. Menggunakan lokasi default.');
                        const defaultLngLat = [108.321601, -6.326467];
                        map.flyTo({
                            center: defaultLngLat,
                            zoom: 12
                        });
                        placeMarker(defaultLngLat[0], defaultLngLat[1]);
                        updateInputs(defaultLngLat);
                        inputAlamat.value = 'Indramayu, Jawa Barat, Indonesia';
                        inputKecamatan.value = 'Indramayu';
                        inputDesa.value = '-';
                    }
                } catch (error) {
                    console.error('Error during reverse geocoding:', error);
                    alert('Gagal mendapatkan data alamat. Silakan coba lagi.');
                    // Pertahankan data awal jika geocoding gagal
                    inputAlamat.value = inputAlamat.value || '-';
                    inputKecamatan.value = inputKecamatan.value || '-';
                    inputDesa.value = inputDesa.value || '-';
                }
            }

            // Fungsi untuk menempatkan marker
            function placeMarker(lng, lat) {
                if (marker) marker.remove();
                marker = new mapboxgl.Marker({
                        draggable: true
                    })
                    .setLngLat([lng, lat])
                    .addTo(map);

                marker.on('dragend', async () => {
                    const lngLat = marker.getLngLat();
                    if (isWithinBounds([lngLat.lng, lngLat.lat])) {
                        const data = await reverseGeocodeWithNominatim(lngLat.lat, lngLat.lng);
                        if (data && data.address && (
                                data.address.county?.toLowerCase().includes('indramayu') ||
                                data.address.city?.toLowerCase().includes('indramayu') ||
                                data.display_name.toLowerCase().includes('indramayu')
                            )) {
                            map.flyTo({
                                center: [lngLat.lng, lngLat.lat],
                                zoom: 14
                            });
                            updateInputs([lngLat.lat, lngLat.lng]);
                            reverseGeocodeAndUpdate([lngLat.lat, lngLat.lng]);
                        } else {
                            alert(
                                'Marker di luar Kabupaten Indramayu. Mengembalikan ke posisi default.'
                                );
                            const defaultLngLat = [108.321601, -6.326467];
                            map.flyTo({
                                center: defaultLngLat,
                                zoom: 12
                            });
                            placeMarker(defaultLngLat[0], defaultLngLat[1]);
                            updateInputs(defaultLngLat);
                            reverseGeocodeAndUpdate(defaultLngLat);
                        }
                    } else {
                        alert('Marker di luar Kabupaten Indramayu. Mengembalikan ke posisi default.');
                        const defaultLngLat = [108.321601, -6.326467];
                        map.flyTo({
                            center: defaultLngLat,
                            zoom: 12
                        });
                        placeMarker(defaultLngLat[0], defaultLngLat[1]);
                        updateInputs(defaultLngLat);
                        reverseGeocodeAndUpdate(defaultLngLat);
                    }
                });
            }

            // Event listener untuk klik peta
            map.on('click', async (e) => {
                const lng = e.lngLat.lng;
                const lat = e.lngLat.lat;
                if (isWithinBounds([lng, lat])) {
                    const data = await reverseGeocodeWithNominatim(lat, lng);
                    if (data && data.address && (
                            data.address.county?.toLowerCase().includes('indramayu') ||
                            data.address.city?.toLowerCase().includes('indramayu') ||
                            data.display_name.toLowerCase().includes('indramayu')
                        )) {
                        placeMarker(lng, lat);
                        updateInputs([lat, lng]);
                        reverseGeocodeAndUpdate([lat, lng]);
                    } else {
                        alert('Lokasi di luar Kabupaten Indramayu. Menggunakan lokasi default.');
                        const defaultLngLat = [108.321601, -6.326467];
                        map.flyTo({
                            center: defaultLngLat,
                            zoom: 12
                        });
                        placeMarker(defaultLngLat[0], defaultLngLat[1]);
                        updateInputs(defaultLngLat);
                        reverseGeocodeAndUpdate(defaultLngLat);
                    }
                } else {
                    alert('Lokasi di luar Kabupaten Indramayu. Menggunakan lokasi default.');
                    const defaultLngLat = [108.321601, -6.326467];
                    map.flyTo({
                        center: defaultLngLat,
                        zoom: 12
                    });
                    placeMarker(defaultLngLat[0], defaultLngLat[1]);
                    updateInputs(defaultLngLat);
                    reverseGeocodeAndUpdate(defaultLngLat);
                }
            });

            // Event listener untuk checkbox "Gunakan Lokasi Saya"
            document.getElementById('use-location').addEventListener('change', function(e) {
                if (e.target.checked) {
                    previousCenter = map.getCenter();
                    previousZoom = map.getZoom();
                    previousMarker = marker.getLngLat();

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const lngLat = [position.coords.longitude, position.coords.latitude];
                                if (isWithinBounds(lngLat)) {
                                    const data = reverseGeocodeWithNominatim(lngLat[1], lngLat[0]).then(
                                        data => {
                                            if (data && data.address && (
                                                    data.address.county?.toLowerCase().includes(
                                                        'indramayu') ||
                                                    data.address.city?.toLowerCase().includes(
                                                        'indramayu') ||
                                                    data.display_name.toLowerCase().includes(
                                                        'indramayu')
                                                )) {
                                                map.flyTo({
                                                    center: lngLat,
                                                    zoom: 14
                                                });
                                                placeMarker(lngLat[0], lngLat[1]);
                                                updateInputs([lngLat[1], lngLat[0]]);
                                                reverseGeocodeAndUpdate([lngLat[1], lngLat[0]]);
                                            } else {
                                                alert(
                                                    'Lokasi Anda di luar Kabupaten Indramayu. Menggunakan lokasi default.'
                                                    );
                                                const defaultLngLat = [108.321601, -6.326467];
                                                map.flyTo({
                                                    center: defaultLngLat,
                                                    zoom: 12
                                                });
                                                placeMarker(defaultLngLat[0], defaultLngLat[1]);
                                                updateInputs(defaultLngLat);
                                                reverseGeocodeAndUpdate(defaultLngLat);
                                            }
                                        });
                                } else {
                                    alert(
                                        'Lokasi Anda di luar Kabupaten Indramayu. Menggunakan lokasi default.'
                                        );
                                    const defaultLngLat = [108.321601, -6.326467];
                                    map.flyTo({
                                        center: defaultLngLat,
                                        zoom: 12
                                    });
                                    placeMarker(defaultLngLat[0], defaultLngLat[1]);
                                    updateInputs(defaultLngLat);
                                    reverseGeocodeAndUpdate(defaultLngLat);
                                }
                            },
                            (error) => {
                                switch (error.code) {
                                    case error.PERMISSION_DENIED:
                                        alert('Izin geolokasi ditolak. Menggunakan lokasi default.');
                                        break;
                                    case error.POSITION_UNAVAILABLE:
                                        alert(
                                            'Informasi lokasi tidak tersedia. Menggunakan lokasi default.'
                                            );
                                        break;
                                    case error.TIMEOUT:
                                        alert(
                                            'Waktu habis saat mendapatkan lokasi. Menggunakan lokasi default.'
                                            );
                                        break;
                                    default:
                                        alert(
                                            'Terjadi error yang tidak diketahui. Menggunakan lokasi default.'
                                            );
                                        break;
                                }
                                const defaultLngLat = [108.321601, -6.326467];
                                map.flyTo({
                                    center: defaultLngLat,
                                    zoom: 12
                                });
                                placeMarker(defaultLngLat[0], defaultLngLat[1]);
                                updateInputs(defaultLngLat);
                                reverseGeocodeAndUpdate(defaultLngLat);
                            }, {
                                enableHighAccuracy: true,
                                timeout: 10000,
                                maximumAge: 0
                            }
                        );
                    } else {
                        alert('Geolokasi tidak didukung oleh browser ini.');
                    }
                } else {
                    if (previousCenter && previousZoom !== null && previousMarker) {
                        map.flyTo({
                            center: [previousCenter.lng, previousCenter.lat],
                            zoom: previousZoom
                        });
                        placeMarker(previousMarker.lng, previousMarker.lat);
                        updateInputs([previousMarker.lat, previousMarker.lng]);
                        reverseGeocodeAndUpdate([previousMarker.lat, previousMarker.lng]);
                    }
                }
            });

            // Fungsi untuk pencarian alamat
            async function geocode(query) {
                const url =
                    `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&addressdetails=1&countrycodes=ID&limit=5&viewbox=107.98,-6.60,108.50,-6.00&bounded=1`;
                const response = await fetch(url);
                const data = await response.json();
                return data.filter(item =>
                    item.address && (
                        item.address.county?.toLowerCase().includes('indramayu') ||
                        item.address.city?.toLowerCase().includes('indramayu') ||
                        item.display_name.toLowerCase().includes('indramayu')
                    )
                );
            }

            // Event listener untuk input alamat
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
                                        reverseGeocodeAndUpdate([lat, lon]);
                                    } else {
                                        alert(
                                            'Lokasi di luar wilayah Indramayu. Menggunakan lokasi default.'
                                            );
                                        const defaultLngLat = [108.321601, -
                                            6.326467
                                        ];
                                        map.flyTo({
                                            center: defaultLngLat,
                                            zoom: 12
                                        });
                                        placeMarker(defaultLngLat[0],
                                            defaultLngLat[1]);
                                        updateInputs(defaultLngLat);
                                        reverseGeocodeAndUpdate(
                                            defaultLngLat);
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

            function normalizeInput(query) {
                let q = query.toLowerCase().trim();
                q = q.replace(/^jl\.?\s+/g, 'jalan ');
                q = q.replace(/^jln\.?\s+/g, 'jalan ');
                q = q.replace(/\s+/g, ' ');
                return q;
            }
        });

        map.on('error', (e) => {
            console.error('Error loading map:', e.error);
            alert('Terjadi error saat memuat peta. Silakan coba lagi.');
        });
    </script>

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
