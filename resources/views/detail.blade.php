@extends('layouts.app')

@section('title', 'Detail - SIBIKANDA')

<!-- Header Navbar -->
@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <!-- Product Images -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    @php
                        $images = json_decode($produk->gambar, true);
                        $mainImage = $images[0] ?? 'https://via.placeholder.com/300';
                    @endphp
                    <img id="mainImage"
                        src="{{ filter_var($mainImage, FILTER_VALIDATE_URL) ? $mainImage : asset('storage/images/' . $mainImage) }}"
                        class="img-thumbnail thumbnail-img" alt="Product-Image">

                    <div class="card-body">
                        <div class="row g-2">
                            @foreach ($images as $img)
                                <div class="col-3">
                                    <img src="{{ filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('storage/images/' . $img) }}"
                                        class="img-thumbnail thumbnail-img" alt="Thumbnail">
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
                    <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                        <div style="width: 110px;"><strong>Pembudidaya</strong></div>
                        <div>: {{ $produk->pembudidaya->name ?? '-' }}</div>
                    </div>
                    <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                        <div style="width: 110px;"><strong>Telepon</strong></div>
                        <div>: {{ $produk->telepon ?? $produk->pembudidaya->telepon ?? '-' }}</div>
                    </div>
                    <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                        <div style="width: 110px;"><strong>Kapasitas</strong></div>
                        <div>: {{ $produk->kapasitas_produksi ?? '-' }} kg</div>
                    </div>
                    <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                        <div style="width: 110px;"><strong>Spesifik Komoditas</strong></div>
                        <div>: {{ $produk->jenis_spesifik_komoditas ?? '-' }}</div>
                    </div>
                </div>

                {{-- Detail lengkap --}}
                <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                    <div style="width: 110px;"><strong>Alamat</strong></div>
                    <div>: {{ $produk->alamat_lengkap ?? '-' }}{{ $produk->kecamatan ? ', ' . $produk->kecamatan : '' }}</div>
                </div>
                <div id="produk-detail" style="display: none;">
                    <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                        <div style="width: 110px;"><strong>Prediksi Panen</strong></div>
                        <div>: {{ $produk->prediksi_panen ? \Carbon\Carbon::parse($produk->prediksi_panen)->translatedFormat('d F Y') : '-' }}</div>
                    </div>
                    <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                        <div style="width: 110px;"><strong>Masa Produksi Puncak</strong></div>
                        <div>: {{ $produk->masa_produksi_puncak ?? '-' }}</div>
                    </div>
                    <div class="mb-1 d-flex" style="font-size: 0.85rem;">
                        <div style="width: 110px;"><strong>Detail</strong></div>
                        <div>: {{ $produk->detail ?? '-' }}</div>
                    </div>
                </div>

                {{-- Tombol toggle --}}
                <button class="btn btn-sm btn-link p-0" onclick="toggleDetail()">Lihat selengkapnya</button>

            {{-- Script untuk toggle detail --}}
            @push('scripts')
            <script>
                function toggleDetail() {
                    const detail = document.getElementById('produk-detail');
                    const toggleBtn = event.target;

                    if (detail.style.display === 'none' || detail.style.display === '') {
                        detail.style.display = 'block';
                        toggleBtn.textContent = 'Sembunyikan';
                    } else {
                        detail.style.display = 'none';
                        toggleBtn.textContent = 'Lihat selengkapnya';
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
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal">
                            <i class="fa-regular fa-clipboard" style="padding-right: 15px;"></i>Order
                        </a>

                        <a href="{{ route('usaha.detail', $produk->pembudidaya_id) }}" class="btn btn-outline-secondary">
                            <i class="fa-regular fa-user" style="padding-right: 15px;"></i>Detail Usaha
                        </a>
                    </div>

                    <!-- Modal Input Order -->
                    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 500px;">
                            <div class="modal-content">
                                <div class="modal-header py-2">
                                    <h5 class="modal-title" id="orderModalLabel">Form Order</h5>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form id="orderForm" method="POST" action="">
                                    @csrf
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
                                                <label class="form-label mb-1">Nama Produk</label>
                                                <input type="text" name="nama_produk"
                                                    class="form-control form-control-sm" placeholder="Masukkan nama produk"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form-label mb-1">Jumlah</label>
                                                <input type="number" name="jumlah" class="form-control form-control-sm"
                                                    placeholder="Contoh: 5" required>
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

                </div>

                <!-- Additional Info -->
                <div class="mt-3">
                    <div class="d-flex align-items-center mb-1">
                        <i class="fas fa-truck text-primary me-2"></i>
                        <span style="font-size: 0.775rem;">Gratis ongkos kirim untuk pesanan lebih dari 10 kg</span>
                    </div>
                </div>
            </div>
        </div>
        @stack('scripts')
    </div>
@endsection
