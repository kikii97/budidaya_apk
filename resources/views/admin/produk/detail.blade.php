@extends('admin.dashboard')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Detail Komoditas</h5>
    </div>
    <div class="card-body">
        <!-- Informasi Produk -->
        <div class="mb-3">
            <strong>Jenis Komoditas:</strong> {{ $produk->jenis_komoditas }}
        </div>
        <div class="mb-3">
            <strong>Jenis Spesifik:</strong> {{ $produk->jenis_spesifik_komoditas }}
        </div>
        <div class="mb-3">
            <strong>Nama Pembudidaya:</strong> {{ $produk->pembudidaya->name ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Telepon:</strong> {{ $produk->telepon ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Kecamatan:</strong> {{ $produk->kecamatan ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Alamat Lengkap:</strong> {{ $produk->alamat_lengkap ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Kapasitas Produksi:</strong> {{ $produk->kapasitas_produksi ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Masa Produksi Puncak:</strong> {{ $produk->masa_produksi_puncak ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Kisaran Harga:</strong> 
            Rp {{ number_format($produk->kisaran_harga_min, 0, ',', '.') }} - 
            Rp {{ number_format($produk->kisaran_harga_max, 0, ',', '.') }}
        </div>
        <div class="mb-3">
            <strong>Prediksi Panen:</strong> {{ $produk->prediksi_panen ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Detail Tambahan:</strong><br>
            <p>{{ $produk->detail ?? '-' }}</p>
        </div>
        <div class="mb-3">
            <strong>Status:</strong>
            <span class="badge 
                @if (is_null($produk->is_approved)) bg-secondary
                @elseif ($produk->is_approved) bg-success
                @else bg-danger @endif">
                @if (is_null($produk->is_approved))
                    Menunggu
                @elseif ($produk->is_approved)
                    Disetujui
                @else
                    Ditolak
                @endif
            </span>
        </div>

        <hr>

        <!-- Tombol Kembali -->
        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
