<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">
        <a class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="{{ asset('images/logo.png') }}" alt="">
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="#beranda" class="active">Beranda<br></a></li>
                <li><a href="#komoditas">Komoditas</a></li>
                <li><a href="#budidaya">Budidaya</a></li>
                <li><a href="#peta">Peta Budidaya</a></li>
                <li><a href="#kontak">Contact</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list" data-bs-toggle="offcanvas"
                data-bs-target="#mobileNav"></i>
        </nav>
        <div class="dropdown d-inline-block d-none d-xl-block">
            <a class="btn btn-primary rounded-pill px-4 py-2 dropdown-toggle" href="#" id="loginDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                Log In
            </a>
            <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 small-dropdown"
                aria-labelledby="loginDropdown">
                <li><a class="dropdown-item py-1 px-3 small" href="{{ url('login') }}">Log In</a></li>
                <li><a class="dropdown-item py-1 px-3 small" href="{{ url('login') }}">Log In
                        Pembudidaya</a></li>
                <li>
                    <hr class="dropdown-divider my-1">
                </li>
                <li><a class="dropdown-item py-1 px-3 small" href="{{ url('login?form=register&tipe=investor') }}">📝 Gabung Investor</a></li>
            </ul>
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
            <li><a class="nav-link" href="#kontak">Contact</a></li>

            <!-- Log In dropdown di mobile -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="mobileLoginDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Log In
                </a>
                <ul class="dropdown-menu border-0 shadow-sm w-100 mt-0 rounded-0"
                    aria-labelledby="mobileLoginDropdown">
                    <li><a class="dropdown-item py-2" href="{{ url('login') }}">Log In</a></li>
                    <li><a class="dropdown-item py-2" href="{{ url('login') }}">Log In Pembudidaya</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item py-2" href="{{ url('login?form=register&tipe=investor') }}">📝Gabung Investor</a></li>
                </ul>
            </li>

        </ul>
    </div>
</div>

