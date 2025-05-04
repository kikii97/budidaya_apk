@extends('layouts.app')

@section('title', 'Profile - SIBIKANDA')

<!-- Header Navbar -->
@section('header')
    @include('partials.header')
@endsection

<style>
</style>
@section('content')
    <section style="padding-top: 0px;">
        <div class="container py-2">
            <div class="row d-flex justify-content-center">
                <div class="col">

                    <div class="rounded-top text-white d-flex flex-row justify-content-between">
                        <!-- Profile Section (Image + Name + Location) -->
                        <div class="d-flex ms-4">
                            <div class="d-flex flex-column" style="width: 150px;">
                                <img src="{{ asset('apk_gis/public/images/akun.jpg') }}" alt="profile"
                                    class="img-fluid img-thumbnail mt-2 mb-2" style="width: 150px; z-index: 1">
                            </div>
                            <div class="d-flex flex-column justify-content-center ms-3" style="margin-top: 100px;">
                                <h5>Andy Horwitz</h5>
                                <p style="color:#005a8e;">New York</p>
                            </div>
                        </div>

                        <!-- Action Buttons (Edit Profile + Unggah Produk) -->
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" class="btn btn-outline-secondary
                            text-body">
                                Edit Profile
                            </button>
                            <button type="button" class="btn btn-outline-primary text-body">
                                Unggah Produk
                            </button>
                        </div>
                    </div>


                    <div class="mt-0 p-4 text-black" style="font-size: 50%;">

                        <div class="d-flex flex-row gap-3">

                            <!-- Recent Photos -->
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2 text-body">
                                    <p class="lead fw-normal mb-0">Produk Saya

                                    </p>
                                    <p class="mb-0">
                                        <a href="#!" class="text-muted" style="font-size: 12px;">Pilih Semua</a>
                                    </p>
                                </div>

                                <div class="d-flex overflow-auto gap-2">
                                    <!-- Photo Item -->
                                    <div class="position-relative mt-2 me-3" style="width: 100px;">
                                        <img src="{{ asset('apk_gis/public/images/rumputlaut.jpg') }}" alt="image 1"
                                            class="rounded-3 img-fluid" style="height: auto;">

                                        <!-- Tombol silang kecil di luar foto -->
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-1"
                                            aria-label="Close"
                                            style="font-size: 13px; background-color: rgba(0, 0, 0, 0.203); border-radius: 50%; border: 2px solid white; transform: translate(50%, -50%);"></button>

                                        <!-- Tombol Detail & Edit -->
                                        <div class="d-flex justify-content-center gap-1 mt-3">
                                            <button class="btn btn-sm btn-outline-primary"
                                                style="font-size: 12px;">Detail</button>
                                            <button class="btn btn-sm btn-outline-secondary"
                                                style="font-size: 12px;">Edit</button>
                                        </div>
                                    </div>


                                    <!-- Photo Item 2 -->
                                    <div class="position-relative mt-2 me-3" style="width: 100px;">
                                        <img src="{{ asset('apk_gis/public/images/udang.jpg') }}" alt="image 2"
                                            class="rounded-3 img-fluid" style="height: auto;">

                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-1"
                                            aria-label="Close"
                                            style="font-size: 13px; background-color:  rgba(0, 0, 0, 0.203); border-radius: 50%; border: 2px solid white; transform: translate(50%, -50%);"></button>

                                        <div class="d-flex justify-content-center gap-1 mt-3">
                                            <button class="btn btn-sm btn-outline-primary"
                                                style="font-size: 12px;">Detail</button>
                                            <button class="btn btn-sm btn-outline-secondary"
                                                style="font-size: 12px;">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>


@endsection
