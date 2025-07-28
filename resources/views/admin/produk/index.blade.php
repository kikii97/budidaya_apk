<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Komoditas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AdminLTE & Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  @include('admin.partials.navbar')
  @include('admin.partials.sidebar')

  <div class="content-wrapper">
    <section class="content pt-3">
      <div class="container-fluid">
        <h1 class="mb-4">Manajemen Komoditas</h1>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tombol Tambah Komoditas --}}
        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Tambah Komoditas
        </a>

        {{-- Tabel daftar komoditas --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
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

                            {{-- Gambar --}}
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

                            {{-- Status --}}
                            <td class="text-center">
                                @if (is_null($item->is_approved))
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Menunggu</span>
                                @elseif ($item->is_approved)
                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Disetujui</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Ditolak</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="text-nowrap text-center">
                                <a href="{{ route('admin.produk.detail', $item->id) }}" class="btn btn-sm btn-primary mb-1" data-bs-toggle="tooltip" title="Lihat Detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>

                                {{-- Tombol Edit hanya jika sudah diputuskan (disetujui / ditolak) --}}
                                @if (!is_null($item->is_approved))
                                    <a href="{{ route('admin.produk.edit', $item->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit Komoditas">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @endif

                                @if (is_null($item->is_approved))
                                    <form action="{{ route('admin.produk.approve', $item->id) }}" method="POST" class="d-inline-block mb-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Setujui" onclick="return confirm('Setujui komoditas ini?')">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.produk.reject', $item->id) }}" method="POST" class="d-inline-block mb-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Tolak" onclick="return confirm('Tolak komoditas ini?')">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="fas fa-trash"></i> Hapus
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
    </section>
  </div>

  <footer class="main-footer text-sm text-center">
    <strong>&copy; {{ date('Y') }} Admin Panel.</strong> All rights reserved.
  </footer>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

{{-- Tooltip init --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
</body>
</html>
