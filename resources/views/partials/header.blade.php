<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">
        <a class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="{{ asset('apk_gis/public/images/logo.png') }}" alt="">
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}">Beranda<br></a></li>
                <li><a href="{{ url('/#komoditas') }}">Komoditas</a></li>
                <li><a href="{{ url('/#budidaya') }}">Budidaya</a></li>
                <li><a href="{{ url('/#peta') }}">Peta Budidaya</a></li>
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
            <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 small-dropdown" aria-labelledby="loginDropdown">
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
            @if (Auth::check())
                <a class="btn btn-primary rounded-pill px-4 py-2 dropdown-toggle" href="#"
                    id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
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
            <li><a class="nav-link" href="{{ url('/') }}">Beranda<br></a></li>
            <li><a class="nav-link" href="{{ url('/#komoditas') }}">Komoditas</a></li>
            <li><a class="nav-link" href="{{ url('/#budidaya') }}">Budidaya</a></li>
            <li><a class="nav-link" href="{{ url('/#peta') }}">Peta Budidaya</a></li>
            <li><a class="nav-link" href="#kami">Tentang Kami</a></li>
            <!-- Log In dropdown di mobile -->
            {{-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="mobileLoginDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Log In
                </a>
                <ul class="dropdown-menu border-0 shadow-sm w-100 mt-0 rounded-0" aria-labelledby="mobileLoginDropdown">
                    <li><a class="dropdown-item py-2" href="{{ url('login') }}">Log In</a></li>
                    <li><a class="dropdown-item py-2" href="login-pembudidaya.html">Log In Pembudidaya</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item py-2" href="signup.html">📝Gabung Investor</a></li>
                </ul>
            </li> --}}

            <!-- Log In dropdown di mobile -->
            @if (Auth::check())
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
