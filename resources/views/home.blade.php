<!DOCTYPE html>
<html lang="en">

<head>
    <title>SIBIKANDA</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('apk_gis/public/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('apk_gis/public/css/style.css') }}">

    <link href="{{ asset('apk_gis/public/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('apk_gis/public/css/main.css') }}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <style>
    </style>
</head>

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
            <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z" />
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

    {{-- <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">

        <div class="offcanvas-header justify-content-between">
            <h4 class="fw-normal text-uppercase fs-6">Menu</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">

            <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
                <li class="nav-item border-dashed">
                    <a href="index.html" class="nav-link d-flex align-items-center gap-3 text-dark p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <use xlink:href="#seafood"></use>
                        </svg>
                        <span>Seafood</span>
                    </a>
                </li>
                <li class="nav-item border-dashed">
                    <button
                        class="btn btn-toggle dropdown-toggle position-relative w-100 d-flex justify-content-between align-items-center text-dark p-2"
                        data-bs-toggle="collapse" data-bs-target="#beverages-collapse" aria-expanded="false">
                        <div class="d-flex gap-3">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#beverages"></use>
                            </svg>
                            <span>Beverages</span>
                        </div>
                    </button>
                    <div class="collapse" id="beverages-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal ps-5 pb-1">
                            <li class="border-bottom py-2"><a href="index.html" class="dropdown-item">Water</a></li>
                            <li class="border-bottom py-2"><a href="index.html" class="dropdown-item">Juice</a></li>
                            <li class="border-bottom py-2"><a href="index.html" class="dropdown-item">Soda</a></li>
                            <li class="border-bottom py-2"><a href="index.html" class="dropdown-item">Tea</a></li>
                        </ul>
                    </div>
                </li>
            </ul>

        </div>

    </div>

    <header>
        <div class="container-fluid">
            <div class="d-flex align-items-center py-1 border-bottom flex-wrap">

                <!-- Logo & Toggler -->
                <div class="d-flex align-items-center gap-4">
                    <a href="index.html">
                        <img src="{{ asset('images/logo.png') }}" alt="logo" class="img-fluid"
                            style="width: 75px;">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <use xlink:href="#menu"></use>
                        </svg>
                    </button>
                </div>

                <!-- Navbar Menu -->
                <div class="d-flex align-items-center justify-content-center flex-grow-1">
                    <ul
                        class="navbar-nav list-unstyled d-flex flex-row gap-4 mb-0 fw-semibold fs-20 text-uppercase text-dark">
                        <li class="nav-item">
                            <a href="{{ url('home') }}" class="nav-link">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a href="#komoditas" class="nav-link">Komoditas</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('location') }}" class="nav-link">Peta Budidaya</a>
                        </li>
                        <li class="nav-item">
                            <a href="#budidaya" class="nav-link">Budidaya</a>
                        </li>
                    </ul>
                </div>

                <!-- User Icon -->
                <div class="d-flex align-items-center ms-auto position-relative">
                    <a href="#" class="mx-2" id="user-icon">
                        <svg width="28" height="28">
                            <use xlink:href="#user"></use>
                        </svg>
                    </a>

                    <!-- Dropdown menu -->
                    <div id="user-dropdown"
                    class="user-dropdown position-absolute end-0 mt-2 bg-white border rounded shadow-sm"
                    style="display: none; min-width: 180px;">
                    
                    @if (Auth::guard('pembudidaya')->check())
                        <div class="px-3 py-2 border-bottom">
                            <strong>{{ Auth::guard('pembudidaya')->user()->name }}</strong><br>
                            <small>{{ Auth::guard('pembudidaya')->user()->email }}</small>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="d-block w-100 text-start px-3 py-2 text-dark bg-white border-0"
                                style="transition: 0.2s; font-weight: 500;">Logout</button>
                        </form>
                
                    @elseif(Auth::check())
                        <div class="px-3 py-2 border-bottom">
                            <strong>{{ Auth::user()->name }}</strong><br>
                            <small>{{ Auth::user()->email }}</small>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="d-block w-100 text-start px-3 py-2 text-dark bg-white border-0"
                                style="transition: 0.2s; font-weight: 500;">Logout</button>
                        </form>
                
                    @else
                        <a href="{{ route('login') }}" class="d-block px-3 py-2 text-dark text-decoration-none"
                            style="transition: 0.2s; font-weight: 500;">Masuk</a>
                        <a href="{{ route('register') }}" class="d-block px-3 py-2 text-dark text-decoration-none"
                            style="transition: 0.2s; font-weight: 500;">Daftar</a>
                        <a href="{{ route('pembudidaya.login') }}" class="d-block px-3 py-2 text-dark text-decoration-none"
                            style="transition: 0.2s; font-weight: 500;">Masuk Sebagai Pembudidaya</a>
                    @endif
                </div>
                </div>
                <!-- Offcanvas Mobile Menu -->
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav list-unstyled gap-3">
                            <li class="nav-item">
                                <a href="{{ url('home') }}" class="nav-link">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a href="#komoditas" class="nav-link">Komoditas</a>
                            </li>
                            <li class="nav-item">
                                <a href="index.html" class="nav-link">Peta Budidaya</a>
                            </li>
                            <li class="nav-item">
                                <a href="#mitra" class="nav-link">Mitra</a>
                            </li>
                        </ul>
                    </div>
                </div> --}}
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a class="logo d-flex align-items-center me-auto me-xl-0">
                <img src="{{ asset('apk_gis/public/images/logo.png') }}" alt="">
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#beranda" class="active">Beranda<br></a></li>
                    <li><a href="#komoditas">Komoditas</a></li>
                    <li><a href="#budidaya">Budidaya</a></li>
                    <li><a href="#peta">Peta Budidaya</a></li>
                    <li><a href="#kami">Tentang Kami</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileNav"></i>
            </nav>
            {{-- <div class="dropdown d-inline-block d-none d-xl-block">
                <a class="btn btn-primary rounded-pill px-4 py-2 dropdown-toggle" href="#" id="loginDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Log In
                </a>
                <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 small-dropdown"
                    aria-labelledby="loginDropdown">
                    <li><a class="dropdown-item py-1 px-3 small" href="{{ url('login') }}">Log In</a></li>
                    <li><a class="dropdown-item py-1 px-3 small" href="login-pembudidaya.html">Log In
                            Pembudidaya</a></li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li><a class="dropdown-item py-1 px-3 small" href="signup.html">📝 Gabung Investor</a></li>
                </ul>
            </div> --}}
            <div class="dropdown d-inline-block d-none d-xl-block">
                @if (Auth::check() || Auth::guard('pembudidaya')->check())
                    @php
                        $user = Auth::check() ? Auth::user() : Auth::guard('pembudidaya')->user();
                    @endphp
                    <a class="btn btn-primary rounded-pill px-4 py-2 dropdown-toggle" href="#"
                        id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $user->name }}
                    </a>
                    <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 small-dropdown"
                        aria-labelledby="accountDropdown">
                        <li><a class="dropdown-item py-1 px-3 small" href="#">Account Settings</a></li>
                        <li>
                            <hr class="dropdown-divider my-1">
                        </li>
                        <li>
                            <form action="{{ url('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item py-1 px-3 small" type="submit">🚪 Log Out</button>
                            </form>
                        </li>
                    </ul>
                @else
                    <a class="btn btn-primary rounded-pill px-4 py-2 dropdown-toggle" href="#"
                        id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Log In
                    </a>
                    <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 small-dropdown"
                        aria-labelledby="loginDropdown">
                        <li><a class="dropdown-item py-1 px-3 small" href="{{ url('login') }}">Log In</a></li>
                        <li><a class="dropdown-item py-1 px-3 small" href="login-pembudidaya.html">Log In
                                Pembudidaya</a></li>
                        <li>
                            <hr class="dropdown-divider my-1">
                        </li>
                        <li><a class="dropdown-item py-1 px-3 small" href="signup.html">📝 Gabung Investor</a></li>
                    </ul>
                @endif
            </div>

        </div>
    </header>

    <!-- Mobile Menu (Offcanvas) -->
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
                    <li><a class="nav-link" href="#">Account Settings</a></li>
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
                            <li><a class="dropdown-item py-2" href="login-pembudidaya.html">Log In Pembudidaya</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item py-2" href="signup.html">📝Gabung Investor</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <section id="beranda"
        style="background-image: url('{{ asset('apk_gis/public/images/tambak-ikan.jpg') }}');background-repeat: no-repeat;background-size: cover;">
        <div class="container-lg mt-3">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="display-1 ls-1">
                        <span class="fw-bold text-primary">Inkubator</span>
                        Bisnis
                        <span class="fw-bold">Perikanan</span>
                    </h2>
                    <p class="fs-5">Temukan informasi lengkap tentang budidaya ikan unggulan di Indramayu.</p>
                    {{-- <div class="d-flex gap-3 mt-3">
                        <a href="{{ url('register') }}"
                            class="btn btn-dark text-uppercase fs-6 rounded-pill px-4 py-3 mt-3">Gabung
                            Investor</a>
                    </div> --}}
                    <div class="d-flex gap-3 mt-3">
                        @if (Auth::check() && Auth::user()->role == 'user')
                            <button class="btn btn-primary text-uppercase fs-6 rounded-pill px-4 py-3 mt-3"
                                data-bs-toggle="modal" data-bs-target="#modalCari">Form Cari</button>
                        @else
                            <a href="{{ url('register') }}"
                                class="btn btn-dark text-uppercase fs-6 rounded-pill px-4 py-3 mt-3">Gabung
                                Investor</a>
                        @endif
                    </div>
                    <div class="modal fade" id="modalCari" tabindex="-1" aria-labelledby="modalCariLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 450px; font-size: 0.75rem;">
                            <div class="modal-content">
                                <div class="modal-header py-2">
                                    <h5 class="modal-title" id="modalCariLabel">Cari Komoditas</h5>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-3">
                                    <form>
                                        <!-- Jenis Komoditas -->
                                        <div class="mb-2">
                                            <label class="form-label mb-1">Jenis Komoditas</label>
                                            <select class="form-select form-select-sm">
                                                <option>Udang</option>
                                                <option>Rumput Laut</option>
                                                <option>Ikan Bandeng</option>
                                                <option>Ikan Gurame</option>
                                                <option>Ikan Lele</option>
                                                <option>Ikan Nila</option>
                                            </select>
                                        </div>

                                        <!-- Harga -->
                                        <div class="mb-2">
                                            <label class="form-label mb-1">Harga (Rp)</label>
                                            <div class="d-flex gap-2">
                                                <input type="number" class="form-control form-control-sm"
                                                    placeholder="Min">
                                                <input type="number" class="form-control form-control-sm"
                                                    placeholder="Max">
                                            </div>
                                        </div>

                                        <!-- Kapasitas Produksi -->
                                        <div class="mb-2">
                                            <label class="form-label mb-1">Kapasitas Produksi (kg/bulan)</label>
                                            <input type="number" class="form-control form-control-sm"
                                                placeholder="Cth: 1000">
                                        </div>

                                        <!-- Kecamatan -->
                                        <div class="mb-2">
                                            <label class="form-label mb-1">Kecamatan</label>
                                            <select class="form-select form-select-sm">
                                                <option>Indramayu</option>
                                                <option>Juntinyuat</option>
                                                <option>Losarang</option>
                                                <option>Balongan</option>
                                                <option>Karangampel</option>
                                                <option>Kertasemaya</option>
                                                <option>Haurgeulis</option>
                                                <option>Anjatan</option>
                                                <option>Gantar</option>
                                                <!-- Tambah sesuai kebutuhan -->
                                            </select>
                                        </div>

                                        <!-- Prediksi Panen -->
                                        <div class="mb-2">
                                            <label class="form-label mb-1">Prediksi Panen</label>
                                            <input type="date" class="form-control form-control-sm">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer py-2">
                                    <button type="button" class="btn btn-primary btn-sm">Cari</button>
                                </div>
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
                            {{-- <a href="{{ route('katalog', ['komoditas' => 'udang']) }}" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/udang.jpg') }}" class="rounded-circle" alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Udang</h4>
                            </a>
                            <a href="{{ route('katalog', ['komoditas' => 'rumput-laut']) }}" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/rumputlaut.jpg') }}" class="rounded-circle" alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Rumput Laut</h4>
                            </a>
                            <a href="{{ route('katalog', ['komoditas' => 'ikan-bandeng']) }}" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/ikanbandeng.jpg') }}" class="rounded-circle" alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Ikan Bandeng</h4>
                            </a>
                            <a href="{{ route('katalog', ['komoditas' => 'ikan-gurame']) }}" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/ikangurame.jpg') }}" class="rounded-circle" alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Ikan Gurame</h4>
                            </a>
                            <a href="{{ route('katalog', ['komoditas' => 'ikan-lele']) }}" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/ikanlele.jpg') }}" class="rounded-circle" alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Ikan Lele</h4>
                            </a>
                            <a href="{{ route('katalog', ['komoditas' => 'ikan-nila']) }}" class="nav-link swiper-slide text-center">
                                <img src="{{ asset('images/ikannila.jpeg') }}" class="rounded-circle" alt="Category Thumbnail"> --}}
                            <a class="nav-link swiper-slide text-center">
                                <img src="{{ asset('apk_gis/public/images/udang.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Udang</h4>
                            </a>
                            <a class="nav-link swiper-slide text-center">
                                <img src="{{ asset('apk_gis/public/images/rumputlaut.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Rumput Laut</h4>
                            </a>
                            <a class="nav-link swiper-slide text-center">
                                <img src="{{ asset('apk_gis/public/images/ikanbandeng.jpg') }}"
                                    class="rounded-circle" alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Ikan Bandeng</h4>
                            </a>
                            <a class="nav-link swiper-slide text-center">
                                <img src="{{ asset('apk_gis/public/images/ikangurame.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Ikan Gurame</h4>
                            </a>
                            <a class="nav-link swiper-slide text-center">
                                <img src="{{ asset('apk_gis/public/images/ikanlele.jpg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Ikan Lele</h4>
                            </a>
                            <a class="nav-link swiper-slide text-center">
                                <img src="{{ asset('apk_gis/public/images/ikannila.jpeg') }}" class="rounded-circle"
                                    alt="Category Thumbnail">
                                <h4 class="fs-6 mt-3 fw-normal category-title">Ikan Nila</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="budidaya" class="pb-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header d-flex flex-wrap justify-content-between">
                        <h2 class="section-title">Etalase Produk Budidaya</h2>
                        <div class="d-flex align-items-center">
                            <a href="{{ url('katalog') }}" class="btn btn-primary rounded-1">View All</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{-- <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                        @foreach ($recommendedProducts as $product)
                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{ route('detail', $product->id) }}" title="{{ $product->nama }}">
                                        @php
                                            $gambarList = json_decode($product->gambar, true);
                                            $thumbnail = $gambarList[0] ?? 'default.jpg';
                                        @endphp
                                        <img src="{{ asset('storage/images/' . $thumbnail) }}"
                                             alt="Thumbnail {{ $product->nama }}"
                                             class="tab-image"
                                             style="width: 100%; height: 180px; object-fit: cover; border-radius: 6px;">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">{{ $product->nama }}</h3>
            
                                    {{-- Info komoditas dan pembudidaya --}}
                    {{-- <div class="mb-1">
                                        <div class="fw-semibold fs-6">{{ $product->jenis_komoditas ?? 'Tidak tersedia' }}</div>
                                        <div class="text-muted small">Pembudidaya: <strong>{{ $product->pembudidaya->name ?? 'Tidak diketahui' }}</strong></div> --}}
                    <div
                        class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="{{ url('detail') }}" title="Product Title">
                                        <img src="{{ asset('apk_gis/public/images/product-thumb-1.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Udang Vaname Super Fresh</h3>
                                    <div>
                                    </div>

                                    {{-- Kisaran harga dari database --}}
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        {{-- <span class="text-dark fw-semibold">
                                            Rp{{ number_format($product->kisaran_harga_min, 0, ',', '.') }} - Rp{{ number_format($product->kisaran_harga_max, 0, ',', '.') }}
                                        </span> --}}
                                        <span class="text-dark fw-semibold">Rp70.000 – Rp75.000</span>
                                        <span class="text-warning fw-semibold fs-6">/kg</span>
                                    </div>

                                    {{-- Input jumlah --}}
                                    <div class="button-area p-3 pt-0">
                                        {{-- <div class="row g-1 mt-2">
                                            <div class="col-3">
                                                <input type="number" name="quantity" class="form-control border-dark-subtle input-number quantity" value="1">
                                            </div> --}}
                                        <div class="row g-1 mt-2 d-flex justify-content-center">
                                            <div class="col-7">
                                                <a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart">
                                                    <svg width="18" height="18">
                                                        <use xlink:href="#detail"></use>
                                                    </svg> Detail
                                                </a>
                                            </div>
                                            <div class="col-2">
                                                <a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6">
                                                    <svg width="18" height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="index.html" title="Product Title">
                                        <img src="{{ asset('apk_gis/public/images/product-thumb-2.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Rumput Laut Gracilaria</h3>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <span class="text-dark fw-semibold">Rp12.000 – Rp14.000</span>
                                        <span class="text-warning fw-semibold fs-6">/kg</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2 d-flex justify-content-center">
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#detail"></use>
                                                    </svg> Detail
                                                </a>
                                            </div>
                                            <div class="col-2">
                                                <a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6">
                                                    <svg width="18" height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="index.html" title="Product Title">
                                        <img src="{{ asset('apk_gis/public/images/product-thumb-3.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Rumput Laut Siap Olah</h3>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <span class="text-dark fw-semibold">Rp6.000 – Rp7.500</span>
                                        <span class="text-warning fw-semibold fs-6">/kg</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2 d-flex justify-content-center">
                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#detail"></use>
                                                    </svg> Detail
                                                </a>
                                            </div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @endforeach
                    </div>
                </div>
            </div> --}}




                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="index.html" title="Product Title">
                                        <img src="{{ asset('apk_gis/public/images/product-thumb-6.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Gurame Segar</h3>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <span class="text-dark fw-semibold">Rp40.000 – Rp43.000</span>
                                        <span class="text-warning fw-semibold fs-6">/kg</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2 d-flex justify-content-center">

                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#detail"></use>
                                                    </svg> Detail
                                                </a>
                                            </div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="index.html" title="Product Title">
                                        <img src="{{ asset('apk_gis/public/images/product-thumb-7.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Udang Windu Jumbo</h3>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <span class="text-dark fw-semibold">Rp155.000 – Rp160.000</span>
                                        <span class="text-warning fw-semibold fs-6">/kg</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2 d-flex justify-content-center">

                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#detail"></use>
                                                    </svg> Detail
                                                </a>
                                            </div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="index.html" title="Product Title">
                                        <img src="{{ asset('apk_gis/public/images/product-thumb-8.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Bandeng Organik Air Payau</h3>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <span class="text-dark fw-semibold">Rp33.000 – Rp35.000</span>
                                        <span class="text-warning fw-semibold fs-6">/kg</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2 d-flex justify-content-center">

                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#detail"></use>
                                                    </svg> Detail
                                                </a>
                                            </div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="index.html" title="Product Title">
                                        <img src="{{ asset('apk_gis/public/images/product-thumb-9.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Lele Organik Air Tawar</h3>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <span class="text-dark fw-semibold">Rp25.000 – Rp30.000</span>
                                        <span class="text-warning fw-semibold fs-6">/kg</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2 d-flex justify-content-center">

                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#detail"></use>
                                                    </svg> Detail
                                                </a>
                                            </div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="product-item">
                                <figure>
                                    <a href="index.html" title="Product Title">
                                        <img src="{{ asset('apk_gis/public/images/product-thumb-10.png') }}"
                                            alt="Product Thumbnail" class="tab-image">
                                    </a>
                                </figure>
                                <div class="d-flex flex-column text-center">
                                    <h3 class="fs-6 fw-normal">Nila Merah Segar</h3>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <span class="text-dark fw-semibold">Rp28.000 – Rp32.000</span>
                                        <span class="text-warning fw-semibold fs-6">/kg</span>
                                    </div>
                                    <div class="button-area p-3 pt-0">
                                        <div class="row g-1 mt-2 d-flex justify-content-center">

                                            <div class="col-7"><a href="#"
                                                    class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#detail"></use>
                                                    </svg> Detail
                                                </a>
                                            </div>
                                            <div class="col-2"><a href="#"
                                                    class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg
                                                        width="18" height="18">
                                                        <use xlink:href="#heart"></use>
                                                    </svg></a></div>
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

    <!-- Start Map section -->
    <section id="peta" class="py-5"
        style="display: flex; justify-content: center; align-items: center; padding-top: 1rem !important;">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9207.358598888495!2d-85.64847801496286!3d30.183918972289003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x2320479d70eb6202!2sDillard&#39;s!5e0!3m2!1sbn!2sbd!4v1462359735720"
            width="90%" height="500px" frameborder="0"allowfullscreen></iframe>
    </section>
    <!-- End Map section -->

    <footer id="kami"
        style="background: linear-gradient(to top, #d3effa, #ffffff); font-size: 13px; line-height: 1.6; color: #333; padding-top: 3rem;">
        <!-- Pembatas -->
        <div style="border-top: 1px solid #bde5f4; margin-bottom: 20px;"></div>

        <div class="container-lg">
            <div class="row">

                <div class="col-lg-3 col-md-6 mb-3">
                    {{-- <img src="{{ asset('apk_gis/public/images/logo1.png') }}" width="160" alt="logo"> --}}
                    <div class="d-flex gap-2 mt-2">
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
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
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
                            <svg width="14" height="14">
                                <use xlink:href="#instagram"></use>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <h6 class="fw-bold mb-2 text-dark">Tentang Kami</h6>
                    <p class="text-muted mb-1">
                        Aplikasi Inkubator Bisnis Ikan Indramayu yang menyediakan info komoditas unggulan dan
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
        document.getElementById("user-icon").addEventListener("click", function() {
            var dropdown = document.getElementById("user-dropdown");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        });

        document.addEventListener("click", function(e) {
            var dropdown = document.getElementById("user-dropdown");
            if (!document.getElementById("user-icon").contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = "none";
            }
        });
    </script>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('apk_gis/public/js/jquery-1.11.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="{{ asset('apk_gis/public/js/plugins.js') }}"></script>
    <script src="{{ asset('apk_gis/public/js/script.js') }}"></script>

</body>

</html>
