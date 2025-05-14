@extends('layouts.app')

@section('title', 'Detail - SIBIKANDA')

<!-- Header Navbar -->
@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <!-- Product Images -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    @php
                        $images = json_decode($produk->gambar, true);
                        $mainImage = $images[0] ?? 'https://via.placeholder.com/300';
                    @endphp
                    <img id="mainImage"
                        src="{{ filter_var($mainImage, FILTER_VALIDATE_URL) ? $mainImage : asset('storage/images/' . $mainImage) }}"
                        class="img-thumbnail thumbnail-img" alt="Product-Image">

                    <div class="card-body">
                        <div class="row g-2">
                            @foreach ($images as $img)
                                <div class="col-3">
                                    <img src="{{ filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('storage/images/' . $img) }}"
                                        class="img-thumbnail thumbnail-img" alt="Thumbnail">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <h1 class="h4 mb-0">{{ $produk->jenis_spesifik_komoditas ?? $produk->jenis_komoditas }}</h1>
                <div class="mb-3">
                    <span class="h6 text-dark fw-semibold">
                        Rp{{ number_format($produk->kisaran_harga_min, 0, ',', '.') }} – Rp{{ number_format($produk->kisaran_harga_max, 0, ',', '.') }}
                    </span>
                    <span class="text-warning fw-semibold fs-6">/kg</span>
                </div>

                <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                    <div style="width: 110px;"><strong>Tanggal Tanam</strong> </div>
                    <div>: {{ \Carbon\Carbon::parse($produk->created_at)->translatedFormat('d F Y') }}</div>
                </div>
                <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                    <div style="width: 110px;"><strong>Kapasitas</strong> </div>
                    <div>: {{ $produk->kapasitas_produksi ?? '-' }} kg</div>
                </div>
                <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                    <div style="width: 110px;"><strong>Lokasi</strong> </div>
                    <div>: {{ $produk->alamat_lengkap ?? '-' }}</div>
                </div>
                <div class="mb-4 d-flex" style="font-size: 0.85rem;">
                    <div style="width: 110px;"><strong>Ukuran</strong> </div>
                    <div>: {{ $produk->detail ?? '-' }}</div>
                </div>

                <!-- Actions -->
                <div class="d-grid gap-2">
                    @if ($produk->telepon)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $produk->telepon) }}" target="_blank" class="btn btn-success">
                            <i class="fa-brands fa-whatsapp" style="padding-right: 10px;"></i>Hubungi via Whatsapp
                        </a>
                    @else
                        <button class="btn btn-success" disabled>
                            <i class="fa-brands fa-whatsapp" style="padding-right: 10px;"></i>Nomor tidak tersedia
                        </button>
                    @endif
                    <a href="{{ route('usaha.detail', $produk->pembudidaya_id) }}" class="btn btn-outline-secondary">
                        <i class="fa-regular fa-user" style="padding-right: 15px;"></i>Profile Pembudidaya
                    </a>
                </div>

                <!-- Additional Info -->
                <div class="mt-3">
                    <div class="d-flex align-items-center mb-1">
                        <i class="fas fa-truck text-primary me-2"></i>
                        <span style="font-size: 0.775rem;">Gratis ongkos kirim untuk pesanan lebih dari 10 kg</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
