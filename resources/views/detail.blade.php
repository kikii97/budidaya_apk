@extends('layouts.app')

@section('title', 'Detail - SIBIKANDA')

<!-- Header Navbar -->
@section('header')
    @include('partials.header')
@endsection

@section('content')
    <style>
        /* Gambar utama */
        .main-image-container {
            width: 100%;
            max-height: 300px;
            overflow: hidden;
        }

        #mainImage {
            width: 100%;
            height: 230px;
            max-height: 300px;
            object-fit: contain;
            background: #f0f0f0;
            display: block;
            cursor: zoom-in;
        }

        /* Thumbnail */
        .thumb-container {
            width: 100%;
            height: 80px;
            overflow: hidden;
            border-radius: 6px;
        }

        .thumb-image {
            width: 100%;
            height: 80%;
            object-fit: contain;
            display: block;
            border-radius: 6px;
            cursor: pointer;
        }

        /* Overlay untuk gambar fullscreen */
        .image-overlay {
            display: none;
            position: fixed;
            z-index: 1050;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85);
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .image-overlay img.overlay-img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }

        .image-overlay .close-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 40px;
            color: #fff;
            cursor: pointer;
            z-index: 1051;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center" style="zoom: 80%;">
            <!-- Product Images -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- Modal / Fullscreen Image Preview -->
                    <div id="imageOverlay" class="image-overlay" onclick="closeImageOverlay()">
                        <span class="close-btn" onclick="closeImageOverlay(event)">&times;</span>
                        <img id="overlayImage" src="" alt="Preview" class="overlay-img">
                    </div>
                    @php
                        $images = json_decode($produk->gambar, true);
                        $mainImage = $images[0] ?? 'https://via.placeholder.com/300';
                    @endphp

                    <!-- Gambar utama -->
                    <div class="main-image-container">
                        <img id="mainImage"
                            src="{{ filter_var($mainImage, FILTER_VALIDATE_URL) ? $mainImage : asset('apk_gis/public/storage/images/' . $mainImage) }}"
                            alt="Product-Image" style="aspect-ratio: 1 / 1;" onclick="showImageOverlay(this.src)"
                            style="cursor: zoom-in;">
                    </div>

                    <!-- Thumbnail -->
                    <div class="card-body" style="padding: 16px 16px 1px;">
                        <div class="row">
                            @foreach ($images as $img)
                                <div class="col-3" style="width: 30%;">
                                    <div class="thumb-container">
                                        <img src="{{ filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('apk_gis/public/storage/images/' . $img) }}"
                                            class="thumb-image" alt="Thumbnail"
                                            onclick="document.getElementById('mainImage').src = this.src">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                {{-- Jenis Komoditas --}}
                <h1 class="h4 mb-0">{{ $produk->jenis_komoditas }}</h1>

                {{-- Kisaran Harga --}}
                <div class="mb-2">
                    <span class="h6 text-dark fw-semibold">
                        Rp{{ number_format($produk->kisaran_harga_min, 0, ',', '.') }} –
                        Rp{{ number_format($produk->kisaran_harga_max, 0, ',', '.') }}
                    </span>
                    <span class="text-warning fw-semibold fs-6">/kg</span>
                </div>

                {{-- Ringkasan awal --}}
                <div id="produk-summary">
                    <div class="d-flex" style="font-size: 0.85rem;">
                        <div style="width: 170px;"><strong>Pembudidaya</strong></div>
                        <div style="width: 10px;">:</div>
                        <div style="flex: 1;">{{ $produk->pembudidaya->name ?? '-' }}</div>
                    </div>
                    <div class="d-flex" style="font-size: 0.85rem;">
                        <div style="width: 170px;"><strong>Telepon</strong></div>
                        <div style="width: 10px;">:</div>
                        <div style="flex: 1;">
                            @php
                                $telepon = $produk->telepon ?? ($produk->pembudidaya->telepon ?? null);
                                if ($telepon) {
                                    $nomor = preg_replace('/[^0-9]/', '', $telepon);
                                    if (strpos($nomor, '0') === 0) {
                                        $nomor = '62' . substr($nomor, 1);
                                    }
                                }
                            @endphp

                            @if ($telepon)
                                <a href="https://wa.me/{{ $nomor }}" target="_blank"
                                    style="color: #000; text-decoration: underline;">
                                    {{ $telepon }}
                                </a>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="d-flex" style="font-size: 0.85rem;">
                        <div style="width: 170px;"><strong>Kapasitas</strong></div>
                        <div style="width: 10px;">:</div>
                        <div style="flex: 1;">{{ $produk->kapasitas_produksi ?? '-' }} kg</div>
                    </div>
                    <div class="d-flex" style="font-size: 0.85rem;">
                        <div style="width: 170px;"><strong>Spesifik Komoditas</strong></div>
                        <div style="width: 10px;">:</div>
                        <div style="flex: 1;">{{ $produk->jenis_spesifik_komoditas ?? '-' }}</div>
                    </div>
                </div>

                {{-- Detail lengkap --}}
                <div class="d-flex" style="font-size: 0.85rem;">
                    <div style="width: 170px;"><strong>Alamat</strong></div>
                    <div style="width: 10px;">:</div>
                    <div style="flex: 1;">
                        {{ $produk->alamat_lengkap ?? '-' }}{{ $produk->kecamatan ? ', ' . $produk->kecamatan : '' }}
                    </div>
                </div>
                <div id="produk-detail" style="display: none;">
                    <div class="d-flex" style="font-size: 0.85rem;">
                        <div style="width: 170px;"><strong>Prediksi Panen</strong></div>
                        <div style="width: 10px;">:</div>
                        <div style="flex: 1;">
                            {{ $produk->prediksi_panen ? \Carbon\Carbon::parse($produk->prediksi_panen)->translatedFormat('d F Y') : '-' }}
                        </div>
                    </div>
                    <div class="d-flex" style="font-size: 0.85rem;">
                        <div style="width: 170px;"><strong>Masa Produksi Puncak</strong></div>
                        <div style="width: 10px;">:</div>
                        <div style="flex: 1;">{{ $produk->masa_produksi_puncak ?? '-' }}</div>
                    </div>
                    <div class="d-flex" style="font-size: 0.85rem;">
                        <div style="width: 170px;"><strong>Detail</strong></div>
                        <div style="width: 10px;">:</div>
                        <div style="flex: 1;">{{ $produk->detail ?? '-' }}</div>
                    </div>
                </div>

                {{-- Tombol toggle --}}
                <button class="toggle-btn" onclick="toggleDetail(event)">
                    <span class="btn-text">Lihat selengkapnya</span>
                    <i class="bi bi-chevron-down"></i>
                </button>

                {{-- Script untuk toggle detail --}}
                @push('scripts')
                    <script>
                        function toggleDetail(event) {
                            const detail = document.getElementById('produk-detail');
                            const toggleBtn = event.currentTarget;
                            const btnText = toggleBtn.querySelector('.btn-text');
                            const icon = toggleBtn.querySelector('i');

                            if (detail.style.display === 'none' || detail.style.display === '') {
                                detail.style.display = 'block';
                                btnText.textContent = 'Sembunyikan';
                                icon.className = 'bi bi-chevron-up';
                            } else {
                                detail.style.display = 'none';
                                btnText.textContent = 'Lihat selengkapnya';
                                icon.className = 'bi bi-chevron-down';
                            }
                        }
                    </script>
                @endpush

                <!-- Actions -->
                <div class="row d-grid gap-2">
                    {{-- @if ($produk->telepon)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $produk->telepon) }}" target="_blank" class="btn btn-success">
                            <i class="fa-brands fa-whatsapp" style="padding-right: 10px;"></i>Hubungi via Whatsapp
                        </a>
                    @else
                        <button class="btn btn-success" disabled>
                            <i class="fa-brands fa-whatsapp" style="padding-right: 10px;"></i>Nomor tidak tersedia
                        </button>
                    @endif --}}

                    <div class="col">
                        @if (Auth::guard('web')->check() || Auth::guard('pembudidaya')->check())
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal">
                                <i class="fa-regular fa-clipboard" style="padding-right: 15px;"></i>Order
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fa-regular fa-clipboard" style="padding-right: 15px;"></i>Login untuk Order
                            </a>
                        @endif

                        <a href="{{ route('usaha.detail', $produk->pembudidaya_id) }}" class="btn btn-outline-secondary">
                            <i class="fa-regular fa-user" style="padding-right: 15px;"></i>Detail Usaha
                        </a>
                    </div>
                </div>

                <!-- Modal hanya ditampilkan untuk user yang sudah login -->
                @if (Auth::guard('web')->check() || Auth::guard('pembudidaya')->check())
                    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 500px;">
                            <div class="modal-content" style="border-radius: 1rem;">
                                <div class="modal-header py-2">
                                    <h5 class="modal-title" id="orderModalLabel" style="font-weight: 500;">Form Order
                                    </h5>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form id="orderForm" method="POST" action="{{ route('order.store') }}">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                                    <div class="modal-body p-3" style="color: black; font-size: 0.8rem;">
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <label class="form-label mb-1">Nama Customer</label>
                                                <input type="text" name="nama_customer"
                                                    class="form-control form-control-sm"
                                                    placeholder="Masukkan nama customer" required>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <label class="form-label mb-1">Nomor HP Customer</label>
                                                <input type="text" name="no_hp_customer"
                                                    class="form-control form-control-sm" placeholder="08xxxxxxxxxx"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label mb-1">Jumlah (dalam kg)</label>
                                                <input type="number" name="jumlah" class="form-control form-control-sm"
                                                    placeholder="Contoh: 5" min="1"
                                                    max="{{ $produk->kapasitas_produksi }}" required>
                                                <small class="text-muted">Maksimum: {{ $produk->kapasitas_produksi }}
                                                    kg</small>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label mb-1">Tanggal Order</label>
                                                <input type="date" name="tanggal_order"
                                                    class="form-control form-control-sm" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label mb-1">Keterangan</label>
                                                <textarea name="keterangan" class="form-control form-control-sm" rows="2" placeholder="Opsional"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer py-2">
                                        <button type="submit"
                                            class="btn btn-primary btn-sm rounded-pill px-3">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const jumlahInput = document.getElementById('jumlahInput');
                            const maxStok = {{ $produk->kapasitas_produksi ?? 0 }};

                            jumlahInput.addEventListener('input', function() {
                                let val = parseInt(this.value, 10);

                                if (val > maxStok) {
                                    this.value = maxStok;
                                } else if (val < 1) {
                                    this.value = 1;
                                }
                            });

                            jumlahInput.addEventListener('blur', function() {
                                if (!this.value || parseInt(this.value, 10) < 1) {
                                    this.value = 1;
                                }
                            });
                        });
                    </script>
                @endif

                @if (session('success'))
                    <div class="alert alert-success mt-3" style="font-size: 0.9rem;">
                        {{ session('success') }}<br>
                        @php
                            $telepon = $produk->telepon ?? ($produk->pembudidaya->telepon ?? null);
                            $nomor = preg_replace('/[^0-9]/', '', $telepon);
                            if (strpos($nomor, '0') === 0) {
                                $nomor = '62' . substr($nomor, 1);
                            }
                        @endphp
                        @if ($telepon)
                            <strong>
                                Hubungi pembudidaya melalui
                                <a href="https://wa.me/{{ $nomor }}" target="_blank"
                                    style="text-decoration: underline;">
                                    WhatsApp ({{ $telepon }})
                                </a>
                            </strong>
                        @endif
                    </div>
                @endif

            </div>
        </div>
        @stack('scripts')
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                const modalEl = document.getElementById('orderModal');
                if (modalEl) {
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
            @endif
        });
    </script>
    <script>
        function showImageOverlay(src) {
            const overlay = document.getElementById('imageOverlay');
            const overlayImage = document.getElementById('overlayImage');
            overlayImage.src = src;
            overlay.style.display = 'flex';
        }

        function closeImageOverlay(event) {
            event?.stopPropagation();
            document.getElementById('imageOverlay').style.display = 'none';
        }
    </script>
@endsection
