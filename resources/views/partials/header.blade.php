<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">
        <a class="logo d-flex align-items-center me-auto me-xl-0" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}">Beranda</a></li>
                <li><a href="{{ url('/#komoditas') }}">Komoditas</a></li>
                <li><a href="{{ url('/#budidaya') }}">Budidaya</a></li>
                <li><a href="{{ url('/#peta') }}">Peta Budidaya</a></li>
                <li><a href="#kami">Tentang Kami</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list" data-bs-toggle="offcanvas" data-bs-target="#mobileNav"></i>
        </nav>
        <div class="d-flex align-items-center gap-2 d-none d-xl-flex">

            @php
                $user = Auth::guard('pembudidaya')->user();
            @endphp

            @if ($user)
                <!-- Notifikasi Button -->
                <button type="button" class="btn btn-outline-secondary position-relative" data-bs-toggle="offcanvas" data-bs-target="#notificationModal" aria-controls="notificationModal">
                    🔔
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $user->unreadNotifications->count() ?? 0 }}
                        <span class="visually-hidden">notifikasi baru</span>
                    </span>
                </button>
            @endif

        <!-- Desktop Login / User Dropdown -->
        <div class="dropdown position-relative d-inline-block d-none d-xl-block">
            @php
                $user = Auth::user() ?? Auth::guard('pembudidaya')->user();
            @endphp

            @if ($user)
                <a class="btn btn-primary rounded-pill px-4 py-2 dropdown-toggle" href="#" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ $user->name }}
                </a>
                <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 small-dropdown" aria-labelledby="accountDropdown">
                    <li><a class="dropdown-item py-1 px-3 small" href="#">Account Settings</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item py-1 px-3 small" type="submit">🚪 Log Out</button>
                        </form>
                    </li>
                </ul>
            @else
                <a class="btn btn-primary rounded-pill px-4 py-2 dropdown-toggle" href="#" id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Log In
                </a>
                <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 small-dropdown" aria-labelledby="loginDropdown">
                    <li><a class="dropdown-item py-1 px-3 small" href="{{ url('login') }}">Log In</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li><a class="dropdown-item py-1 px-3 small" href="{{ url('login?form=register&tipe=investor') }}">📝 Gabung Investor</a></li>
                </ul>
            @endif
        </div>
    </div>
            <!-- Offcanvas Notifikasi (Modal sebelah kanan) -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="notificationModal" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="notificationModalLabel">Notifikasi</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Isi notifikasi di sini -->
            @if ($notifications->count())
                <ul class="list-group">
                    @foreach ($notifications as $notification)
                        <li class="list-group-item">
                            {{ $notification->data['message'] ?? 'Notifikasi baru' }}
                            <br>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Tidak ada notifikasi baru.</p>
            @endif
            <!-- Bisa tambahkan tombol hapus notifikasi jika ingin -->
            <button type="button" class="btn btn-danger mt-3" id="clearNotificationsBtn">Hapus Semua Notifikasi</button>
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
            <li><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
            <li><a class="nav-link" href="{{ url('/#komoditas') }}">Komoditas</a></li>
            <li><a class="nav-link" href="{{ url('/#budidaya') }}">Budidaya</a></li>
            <li><a class="nav-link" href="{{ url('/#peta') }}">Peta Budidaya</a></li>
            <li><a class="nav-link" href="#kami">Tentang Kami</a></li>

            @if ($user)
                <li><a class="nav-link" href="#">Account Settings</a></li>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
