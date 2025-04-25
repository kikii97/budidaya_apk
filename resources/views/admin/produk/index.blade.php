@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Manajemen Komoditas</h1>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel daftar komoditas --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Pembudidaya</th>
                    <th>Telepon</th>
                    <th>Kecamatan</th>
                    <th>Alamat Lengkap</th>
                    <th>Jenis Komoditas</th>
                    <th>Jenis Spesifik</th>
                    <th>Kapasitas Produksi</th>
                    <th>Masa Produksi Puncak</th>
                    <th>Kisaran Harga</th>
                    <th>Prediksi Panen</th>
                    <th>Detail</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produk as $index => $item)
                    <tr>
                        <td class="text-center">{{ $produk->firstItem() + $index }}</td>

                        {{-- Gambar Produk --}}
                        <td>
                            @php $gambarList = json_decode($item->gambar, true); @endphp
                            @if(!empty($gambarList) && is_array($gambarList))
                                <div class="d-flex flex-wrap gap-1" style="max-width: 150px;">
                                    @foreach($gambarList as $gambar)
                                    <img src="{{ asset('storage/images/' . $gambar) }}" alt="gambar produk" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </td>

                        {{-- Informasi Lain --}}
                        <td>{{ $item->pembudidaya->name ?? '-' }}</td>
                        <td>{{ $item->telepon }}</td>
                        <td>{{ $item->kecamatan }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->alamat_lengkap, 50) }}</td>
                        <td>{{ $item->jenis_komoditas }}</td>
                        <td>{{ $item->jenis_spesifik_komoditas }}</td>
                        <td>{{ $item->kapasitas_produksi }}</td>
                        <td>{{ $item->masa_produksi_puncak }}</td>
                        <td>Rp {{ number_format($item->kisaran_harga_min, 0, ',', '.') }} - Rp {{ number_format($item->kisaran_harga_max, 0, ',', '.') }}</td>
                        <td>{{ $item->prediksi_panen }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->detail, 50) }}</td>

                        {{-- Status Persetujuan --}}
                        <td class="text-center">
                            @if (is_null($item->is_approved))
                                <span class="badge bg-secondary">Menunggu</span>
                            @elseif ($item->is_approved)
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="text-nowrap text-center">
                            @if (is_null($item->is_approved))
                                {{-- Tombol Setujui --}}
                                <form action="{{ route('admin.produk.approve', $item->id) }}" method="POST" class="d-inline-block mb-1">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Setujui" onclick="return confirm('Setujui komoditas ini?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                {{-- Tombol Tolak --}}
                                <form action="{{ route('admin.produk.reject', $item->id) }}" method="POST" class="d-inline-block mb-1">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Tolak" onclick="return confirm('Tolak komoditas ini?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @else
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" class="text-center">Tidak ada data komoditas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $produk->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Inisialisasi tooltip (Bootstrap 5)
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
