@extends('layouts.app')

@section('title', 'Katalog - SIBIKANDA')

<!-- Header Navbar -->
@section('header')
    @include('partials.header')
@endsection

@section('content')
    <!-- Modal Filter untuk layar kecil -->
    <div class="modal fade" id="filterModal" style="padding-top: -1rem; padding-bottom: 0rem; font-size: 0.8rem;" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <form action="{{ route('katalog') }}" method="GET" class="filter-sidebar p-4">
                        <!-- Filter Jenis Komoditas -->
                        <div class="filter-group">
                            <h6 class="mb-3">Jenis Komoditas</h6>
                            @php
                                $selectedKomoditas = request('jenis_komoditas', []);
                            @endphp
                            <div class="row">
                                @foreach (['Udang', 'Rumput Laut', 'Ikan Bandeng', 'Ikan Gurame', 'Ikan Lele', 'Ikan Nila'] as $komoditas)
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="{{ Str::slug($komoditas) }}"
                                                name="jenis_komoditas[]" value="{{ $komoditas }}"
                                                {{ in_array($komoditas, $selectedKomoditas) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ Str::slug($komoditas) }}">
                                                {{ $komoditas }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter Price Range -->
                        <div class="filter-group">
                            <h6 class="mb-3">Kisaran Harga (Rp)</h6>
                            @php
                                $priceMin = request('price_min', '');
                                $priceMax = request('price_max', '');
                            @endphp
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="price_min" class="form-label">Min:</label>
                                    <input type="number" id="price_min" name="price_min" class="form-control"
                                        min="0" value="{{ $priceMin }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="price_max" class="form-label">Max:</label>
                                    <input type="number" id="price_max" name="price_max" class="form-control"
                                        min="0" value="{{ $priceMax }}">
                                </div>
                            </div>
                        </div>

                        <!-- Filter Kecamatan -->
                        <div class="filter-group mt-4">
                            <h6 class="mb-3">Kecamatan</h6>
                            @php
                                $selectedKecamatan = request('kecamatan', []);
                                $kecamatanList = [
                                    'Anjatan',
                                    'Arahan',
                                    'Balongan',
                                    'Bangodua',
                                    'Bongas',
                                    'Cantigi',
                                    'Cikedung',
                                    'Gabuswetan',
                                    'Gantar',
                                    'Haurgeulis',
                                    'Indramayu',
                                    'Jatibarang',
                                    'Juntinyuat',
                                    'Kandanghaur',
                                    'Karangampel',
                                    'Kedokan Bunder',
                                    'Kertasemaya',
                                    'Krangkeng',
                                    'Kroya',
                                    'Lelea',
                                    'Lohbener',
                                    'Losarang',
                                    'Pasekan',
                                    'Patrol',
                                    'Sindang',
                                    'Sliyeg',
                                    'Sukagumiwang',
                                    'Sukra',
                                    'Terisi',
                                    'Tukdana',
                                    'Widasari',
                                ];
                                $visibleCount = 6; // menampilkan 6 item awal (2 kolom × 3 baris)
                            @endphp

                            <div class="row">
                                @foreach ($kecamatanList as $index => $kecamatan)
                                    <div class="col-md-6 kecamatan-item"
                                        style="{{ $index >= $visibleCount ? 'display:none;' : '' }}">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="{{ Str::slug($kecamatan) }}"
                                                name="kecamatan[]" value="{{ $kecamatan }}"
                                                {{ in_array($kecamatan, $selectedKecamatan) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ Str::slug($kecamatan) }}">
                                                {{ $kecamatan }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="toggleKecamatanBtnMobile" class="toggle-btn">
                                Lihat lainnya <i class="bi bi-chevron-down"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-outline-primary w-100 mt-2">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="container" style="padding-top: 0rem; padding-bottom: 0rem; font-size: 0.8rem;">
        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Produk Budidaya</h4>
            <div class="d-flex gap-2 align-items-center">
                <span class="text-muted">Sort by:</span>
                <form method="GET" action="{{ route('katalog') }}">
                    <select name="sort_by" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="terbaru" {{ request('sort_by') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="termurah" {{ request('sort_by') == 'termurah' ? 'selected' : '' }}>Termurah</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <!-- Tombol Filter untuk layar kecil -->
            <div class="col-12 d-lg-none mb-3 d-flex justify-content-end">
                <button id="openFilterBtn" class="btn btn-primary w-5">
                    Filter Produk <i class="bi bi-filter ms-2"></i>
                </button>
            </div>

            <!-- Sidebar Filter -->
            <div class="col-lg-3 d-none d-lg-block" style="line-height: 0.5; zoom: 75%;">
                <form action="{{ route('katalog') }}" method="GET" class="filter-sidebar p-4 shadow-sm">

                    <!-- Filter Jenis Komoditas -->
                    <div class="filter-group">
                        <h6 class="mb-3">Jenis Komoditas</h6>
                        @php
                            $selectedKomoditas = request('jenis_komoditas', []);
                        @endphp
                        <div class="row">
                            @foreach (['Udang', 'Rumput Laut', 'Ikan Bandeng', 'Ikan Gurame', 'Ikan Lele', 'Ikan Nila'] as $komoditas)
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="{{ Str::slug($komoditas) }}"
                                            name="jenis_komoditas[]" value="{{ $komoditas }}"
                                            {{ in_array($komoditas, $selectedKomoditas) ? 'checked' : '' }}>
                                        <label class="mt-1 ps-2 form-check-label" for="{{ Str::slug($komoditas) }}">
                                            {{ $komoditas }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter Price Range -->
                    <div class="filter-group">
                        <h6 class="mb-4">Kisaran Harga (Rp)</h6>
                        @php
                            $priceMin = request('price_min', '');
                            $priceMax = request('price_max', '');
                        @endphp
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="price_min" class="form-label">Min:</label>
                                <input type="number" id="price_min" name="price_min" class="form-control"
                                    min="0" value="{{ $priceMin }}">
                            </div>
                            <div class="col-md-6">
                                <label for="price_max" class="form-label">Max:</label>
                                <input type="number" id="price_max" name="price_max" class="form-control"
                                    min="0" value="{{ $priceMax }}">
                            </div>
                        </div>
                    </div>

                    <!-- Filter Kecamatan -->
                    <div class="filter-group mt-4">
                        <h6 class="mb-3">Kecamatan</h6>
                        @php
                            $selectedKecamatan = request('kecamatan', []);
                            $kecamatanList = [
                                'Anjatan',
                                'Arahan',
                                'Balongan',
                                'Bangodua',
                                'Bongas',
                                'Cantigi',
                                'Cikedung',
                                'Gabuswetan',
                                'Gantar',
                                'Haurgeulis',
                                'Indramayu',
                                'Jatibarang',
                                'Juntinyuat',
                                'Kandanghaur',
                                'Karangampel',
                                'Kedokan Bunder',
                                'Kertasemaya',
                                'Krangkeng',
                                'Kroya',
                                'Lelea',
                                'Lohbener',
                                'Losarang',
                                'Pasekan',
                                'Patrol',
                                'Sindang',
                                'Sliyeg',
                                'Sukagumiwang',
                                'Sukra',
                                'Terisi',
                                'Tukdana',
                                'Widasari',
                            ];
                            $visibleCount = 6; // menampilkan 6 item awal (2 kolom × 3 baris)
                        @endphp

                        <div class="row">
                            @foreach ($kecamatanList as $index => $kecamatan)
                                <div class="col-md-6 kecamatan-item"
                                    style="{{ $index >= $visibleCount ? 'display:none;' : '' }}">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="{{ Str::slug($kecamatan) }}"
                                            name="kecamatan[]" value="{{ $kecamatan }}"
                                            {{ in_array($kecamatan, $selectedKecamatan) ? 'checked' : '' }}>
                                        <label class="mt-1 ps-2 form-check-label" for="{{ Str::slug($kecamatan) }}">
                                            {{ $kecamatan }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if (count($kecamatanList) > $visibleCount)
                            <button type="button" id="toggleKecamatanBtnDesktop"
                                class="toggle-btn btn btn-link p-0 mt-2">
                                Lihat lainnya <i class="bi bi-chevron-down"></i>
                            </button>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-outline-primary w-100 mt-4">Apply Filters</button>
                </form>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9" style="font-size: 0.8rem; line-height: 0.5; zoom: 75%;">
                <div class="row g-4">
                    @forelse ($produkList as $produk)
                        <div class="col-6 col-md-4">
                            <a href="{{ route('produk.detail', $produk->id) }}">
                                <div class="product-card shadow-sm">
                                    <div class="position-relative">
                                        @php
                                            $gambar = json_decode($produk->gambar, true);
                                            $gambarUtama = $gambar[0] ?? 'default.jpg';
                                        @endphp
                                        <img src="{{ asset('storage/images/' . $gambarUtama) }}"
                                            class="product-image w-100" alt="Product">
                                    </div>
                                    <div class="p-3">
                                        <h6 class="category-badge d-inline-block">{{ $produk->jenis_komoditas }}</h6>
                                        <h6 class="mt-2">{{ $produk->jenis_spesifik_komoditas ?? '-' }}</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="price text-dark fw-semibold">
                                                Rp{{ number_format($produk->kisaran_harga_min, 0, ',', '.') }} –
                                                Rp{{ number_format($produk->kisaran_harga_max, 0, ',', '.') }}/kg
                                            </h6>
                                            <button class="btn cart-btn">
                                                <i class="bi bi-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada produk yang tersedia.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openFilterBtn = document.getElementById('openFilterBtn');
            const filterModal = new bootstrap.Modal(document.getElementById('filterModal'));

            if (openFilterBtn) {
                openFilterBtn.addEventListener('click', () => {
                    filterModal.show();
                });
            }

            // Fungsi toggle kecamatan
            function setupToggle(btnId, itemSelector, visibleCount) {
                const toggleBtn = document.getElementById(btnId);
                const kecamatanItems = document.querySelectorAll(itemSelector);
                let expanded = false;

                if (toggleBtn) {
                    toggleBtn.addEventListener('click', () => {
                        expanded = !expanded;

                        if (expanded) {
                            kecamatanItems.forEach(item => item.style.display = 'block');
                            toggleBtn.innerHTML = 'Sembunyikan <i class="bi bi-chevron-up"></i>';
                        } else {
                            kecamatanItems.forEach((item, index) => {
                                item.style.display = index < visibleCount ? 'block' : 'none';
                            });
                            toggleBtn.innerHTML = 'Lihat lainnya <i class="bi bi-chevron-down"></i>';
                        }
                    });
                }
            }

            // Pastikan visibleCount dikirim ke JS dari PHP dengan benar
            const visibleCount = {{ $visibleCount ?? 5 }};

            setupToggle('toggleKecamatanBtnMobile', '#filterModal .kecamatan-item', visibleCount);
            setupToggle('toggleKecamatanBtnDesktop', '.col-lg-3 .kecamatan-item', visibleCount);

            // Validasi harga
            const form = document.querySelector('form');
            const priceMinInput = document.getElementById('price_min');
            const priceMaxInput = document.getElementById('price_max');

            form.addEventListener('submit', function(e) {
                let min = parseInt(priceMinInput.value) || 0;
                let max = parseInt(priceMaxInput.value) || 0;

                if (min > max && max !== 0) {
                    e.preventDefault();
                    alert('Harga minimum tidak boleh lebih besar dari harga maksimum.');
                    return;
                }
            });
        });
    </script>
@endsection
