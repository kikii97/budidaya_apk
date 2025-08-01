<!DOCTYPE html>
<html lang="en">

@php
    $user = Auth::guard('web')->user();
    $pembudidaya = Auth::guard('pembudidaya')->user();
    $authenticatedUser = $pembudidaya ?? $user;
@endphp

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIBIKANDA</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <link href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
</head>

<style>
    body,
    input,
    textarea,
    button {
        font-family: 'Inter', sans-serif;
    }

    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    #peta {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 1rem;
        height: 500px;
        overflow: hidden;
    }

    #map {
        width: 90%;
        height: 100%;
    }
    .notification-item {
    padding: 10px;
    border: 1px solid #eee;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.notification-item:hover {
    background-color: #f0f0f0;
}

    .required {
        color: #dc3545;
        font-weight: bold;
        margin-left: 0.2rem;
        font-size: 1.2rem;
    }
</style>

<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="80" tabindex="0">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <defs>
            <symbol xmlns="http://www.w3.org/2000/svg" id="facebook" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M15.12 5.32H17V2.14A26.11 26.11 0 0 0 14.26 2c-2.72 0-4.58 1.66-4.58 4.7v2.62H6.61v3.56h3.07V22h3.68v-9.12h3.06l.46-3.56h-3.52V7.05c0-1.05.28-1.73 1.76-1.73Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="twitter" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M22.991 3.95a1 1 0 0 0-1.51-.86a7.48 7.48 0 0 1-1.874.794a5.152 5.152 0 0 0-3.374-1.242a5.232 5.232 0 0 0-5.223 5.063a11.032 11.032 0 0 1-6.814-3.924a1.012 1.012 0 0 0-.857-.365a.999.999 0 0 0-.785.5a5.276 5.276 0 0 0-.242 4.769l-.002.001a1.041 1.041 0 0 0-.496.89a3.042 3.042 0 0 0 .027.439a5.185 5.185 0 0 0 1.568 3.312a.998.998 0 0 0-.066.77a5.204 5.204 0 0 0 2.362 2.922a7.465 7.465 0 0 1-3.59.448A1 1 0 0 0 1.45 19.3a12.942 12.942 0 0 0 7.01 2.061a12.788 12.788 0 0 0 12.465-9.363a12.822 12.822 0 0 0 .535-3.646l-.001-.2a5.77 5.77 0 0 0 1.532-4.202Zm-3.306 3.212a.995.995 0 0 0-.234.702c.01.165.009.331.009.488a10.824 10.824 0 0 1-.454 3.08a10.685 10.685 0 0 1-10.546 7.93a10.938 10.938 0 0 1-2.55-.301a9.48 9.48 0 0 0 2.942-1.564a1 1 0 0 0-.602-1.786a3.208 3.208 0 0 1-2.214-.935q.224-.042.445-.105a1 1 0 0 0-.08-1.943a3.198 3.198 0 0 1-2.25-1.726a5.3 5.3 0 0 0 .545.046a1.02 1.02 0 0 0 .984-.696a1 1 0 0 0-.4-1.137a3.196 3.196 0 0 1-1.425-2.673c0-.066.002-.133.006-.198a13.014 13.014 0 0 0 8.21 3.48a1.02 1.02 0 0 0 .817-.36a1 1 0 0 0 .206-.867a3.157 3.157 0 0 1-.087-.729a3.23 3.23 0 0 1 3.226-3.226a3.184 3.184 0 0 1 2.345 1.02a.993.993 0 0 0 .921.298a9.27 9.27 0 0 0 1.212-.322a6.681 6.681 0 0 1-1.026 1.524Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="youtube" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M23 9.71a8.5 8.5 0 0 0-.91-4.13a2.92 2.92 0 0 0-1.72-1A78.36 78.36 0 0 0 12 4.27a78.45 78.45 0 0 0-8.34.3a2.87 2.87 0 0 0-1.46.74c-.9.83-1 2.25-1.1 3.45a48.29 48.29 0 0 0 0 6.48a9.55 9.55 0 0 0 .3 2a3.14 3.14 0 0 0 .71 1.36a2.86 2.86 0 0 0 1.49.78a45.18 45.18 0 0 0 6.5.33c3.5.05 6.57 0 10.2-.28a2.88 2.88 0 0 0 1.53-.78a2.49 2.49 0 0 0 .61-1a10.58 10.58 0 0 0 .52-3.4c.04-.56.04-3.94.04-4.54ZM9.74 14.85V8.66l5.92 3.11c-1.66.92-3.85 1.96-5.92 3.08Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="instagram" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 2.43-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0 1 1 15.33 12A3.33 3.33 0 0 1 12 15.33Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="menu" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M2 6a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1m0 6.032a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1m1 5.033a1 1 0 1 0 0 2h18a1 1 0 0 0 0-2z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="arrow-right" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="detail" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
            </symbol>

            <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24">
                <g fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="9" r="3" />
                    <circle cx="12" cy="12" r="10" />
                    <path stroke-linecap="round" d="M17.97 20c-.16-2.892-1.045-5-5.97-5s-5.81 2.108-5.97 5" />
                </g>
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="detail" viewBox="0 0 24 24">
                <g fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M1 12C2.7 7.6 6.9 4.5 12 4.5C17.1 4.5 21.3 7.6 23 12C21.3 16.4 17.1 19.5 12 19.5C6.9 19.5 2.7 16.4 1 12Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </g>
            </symbol>

        </defs>
    </svg>

    <div class="preloader-wrapper">
        <div class="preloader">
        </div>
    </div>
    @php
        $user = Auth::user() ?? Auth::guard('pembudidaya')->user();
    @endphp

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">
        <a class="logo d-flex align-items-center me-auto me-xl-0" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </a>

        <nav id="navmenu" class="navmenu d-flex align-items-center gap-2">
            <ul class="d-none d-xl-flex">
                <li><a href="{{ url('/') }}">Beranda</a></li>
                <li><a href="{{ url('/#komoditas') }}">Komoditas</a></li>
                <li><a href="{{ url('/#budidaya') }}">Budidaya</a></li>
                <li><a href="{{ url('/#peta') }}">Peta Budidaya</a></li>
                <li><a href="#kami">Tentang Kami</a></li>
            </ul>

            @if ($authenticatedUser)
                <!-- Tombol Notifikasi Mobile -->
                <button id="btnNotifMobile" type="button" class="btn btn-outline-secondary position-relative d-xl-none" data-bs-toggle="offcanvas" data-bs-target="#notificationModal" aria-controls="notificationModal">
                    🔔
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $authenticatedUser->unreadNotifications->count() ?? 0 }}
                        <span class="visually-hidden">notifikasi baru</span>
                    </span>
                </button>
            @endif

            <!-- Tombol Hamburger Menu -->
            <i id="btnHamburger" class="mobile-nav-toggle d-xl-none bi bi-list" data-bs-toggle="offcanvas" data-bs-target="#mobileNav"></i>
        </nav>

        <div class="d-none d-xl-flex align-items-center gap-2 ms-3">
            @if ($authenticatedUser)
                <!-- Tombol Notifikasi Desktop -->
                <button type="button" class="btn btn-outline-secondary position-relative" data-bs-toggle="offcanvas" data-bs-target="#notificationModal" aria-controls="notificationModal">
                    🔔
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $authenticatedUser->unreadNotifications->count() ?? 0 }}
                        <span class="visually-hidden">notifikasi baru</span>
                    </span>
                </button>
            @endif

            @if ($pembudidaya || $user)
                <!-- Dropdown User -->
                <div class="dropdown position-relative">
                    <a class="btn btn-primary rounded-pill px-4 py-2 dropdown-toggle" href="#" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $pembudidaya?->name ?? $user?->name ?? 'User' }}
                    </a>
                    <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 small-dropdown" aria-labelledby="accountDropdown">
                        @if($pembudidaya)
                            <li>
                                <a class="dropdown-item py-1 px-3 small" href="{{ route('pembudidaya.detail_usaha', ['id' => $pembudidaya->id ?? 0]) }}">
                                    Detail Usaha
                                </a>
                            </li>
                        @endif
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item py-1 px-3 small" type="submit">🚪 Log Out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <!-- Dropdown Login untuk Desktop -->
                <div class="dropdown position-relative">
                    <a class="btn btn-primary rounded-pill px-4 py-2 dropdown-toggle" href="#" id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Log In
                    </a>
                    <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 small-dropdown" aria-labelledby="loginDropdown">
                        <li><a class="dropdown-item py-1 px-3 small" href="{{ url('login') }}">Log In</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item py-1 px-3 small" href="{{ url('login?form=register&tipe=investor') }}">📝 Gabung Investor</a></li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</header>

