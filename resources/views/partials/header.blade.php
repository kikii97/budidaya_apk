@php
    $user = Auth::user();
    $pembudidaya = Auth::guard('pembudidaya')->user();
@endphp

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

        <a class="logo d-flex align-items-center me-auto me-xl-0" href="{{ url('/') }}">
            <img src="{{ asset('apk_gis/public/images/logo.png') }}" alt="Logo">
        </a>

        <nav id="navmenu" class="navmenu d-flex align-items-center gap-2">
            <ul class="d-none d-xl-flex">
                <li><a href="{{ url('/') }}">Beranda</a></li>
                <li><a href="{{ url('/#komoditas') }}">Komoditas</a></li>
                <li><a href="{{ url('/#budidaya') }}">Budidaya</a></li>
                <li><a href="{{ url('/#peta') }}">Peta Budidaya</a></li>
                <li><a href="#kami">Tentang Kami</a></li>
            </ul>

            @if ($pembudidaya)
                <!-- Tombol Notifikasi Mobile -->
                <button id="btnNotifMobile" type="button" class="btn btn-outline-secondary position-relative d-xl-none" data-bs-toggle="offcanvas" data-bs-target="#notificationModal" aria-controls="notificationModal">
                    🔔
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $pembudidaya->unreadNotifications->count() ?? 0 }}
                        <span class="visually-hidden">notifikasi baru</span>
                    </span>
                </button>
            @endif

            <!-- Tombol Hamburger Menu -->
            <i id="btnHamburger" class="mobile-nav-toggle d-xl-none bi bi-list" data-bs-toggle="offcanvas" data-bs-target="#mobileNav"></i>
        </nav>

        <div class="d-none d-xl-flex align-items-center gap-2 ms-3">
            @if ($pembudidaya)
                <!-- Tombol Notifikasi Desktop -->
                <button type="button" class="btn btn-outline-secondary position-relative"
                    data-bs-toggle="offcanvas" data-bs-target="#notificationModal" aria-controls="notificationModal">
                    🔔
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $pembudidaya->unreadNotifications->count() ?? 0 }}
                        <span class="visually-hidden">notifikasi baru</span>
                    </span>
                </button>
            @endif

            @if ($pembudidaya || $user)
                <!-- Dropdown User -->
                <div class="dropdown position-relative">
                    <a class="btn btn-primary rounded-pill px-4 py-2 dropdown-toggle" href="#"
                        id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $pembudidaya?->name ?? $user->name }}
                    </a>
                    <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 small-dropdown"
                        aria-labelledby="accountDropdown">
                        @if($pembudidaya)
                            <li>
                                <a class="dropdown-item py-1 px-3 small"
                                   href="{{ route('pembudidaya.detail_usaha', ['id' => $pembudidaya->id ?? 0]) }}">
                                    Account Settings
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
                    <a class="btn btn-primary rounded-pill px-4 py-2 dropdown-toggle" href="#"
                       id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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

        @if ($pembudidaya && $pembudidaya->notifications->count())
            <!-- Daftar Ringkas -->
            <ul class="list-group mb-3" id="notificationList">
                @foreach ($pembudidaya->notifications as $notification)
                    <li 
                        class="list-group-item notification-item {{ is_null($notification->read_at) ? 'fw-bold' : 'text-muted' }}" 
                        data-id="{{ $notification->id }}" 
                        style="cursor: pointer;"
                    >
                        📩 {{ $notification->data['judul'] ?? 'Pesanan Baru' }}
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
            @if(Auth::guard('pembudidaya')->check())
                <li><a class="nav-link" href="{{ route('pembudidaya.detail_usaha') }}">Account Settings</a></li>
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
<script>
    const notifModal = document.getElementById('notificationModal');
    const notifBtn = document.getElementById('btnNotifMobile');
    const hamburgerBtn = document.getElementById('btnHamburger');

    notifModal.addEventListener('show.bs.offcanvas', function () {
        // Sembunyikan tombol saat modal terbuka
        notifBtn?.classList.add('d-none');
        hamburgerBtn?.classList.add('d-none');
    });

    notifModal.addEventListener('hidden.bs.offcanvas', function () {
        // Tampilkan kembali tombol saat modal tertutup
        notifBtn?.classList.remove('d-none');
        hamburgerBtn?.classList.remove('d-none');
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const notificationItems = document.querySelectorAll('.notification-item');
    const detailTemplate = document.getElementById('notificationDetailTemplate');

    let currentDetailElement = null;

    notificationItems.forEach(item => {
        item.addEventListener('click', () => {
            const notifId = item.getAttribute('data-id');

            fetch(`/notifications/${notifId}`)
                .then(res => res.json())
                .then(data => {
                    // Hapus detail yang sedang aktif sebelumnya
                    if (currentDetailElement) {
                        currentDetailElement.remove();
                        currentDetailElement = null;
                    }

                    // Clone template detail
                    const clone = detailTemplate.content.cloneNode(true);
                    const detailCard = clone.querySelector('.notification-detail');
                    const detailTitle = clone.querySelector('.detail-title');
                    const detailContent = clone.querySelector('.detail-content');
                    const closeBtn = clone.querySelector('.btn-close-detail');

                    detailTitle.textContent = data.judul ?? "Detail Notifikasi";
                    detailContent.innerHTML = `
                        ${data.message || data.pesan ? `<p>${data.message || data.pesan}</p>` : ''}
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

                    // Tandai sebagai dibaca
                    item.classList.remove('fw-bold');
                    item.classList.add('text-muted');

                    // Tambahkan ke DOM setelah notifikasi yang diklik
                    item.insertAdjacentElement('afterend', detailCard);
                    currentDetailElement = detailCard;

                    // Tombol tutup detail
                    closeBtn.addEventListener('click', () => {
                        detailCard.remove();
                        currentDetailElement = null;
                    });
                });
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
