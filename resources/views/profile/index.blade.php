@extends('layouts.app')

@section('title', 'Profile - SIBIKANDA')

<!-- Header Navbar -->
@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section style="padding-top: 0px;">
        <div class="container py-2" style="padding-top: 0rem !important;">
            <div class="row d-flex justify-content-center">
                <div class="col">

                    <!-- Profile Info -->
                    <div class="rounded-top text-white d-flex flex-wrap align-items-center justify-content-between p-3">
                        <div class="d-flex align-items-center" style="gap: 15px;">
                            <div style="width: 120px;">
                                <img src="{{ asset('images/akun.jpg') }}" alt="profile"
                                    class="img-fluid img-thumbnail rounded-circle" style="width: 100px; z-index: 1;">
                            </div>
                            <div>
                                <h5 class="mb-1 text-dark">{{ Auth::user()->name }}</h5>
                                <p class="mb-0" style="color:#005a8e;">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-2 mt-md-0">
                            <a href="{{ route('profile.settings') }}" class="btn btn-outline-secondary text-body">
                                Edit Profile
                            </a>
                        </div>
                    </div>

                    <!-- About Me Section -->
                    <div class="mt-4 p-4 text-black" style="font-size: 16px;">
                        <h5 class="text-dark mb-3">Tentang Saya</h5>

                        <!-- Alamat -->
                        <p style="font-size: 14px;">
                            <strong>Alamat:</strong> {{ Auth::user()->alamat ? Auth::user()->alamat : '-' }}
                        </p>

                        <!-- Jenis Usaha -->
                        <p style="font-size: 14px;">
                            <strong>Jenis Usaha:</strong> {{ Auth::user()->jenis_usaha ? Auth::user()->jenis_usaha : '-' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