<!-- Offcanvas Notifikasi -->
<div class="offcanvas offcanvas-end" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true" style="max-width: 90vw;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="notificationModalLabel">Notifikasi</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <!-- Tombol Aksi -->
        <div class="mb-3 d-flex justify-content-between">
            <form action="{{ route('notifications.markAllRead') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary px-2 py-1" style="font-size: 0.8rem;">✓ Tandai Semua Dibaca</button>
            </form>
            <form action="{{ route('notifications.clearAll') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1" style="font-size: 0.8rem;">🗑️ Hapus Semua</button>
            </form>
        </div>

        @if ($authenticatedUser && $authenticatedUser->notifications->count())
            <!-- Daftar Ringkas -->
            <ul class="list-group mb-3" id="notificationList">
                @foreach ($authenticatedUser->notifications as $notification)
                    <li class="list-group-item notification-item {{ is_null($notification->read_at) ? 'fw-bold' : 'text-muted' }}" data-id="{{ $notification->id }}" style="cursor: pointer;">
                        📩 {{ $notification->data['judul'] ?? 'Notifikasi' }}
                        <br>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">Tidak ada notifikasi baru.</p>
        @endif

        <!-- Detail Notifikasi (selalu tampil di DOM) -->
        <template id="notificationDetailTemplate">
            <div class="card notification-detail">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold detail-title">Detail Notifikasi</h6>
                        <button type="button" class="btn-close btn-sm btn-close-detail" aria-label="Tutup"></button>
                    </div>
                    <div class="detail-content small text-muted"></div>
                </div>
            </div>
        </template>
    </div>
