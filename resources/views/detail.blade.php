@extends('layouts.app')

@section('title', 'Detail - SIBIKANDA')

<!-- Header Navbar -->
@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="container" >
        <div class="row justify-content-center">
            <!-- Product Images -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img id="mainImage"
                        src="https://images.unsplash.com/photo-1434056886845-dac89ffe9b56?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
                        class="img-thumbnail thumbnail-img" alt="Product-Image">

                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-3">
                                <img src="https://images.unsplash.com/photo-1434056886845-dac89ffe9b56?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
                                    class="img-thumbnail thumbnail-img" alt="Thumbnail 1">
                            </div>
                            <div class="col-3">
                                <img src="https://images.unsplash.com/photo-1495857000853-fe46c8aefc30?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
                                    class="img-thumbnail thumbnail-img" alt="Thumbnail 2">
                            </div>
                            <div class="col-3">
                                <img src="https://images.unsplash.com/photo-1451859757691-f318d641ab4d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
                                    class="img-thumbnail thumbnail-img" alt="Thumbnail 3">
                            </div>
                            <div class="col-3">
                                <img src="https://images.unsplash.com/photo-1490915785914-0af2806c22b6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
                                    class="img-thumbnail thumbnail-img" alt="Thumbnail 4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <h1 class="h4 mb-0">Udang Vaname Super Fresh</h1>
                <div class="mb-3">
                    {{-- <span class="text-dark fw-semibold">
                        Rp{{ number_format($product->kisaran_harga_min, 0, ',', '.') }} - Rp{{ number_format($product->kisaran_harga_max, 0, ',', '.') }}
                    </span> --}}
                    <span class="h6 text-dark fw-semibold">Rp70.000 – Rp75.000</span>
                    <span class="text-warning fw-semibold fs-6">/kg</span>
                </div>

                <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                    <div style="width: 110px;"><strong>Tanggal Tanam</strong> </div>
                    <div>: 12 Februari 2025</div>
                </div>
                <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                    <div style="width: 110px;"><strong>Kapasitas</strong> </div>
                    <div>: 500 ekor</div>
                </div>
                <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                    <div style="width: 110px;"><strong>Lokasi</strong> </div>
                    <div>: Desa Karangsong, Indramayu</div>
                </div>
                <div class="mb-4 d-flex" style="font-size: 0.85rem;">
                    <div style="width: 110px;"><strong>Ukuran</strong> </div>
                    <div>: 8-10 cm</div>
                </div>

                <!-- Actions -->
                <div class="d-grid gap-2">
                    <button class="btn btn-success" type="button">
                        <i class="fa-brands fa-whatsapp" style="padding-right: 10px;"></i>Hubungi via Whatsapp
                    </button>
                    <a href="{{ url('profile') }}" class="btn btn-outline-secondary" type="button">
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
