@extends('layouts.app')

@section('title', 'Katalog - SIBIKANDA')

<!-- Header Navbar -->
@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="container" style="padding-top: 0rem; padding-bottom: 0rem; font-size: 0.7rem;">
        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Produk Budidaya</h4>
            <div class="d-flex gap-2 align-items-center">
                <span class="text-muted">Sort by:</span>
                <button class="sort-btn">
                    Terbaru <i class="bi bi-chevron-down ms-2"></i>
                </button>
            </div>
        </div>

        <div class="row g-4">
            <!-- Filters Sidebar -->
            <div class="col-lg-3" style="line-height: 0.5;">

                <div class="filter-sidebar p-4 shadow-sm">
                    <div class="filter-group">
                        <h6 class="mb-3">Jenis Komoditas</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="electronics">
                            <label class="mt-1 ps-2 form-check-label" for="udang">
                                Udang
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="clothing">
                            <label class="mt-1 ps-2 form-check-label" for="rumput-laut">
                                Rumput Laut
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="accessories">
                            <label class="mt-1 ps-2 form-check-label" for="ikan-bandeng">
                                Ikan Bandeng
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="accessories">
                            <label class="mt-1 ps-2 form-check-label" for="ikan-gurame">
                                Ikan Gurame
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="accessories">
                            <label class="mt-1 ps-2 form-check-label" for="ikan-lele">
                                Ikan Lele
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="accessories">
                            <label class="mt-1 ps-2 form-check-label" for="ikan-nila">
                                Ikan Nila
                            </label>
                        </div>
                    </div>

                    <div class="filter-group">
                        <h6 class="mb-3">Price Range</h6>
                        <input type="range" class="form-range" min="0" max="1000" value="500">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">$0</span>
                            <span class="text-muted">$1000</span>
                        </div>
                    </div>
                    <button class="btn btn-outline-primary w-100">Apply Filters</button>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9" style="font-size: 0.7rem; line-height: 0.5;">
                <div class="row g-4">
                    @forelse ($produkList as $produk)
                    <div class="col-md-4">
                        <a href="{{ route('produk.detail', $produk->id) }}">
                            <div class="product-card shadow-sm">
                                <div class="position-relative">
                                    @php
                                        $gambar = json_decode($produk->gambar, true);
                                        $gambarUtama = $gambar[0] ?? 'default.jpg';
                                    @endphp
                                    <img src="{{ asset('storage/images/' . $gambarUtama) }}" class="product-image w-100" alt="Product">
                                </div>
                                <div class="p-3">
                                    <span class="category-badge mb-2 d-inline-block">{{ $produk->jenis_komoditas }}</span>
                                    <h6 class="mb-1">{{ $produk->jenis_spesifik_komoditas ?? '-' }}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="price text-dark fw-semibold">
                                            Rp{{ number_format($produk->kisaran_harga_min, 0, ',', '.') }} – 
                                            Rp{{ number_format($produk->kisaran_harga_max, 0, ',', '.') }}/kg
                                        </span>
                                        <button class="btn cart-btn">
                                            <i class="bi bi-heart"></i>
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
@endsection
