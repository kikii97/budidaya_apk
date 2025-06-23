<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Detail Komoditas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AdminLTE & FontAwesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  @include('admin.partials.navbar')
  @include('admin.partials.sidebar')

  <div class="content-wrapper">
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Komoditas</h5>
          </div>
          <div class="card-body">

            <div class="mb-3">
                <strong>Gambar Produk:</strong><br>
                @php
                    $gambarList = json_decode($produk->gambar, true);
                @endphp

                @if (!empty($gambarList) && is_array($gambarList))
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach ($gambarList as $gambar)
                        <img src="{{ asset('storage/images/' . $gambar) }}"
                            alt="Gambar Produk"
                            class="img-thumbnail"
                            style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                            onclick="tampilkanGambar('{{ asset('storage/images/' . $gambar) }}')">
                        @endforeach
                    </div>
                @else
                    <span class="text-muted">Tidak ada gambar tersedia.</span>
                @endif
            </div>
            <!-- Modal Preview Gambar -->
            <div class="modal fade" id="gambarPreviewModal" tabindex="-1" aria-labelledby="gambarPreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-transparent border-0 position-relative">
                <!-- Tombol Close -->
                <button type="button" class="close position-absolute text-white" style="top: 10px; right: 15px; z-index: 1051;" data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 2rem;" aria-hidden="true">&times;</span>
                </button>

                <div class="modal-body text-center p-0">
                    <img src="" id="previewGambar" class="img-fluid rounded" style="max-height: 90vh;" alt="Preview Gambar">
                </div>
                </div>
            </div>
            </div>
            <div class="mb-3"><strong>Nama Pembudidaya:</strong> {{ $produk->pembudidaya->name ?? '-' }}</div>
            <div class="mb-3"><strong>Jenis Komoditas:</strong> {{ $produk->jenis_komoditas }}</div>
            <div class="mb-3"><strong>Jenis Spesifik:</strong> {{ $produk->jenis_spesifik_komoditas }}</div>
            <div class="mb-3"><strong>Telepon:</strong> {{ $produk->telepon ?? '-' }}</div>
            <div class="mb-3"><strong>Kecamatan:</strong> {{ $produk->kecamatan ?? '-' }}</div>
            <div class="mb-3"><strong>Alamat Lengkap:</strong> {{ $produk->alamat_lengkap ?? '-' }}</div>
            <div class="mb-3"><strong>Kapasitas Produksi:</strong> {{ $produk->kapasitas_produksi ?? '-' }}</div>
            <div class="mb-3"><strong>Masa Produksi Puncak:</strong> {{ $produk->masa_produksi_puncak ?? '-' }}</div>
            <div class="mb-3">
              <strong>Kisaran Harga:</strong>
              Rp {{ number_format($produk->kisaran_harga_min, 0, ',', '.') }} -
              Rp {{ number_format($produk->kisaran_harga_max, 0, ',', '.') }}
            </div>
            <div class="mb-3"><strong>Prediksi Panen:</strong> {{ $produk->prediksi_panen ?? '-' }}</div>
            <div class="mb-3">
              <strong>Detail Tambahan:</strong>
              <p class="mb-0">{{ $produk->detail ?? '-' }}</p>
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
            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>

          </div>
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
<script>
  function tampilkanGambar(src) {
      const gambar = document.getElementById('previewGambar');
      gambar.src = src;
      $('#gambarPreviewModal').modal('show');
  }
</script>
</body>
</html>
