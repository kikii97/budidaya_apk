@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Detail Komoditas</h2>
    <div class="card">
        <div class="card-body">
            <h4>{{ $produk->jenis_komoditas }} - {{ $produk->jenis_spesifik_komoditas }}</h4>
            <p><strong>Nama Pembudidaya:</strong> {{ $produk->pembudidaya->name ?? '-' }}</p>
            <p><strong>Telepon:</strong> {{ $produk->telepon }}</p>
            <p><strong>Kecamatan:</strong> {{ $produk->kecamatan }}</p>
            <p><strong>Alamat Lengkap:</strong> {{ $produk->alamat_lengkap }}</p>
            <p><strong>Kapasitas Produksi:</strong> {{ $produk->kapasitas_produksi }}</p>
            <p><strong>Masa Produksi Puncak:</strong> {{ $produk->masa_produksi_puncak }}</p>
            <p><strong>Kisaran Harga:</strong> Rp {{ number_format($produk->kisaran_harga_min, 0, ',', '.') }} - Rp {{ number_format($produk->kisaran_harga_max, 0, ',', '.') }}</p>
            <p><strong>Prediksi Panen:</strong> {{ $produk->prediksi_panen }}</p>
            <p><strong>Detail Tambahan:</strong> {{ $produk->detail }}</p>
            <p><strong>Status:</strong> 
                @if (is_null($produk->is_approved))
                    <span class="badge bg-secondary">Menunggu</span>
                @elseif ($produk->is_approved)
                    <span class="badge bg-success">Disetujui</span>
                @else
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </p>
            
            <div class="mt-3">
                <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
