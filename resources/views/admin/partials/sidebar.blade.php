<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pengguna.index') }}"
                        class="nav-link {{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Kelola Pengguna</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pembudidaya.index') }}"
                        class="nav-link {{ request()->routeIs('admin.pembudidaya.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Kelola Pembudidaya</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.produk.index') }}"
                        class="nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Kelola Komoditas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.statistik.index') }}"
                        class="nav-link {{ request()->routeIs('admin.statistik.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Statistik</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