</div>
    <!-- Mobile Menu (Offcanvas) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileNav" aria-labelledby="mobileNavLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileNavLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            <li><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
            <li><a class="nav-link" href="{{ url('/#komoditas') }}">Komoditas</a></li>
            <li><a class="nav-link" href="{{ url('/#budidaya') }}">Budidaya</a></li>
            <li><a class="nav-link" href="{{ url('/#peta') }}">Peta Budidaya</a></li>
            <li><a class="nav-link" href="#kami">Tentang Kami</a></li>

            @if ($user || $pembudidaya)
                @if($pembudidaya)
                    <li><a class="nav-link" href="{{ route('pembudidaya.detail_usaha', ['id' => $pembudidaya->id ?? 0]) }}">Detail Usaha</a></li>
                @endif
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item py-2" type="submit">🚪 Log Out</button>
                    </form>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="mobileLoginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Log In
                    </a>
                    <ul class="dropdown-menu border-0 shadow-sm w-100 mt-0 rounded-0" aria-labelledby="mobileLoginDropdown">
                        <li><a class="dropdown-item py-2" href="{{ url('login') }}">Log In</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2" href="{{ url('login?form=register&tipe=investor') }}">📝 Gabung Investor</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileNav" aria-labelledby="mobileNavLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileNavLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li><a class="nav-link" href="#beranda">Beranda</a></li>
                <li><a class="nav-link" href="#komoditas">Komoditas</a></li>
                <li><a class="nav-link" href="#budidaya">Budidaya</a></li>
                <li><a class="nav-link" href="#peta">Peta Budidaya</a></li>
                <li><a class="nav-link" href="#kami">Tentang Kami</a></li>

                <!-- Log In dropdown di mobile -->
                @if (Auth::check() || Auth::guard('pembudidaya')->check())
                    @if (Auth::guard('pembudidaya')->check())
                        <li><a class="nav-link" href="{{ route('pembudidaya.detail_usaha') }}">Account Settings</a>
                        </li>
                    @endif
                    <li>
                        <form action="{{ url('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item py-2" type="submit">🚪 Log Out</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="mobileLoginDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Log In
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm w-100 mt-0 rounded-0"
                            aria-labelledby="mobileLoginDropdown">
                            <li><a class="dropdown-item py-2" href="{{ url('login') }}">Log In</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item py-2"
                                    href="{{ url('login?form=register&tipe=investor') }}">📝Gabung Investor</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <section id="beranda"
        style="background-image: url('{{ asset('images/tambak-ikan.jpg') }}');background-repeat: no-repeat;background-size: cover;">
        <div class="container-lg mt-3">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="display-1 ls-1">
                        <span class="fw-bold text-primary">Inkubator</span>
                        Bisnis
                        <span class="fw-bold">Perikanan</span>
                    </h2>
                    <p class="fs-5">Temukan informasi lengkap tentang budidaya ikan unggulan di Indramayu.</p>
                    <div class="d-flex gap-3 mt-3">
                        @if (Auth::check() && Auth::user()->role == 'user')
                            <button class="btn btn-primary text-uppercase fs-6 rounded-pill px-4 py-3 mt-3"
                                data-bs-toggle="modal" data-bs-target="#modalCari">Form Rekomendasi</button>
                        @else
                            <a href="{{ url('login') }}"
                                class="btn btn-dark text-uppercase fs-6 rounded-pill px-4 py-3 mt-3">Gabung
                                Investor</a>
                        @endif
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalCari" tabindex="-1" aria-labelledby="modalCariLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 500px;">
                            <div class="modal-content" style="border-radius: 1rem;">
                                <div class="modal-header py-2">
                                    <h5 class="modal-title" id="modalCariLabel" style="font-weight: 500;">Form
                                        Rekomendasi</h5>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form class="modal-body p-3 pb-0" method="GET" action="{{ route('home') }}"
                                    style="font-size: 0.8rem; padding: 15px;">

                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <label class="form-label mb-1">Jenis Komoditas <span class="required">*</span></label>
                                            <select class="form-select form-select-sm rounded-2"
                                                name="jenis_komoditas">
                                                <option value="">-- Pilih Komoditas --</option>
                                                <option>Udang</option>
                                                <option>Rumput Laut</option>
                                                <option>Ikan Bandeng</option>
                                                <option>Ikan Gurame</option>
                                                <option>Ikan Lele</option>
                                                <option>Ikan Nila</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <label class="form-label mb-1">Harga (Rp) <span class="required">*</span></label>
                                        <div class="col-6 mb-1">
                                            <input type="number" class="form-control form-control-sm rounded-2"
                                                name="harga_min" placeholder="min" step="500" min="500">
                                        </div>
                                        <div class="col-6 mb-1">
                                            <input type="number" class="form-control form-control-sm rounded-2"
                                                name="harga_max" placeholder="max" step="500" min="500">
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <label class="form-label mb-1">Kapasitas Produksi (kg/bulan) <span class="required">*</span></label>
                                            <input type="number" class="form-control form-control-sm rounded-2"
                                                name="kapasitas" placeholder="Cth: 1000">
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <label class="form-label mb-1">Kecamatan <span class="required">*</span></label>
                                            <select class="form-select form-select-sm rounded-2" name="kecamatan">
                                                <option value="">-- Pilih Kecamatan --</option>
                                                <option>Anjatan</option>
                                                <option>Arahan</option>
                                                <option>Balongan</option>
                                                <option>Bangodua</option>
                                                <option>Bongas</option>
                                                <option>Cantigi</option>
                                                <option>Cikedung</option>
                                                <option>Gabuswetan</option>
                                                <option>Gantar</option>
                                                <option>Haurgeulis</option>
                                                <option>Indramayu</option>
                                                <option>Jatibarang</option>
                                                <option>Juntinyuat</option>
                                                <option>Kandanghaur</option>
                                                <option>Karangampel</option>
                                                <option>Kedokan Bunder</option>
                                                <option>Kertasemaya</option>
                                                <option>Krangkeng</option>
                                                <option>Kroya</option>
                                                <option>Lelea</option>
                                                <option>Lohbener</option>
                                                <option>Losarang</option>
                                                <option>Pasekan</option>
                                                <option>Patrol</option>
                                                <option>Sindang</option>
                                                <option>Sliyeg</option>
                                                <option>Sukagumiwang</option>
                                                <option>Sukra</option>
                                                <option>Terisi</option>
                                                <option>Tukdana</option>
                                                <option>Widasari</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label mb-1">Prediksi Panen <span class="required">*</span></label>
                                            <input type="date" class="form-control form-control-sm rounded-2"
                                                name="prediksi_panen">
                                        </div>
                                    </div>

                                    <div class="modal-footer py-2">
                                        <button type="submit"
                                            class="btn btn-primary btn-sm rounded-pill px-3">Cari</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <svg class="hero-waves mt-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 24 150 28"
            preserveAspectRatio="none">
            <defs>
                <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
                </path>
            </defs>
            <g class="wave1">
                <use xlink:href="#wave-path" x="50" y="10" fill="white"></use>
            </g>
            <g class="wave2">
                <use xlink:href="#wave-path" x="50" y="9" fill="white" opacity="0.7"></use>
            </g>
            <g class="wave3">
                <use xlink:href="#wave-path" x="50" y="8" fill="white" opacity="0.3"></use>
            </g>
        </svg>

    </section>

    <section id="komoditas" class="overflow-hidden">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap justify-content-between">
                        <h2 class="section-title">Komoditas Unggulan</h2>

                        <div class="d-flex align-items-center">
                            <div class="swiper-buttons">
                                <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                                <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            <a href="{{ route('katalog', ['jenis_komoditas' => ['Udang']]) }}"
                                class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/udang.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Udang</h4>
                            </a>
                            <a href="{{ route('katalog', ['jenis_komoditas' => ['Rumput Laut']]) }}"
                                class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/rumputlaut.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Rumput Laut</h4>
                            </a>
                            <a href="{{ route('katalog', ['jenis_komoditas' => ['Ikan Bandeng']]) }}"
                                class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/ikanbandeng.jpg') }}"
                                    class="rounded-circle" alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Ikan Bandeng</h4>
                            </a>
                            <a href="{{ route('katalog', ['jenis_komoditas' => ['Ikan Gurame']]) }}"
                                class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/ikangurame.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Ikan Gurame</h4>
                            </a>
                            <a href="{{ route('katalog', ['jenis_komoditas' => ['Ikan Lele']]) }}"
                                class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/ikanlele.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Ikan Lele</h4>
                            </a>
                            <a href="{{ route('katalog', ['jenis_komoditas' => ['Ikan Nila']]) }}"
                                class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/ikannila.jpeg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Ikan Nila</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section id="budidaya" style="padding-bottom: 3.5rem;">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex justify-content-between align-items-center flex-wrap gap-2"
                    style="row-gap: 0.5rem;">
                    <h2 class="section-title m-0 fs-4">Etalase Produk Budidaya</h2>
                    <div class="d-flex align-items-center">
                        <a href="{{ url('katalog') }}" class="btn btn-primary rounded-1">View All</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="zoom: 90%">
                <div
                    class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                    @foreach ($recommendedProducts as $index => $product)
                        <div class="col-6 col-md-4">
                            <div class="product-item">
                                <figure>
                                    <a href="{{ route('produk.detail', $product->id) }}"
                                       title="{{ $product->nama }}">
                                        @php
                                            $gambarList = json_decode($product->gambar, true);
                                            $thumbnail = $gambarList[0] ?? 'default.jpg';
                                        @endphp
                                        <img src="{{ asset('storage/images/' . $thumbnail) }}"
                                             alt="Thumbnail {{ $product->nama }}" class="tab-image"
                                             style="width: 100%; height: 180px; object-fit: contain; border-radius: 6px; background: #f0f0f0;">
                                    </a>
                                </figure>

                                {{-- Menampilkan Nilai & Nomor Urut jika hasil dari form rekomendasi dan produk memiliki bobot --}}
                                @if (!empty($filters) && isset($product->bobot))
                                    <div class="d-flex justify-content-center mb-2">
                                        <div class="px-3 py-1 border border-primary rounded-pill bg-light text-dark shadow-sm"
                                             style="font-size: 0.75rem;">
                                            <strong>Nilai:</strong> {{ number_format($product->bobot, 4) }}
                                            <span class="mx-1">|</span>
                                            <strong>No:</strong> {{ $index + 1 }}
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">{{ $product->nama }}</h3>
                                    <div class="mb-1">
                                        <div class="fw-semibold fs-6">
                                            {{ $product->jenis_komoditas ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <span class="fw-semibold text-dark fs-6 m-0 p-0">
                                            Rp{{ number_format($product->kisaran_harga_min, 0, ',', '.') }} –
                                            Rp{{ number_format($product->kisaran_harga_max, 0, ',', '.') }}
                                        </span>
                                        <span class="text-warning fw-semibold fs-6">/kg</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2 d-flex justify-content-center">
                                            <div class="col-7">
                                                <a href="{{ route('produk.detail', $product->id) }}"
                                                   class="btn btn-primary rounded-1 p-2 fs-7 btn-cart">
                                                    <svg width="18" height="18">
                                                        <use xlink:href="#detail"></use>
                                                    </svg> Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

    <section id="peta" class="py-5"
        style="display: flex; justify-content: center; align-items: center; padding-top: 1rem !important;">
        <div id="map" style="position: relative; width: 90%; height: 500px;">

            <!-- Filter Komoditas -->
            <div id="filter-komoditas"
                style="font-size: 12px; position: absolute; top: 25px; right: 10px; z-index: 10; background: #fff; padding: 12px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.3); max-width: 220px;">
                <strong style="font-size: 14px;">Filter Komoditas:</strong>
                <div class="row mt-2">
                    <div>
                        <label><input type="checkbox" id="select-all" checked> Pilih Semua</label>
                    </div>
                    <div class="col-6" style="font-size: 10.5px;">
                        <label><input type="checkbox" class="komoditas-filter" value="udang" checked>
                            Udang</label><br>
                        <label><input type="checkbox" class="komoditas-filter" value="rumput laut" checked> Rumput
                            Laut</label><br>
                        <label><input type="checkbox" class="komoditas-filter" value="ikan bandeng" checked>
                            Bandeng</label><br>
                    </div>
                    <div class="col-6" style="font-size: 10.5px;">
                        <label><input type="checkbox" class="komoditas-filter" value="ikan gurame" checked>
                            Gurame</label><br>
                        <label><input type="checkbox" class="komoditas-filter" value="ikan lele" checked>
                            Lele</label><br>
                        <label><input type="checkbox" class="komoditas-filter" value="ikan nila" checked>
                            Nila</label><br>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Map section -->

    <footer id="kami"
        style="background: linear-gradient(to top, #d3effa, #ffffff); font-size: 13px; line-height: 1.6; color: #333; padding-top: 3rem;">
        <!-- Pembatas -->
        <div style="border-top: 1px solid #bde5f4; margin-bottom: 20px;"></div>

        <div class="container-lg">
            <div class="row">

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="d-flex gap-2 mt-2">
                        <a href="https://www.facebook.com/diskanla.indramayu/?locale=id_ID"
                            class="btn btn-outline-primary btn-sm rounded-circle">
                            <svg width="14" height="14">
                                <use xlink:href="#facebook"></use>
                            </svg>
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
                            <svg width="14" height="14">
                                <use xlink:href="#twitter"></use>
                            </svg>
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
                            <svg width="14" height="14">
                                <use xlink:href="#youtube"></use>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/diskanla.indramayu/"
                            class="btn btn-outline-primary btn-sm rounded-circle">
                            <svg width="14" height="14">
                                <use xlink:href="#instagram"></use>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <h6 class="fw-bold mb-2 text-dark">Tentang Kami</h6>
                    <p class="text-muted mb-1">
                        Sistem Inkubasi Bisnis Ikan Daerah Indramayu yang menyediakan info komoditas unggulan dan
                        menghubungkan pembudidaya dengan mitra bisnis.
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <h6 class="fw-bold mb-2 text-dark">Waktu Buka</h6>
                    <ul class="list-unstyled text-muted mb-1">
                        <li>Senin - Jumat: 08.00 - 16.00</li>
                        <li>Sabtu - Minggu: Tutup</li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <h6 class="fw-bold mb-2 text-dark">Lokasi Perusahaan</h6>
                    <p class="text-muted mb-1">Jl. Raya Pabean Udik No.1, Pabeanudik, Kec. Indramayu, Kabupaten
                        Indramayu, Jawa Barat 45219.</p>
                    <a href="https://www.google.com/maps/place/Dinas+Perikanan+dan+Kelautan+Pemerintah+Kabupaten+Indramayu/@-6.3179702,108.3246886,17z/data=!4m6!3m5!1s0x2e6ebc7575d24923:0x3e8a1e67a14c823c!8m2!3d-6.3179702!4d108.3272635!16s%2Fg%2F11bc7p2yjc?entry=ttu&g_ep=EgoyMDI1MDQyOS4wIKXMDSoJLDEwMjExNDU1SAFQAw%3D%3D"target="_blank"
                        class="text-decoration-none text-primary fw-semibold">
                        📍 Lihat di Google Maps
                    </a>
                </div>

            </div>
        </div>

        <div class="text-center py-2 mt-2" style="background-color: #c6eaf7;">
            <small class="text-muted">© 2025 SIBIKANDA. All rights reserved.</small>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('#navmenu a');

            let scrollPos = window.scrollY + 200;

            sections.forEach(section => {
                if (scrollPos >= section.offsetTop && scrollPos < section.offsetTop + section
                    .offsetHeight) {
                    navLinks.forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === '#' + section.id) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[name="harga_min"], input[name="harga_max"]');
            inputs.forEach(input => {
            input.addEventListener('input', function() {
            let value = parseInt(this.value) || 0;
                if (value < 500) {
                    this.value = 500; // Set minimum to 500
                    }    else {
                    // Round to nearest multiple of 500
                    this.value = Math.round(value / 500) * 500;
                    }
                });
            });
        });
    </script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const notificationItems = document.querySelectorAll('.notification-item');
    const detailTemplate = document.getElementById('notificationDetailTemplate');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const markAllReadForm = document.querySelector('form[action$="mark-all-read"]');
    const clearAllForm = document.querySelector('form[action$="clear"]');

    let currentDetailElement = null;

    // Handle klik notifikasi untuk menampilkan detail
    notificationItems.forEach(item => {
        item.addEventListener('click', () => {
            const notifId = item.getAttribute('data-id');

            if (!notifId) {
                console.error('Notification ID is missing');
                alert('ID notifikasi tidak ditemukan.');
                return;
            }

            fetch(`/notifications/${notifId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! Status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log('Fetched notification data:', data);

                if (currentDetailElement) {
                    currentDetailElement.remove();
                    currentDetailElement = null;
                }

                const clone = detailTemplate.content.cloneNode(true);
                const detailCard = clone.querySelector('.notification-detail');
                const detailTitle = clone.querySelector('.detail-title');
                const detailContent = clone.querySelector('.detail-content');
                const closeBtn = clone.querySelector('.btn-close-detail');

                detailTitle.textContent = data.judul || 'Detail Notifikasi';

                let html = `
                    ${data.message ? `<p>${data.message}</p>` : ''}
                    ${data.no_hp ? `<p><strong>No. HP:</strong> ${data.no_hp}</p>` : ''}
                    ${data.tanggal_order ? `<p><strong>Tanggal Order:</strong> ${data.tanggal_order}</p>` : ''}
                    ${data.jumlah ? `<p><strong>Jumlah Dipesan:</strong> ${data.jumlah}</p>` : ''}
                    ${data.catatan ? `<p><strong>Catatan:</strong> ${data.catatan}</p>` : ''}
                    ${data.jenis_produk ? `<p><strong>Jenis Produk:</strong> ${data.jenis_produk}</p>` : ''}
                    ${data.kapasitas ? `<p><strong>Kapasitas Produksi:</strong> ${data.kapasitas}</p>` : ''}
                    ${data.prediksi_panen ? `<p><strong>Prediksi Panen:</strong> ${data.prediksi_panen}</p>` : ''}
                    ${data.tanggal_diunggah ? `<p><strong>Tanggal Diunggah:</strong> ${data.tanggal_diunggah}</p>` : ''}
                    ${data.tanggal_disetujui ? `<p><strong>Tanggal Disetujui:</strong> ${data.tanggal_disetujui}</p>` : ''}
                `;

                // Tambahkan tombol aksi berdasarkan guard
                @if ($pembudidaya)
                    if (data.order_id && data.judul && data.judul.toLowerCase().includes('pesanan baru')) {
                        html += `
                            <div class="mt-4 d-flex justify-content-end gap-2 flex-wrap">
                                <form action="/order/konfirmasi/${data.order_id}" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <button type="submit" class="btn btn-sm btn-success d-flex align-items-center gap-1">
                                        ✅ <span>Konfirmasi Pesanan</span>
                                    </button>
                                </form>
                                ${data.export_url ? `
                                <a href="${data.export_url}" target="_blank" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                    ⬇️ <span>Download PDF</span>
                                </a>` : ''}
                            </div>
                        `;
                    } else if (data.export_url) {
                        html += `
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="${data.export_url}" target="_blank" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                    ⬇️ <span>Download PDF</span>
                                </a>
                            </div>
                        `;
                    }
                @else
                    if (data.export_url) {
                        html += `
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="${data.export_url}" target="_blank" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                    ⬇️ <span>Download PDF</span>
                                </a>
                            </div>
                        `;
                    }
                @endif

                detailContent.innerHTML = html;

                item.classList.remove('fw-bold');
                item.classList.add('text-muted');

                item.insertAdjacentElement('afterend', detailCard);
                currentDetailElement = detailCard;

                closeBtn.addEventListener('click', () => {
                    detailCard.remove();
                    currentDetailElement = null;
                });
            })
            .catch(error => {
                console.error('Error fetching notification:', error);
                if (currentDetailElement) {
                    currentDetailElement.querySelector('.detail-content').innerHTML = '<p class="text-danger">Gagal memuat detail notifikasi. Silakan coba lagi.</p>';
                } else {
                    const clone = detailTemplate.content.cloneNode(true);
                    const detailCard = clone.querySelector('.notification-detail');
                    const detailContent = clone.querySelector('.detail-content');
                    detailContent.innerHTML = '<p class="text-danger">Gagal memuat detail notifikasi. Silakan coba lagi.</p>';
                    item.insertAdjacentElement('afterend', detailCard);
                    currentDetailElement = detailCard;

                    const closeBtn = clone.querySelector('.btn-close-detail');
                    closeBtn.addEventListener('click', () => {
                        detailCard.remove();
                        currentDetailElement = null;
                    });
                }
            });
        });
    });

    // Handle "Tandai Semua Dibaca" dengan AJAX
    if (markAllReadForm) {
        markAllReadForm.addEventListener('submit', (e) => {
            e.preventDefault();
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! Status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log('Mark all read response:', data);
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.classList.remove('fw-bold');
                    item.classList.add('text-muted');
                });
                document.querySelectorAll('.badge.bg-danger').forEach(badge => {
                    badge.textContent = '0';
                });
                alert(data.message || 'Semua notifikasi telah ditandai sebagai dibaca.');
            })
            .catch(error => {
                console.error('Error marking all notifications as read:', error);
                alert('Gagal menandai semua notifikasi. Silakan coba lagi.');
            });
        });
    }

    // Handle "Hapus Semua" dengan AJAX
    if (clearAllForm) {
        clearAllForm.addEventListener('submit', (e) => {
            e.preventDefault();
            fetch('/notifications/clear', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! Status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log('Clear all response:', data);
                document.querySelector('#notificationList').innerHTML = '<p class="text-muted">Tidak ada notifikasi baru.</p>';
                document.querySelectorAll('.badge.bg-danger').forEach(badge => {
                    badge.textContent = '0';
                });
                alert(data.message || 'Semua notifikasi telah dihapus.');
            })
            .catch(error => {
                console.error('Error clearing all notifications:', error);
                alert('Gagal menghapus semua notifikasi. Silakan coba lagi.');
            });
        });
    }
});
</script>

<script>
    const notifModal = document.getElementById('notificationModal');
    const notifBtn = document.getElementById('btnNotifMobile');
    const hamburgerBtn = document.getElementById('btnHamburger');

    notifModal.addEventListener('show.bs.offcanvas', function () {
        notifBtn?.classList.add('d-none');
        hamburgerBtn?.classList.add('d-none');
    });

    notifModal.addEventListener('hidden.bs.offcanvas', function () {
        notifBtn?.classList.remove('d-none');
        hamburgerBtn?.classList.remove('d-none');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const lokasi = @json($lokasi);
        const kabupaten = "{{ asset('storage/kabupaten.json') }}";
        const kecamatan = "{{ asset('storage/31kecamatan.geojson') }}";
        const desa = "{{ asset('storage/desa.geojson') }}";
    </script>

    <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (!empty($filters))
                const budidayaSection = document.getElementById('budidaya');
                if (budidayaSection) {
                    budidayaSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            @endif
        });
    </script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    <script src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/map.js') }}"></script>

</body>

</html>
