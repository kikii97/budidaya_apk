@extends('layouts.app')

@section('title', 'Detail - SIBIKANDA')

<!-- Header Navbar -->
@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="container" style="padding-top: 5rem; padding-bottom: 7rem;">
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6 mb-4">
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
                <h1 class="h2 mb-3">Whole Wheat Sandwich Bread</h1>
                <div class="mb-3">
                    <span class="h4 me-2">$18.00</span>
                    <span class="text-muted text-decoration-line-through">$24.00</span>
                    <span class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                        OFF</span>
                </div>

                <p class="mb-4">Timeless elegance meets modern functionality in this classic timepiece. Features
                    premium
                    materials, water resistance, and sophisticated design.</p>

                <!-- Color Selection -->
                <div class="mb-4">
                    <h6 class="mb-2">Ukuran</h6>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="uk" id="kecil" checked>
                        <label class="btn btn-outline-secondary" for="kecil">Kecil</label>
                        <input type="radio" class="btn-check" name="uk" id="sedang">
                        <label class="btn btn-outline-secondary" for="sedang">Sedang</label>
                        <input type="radio" class="btn-check" name="uk" id="besar">
                        <label class="btn btn-outline-secondary" for="besar">Besar</label>
                    </div>
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
                <div class="mt-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-truck text-primary me-2"></i>
                        <span>Free shipping on orders over $50</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-undo text-primary me-2"></i>
                        <span>30-day return policy</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
