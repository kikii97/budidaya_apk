<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Dokumen Pembudidaya</title>
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
            <h5 class="mb-0">Detail Dokumen Pembudidaya</h5>
          </div>
          <div class="card-body">

            {{-- Informasi Umum Pembudidaya --}}
            <div class="mb-3"><strong>Nama:</strong> {{ $dokumen->pembudidaya->name }}</div>
            <div class="mb-3"><strong>Email:</strong> {{ $dokumen->pembudidaya->email }}</div>
            <div class="mb-3">
              <strong>Status:</strong> 
              <span class="badge 
                @if($dokumen->status === 'disetujui') bg-success 
                @elseif($dokumen->status === 'ditolak') bg-danger 
                @else bg-warning text-dark @endif">
                {{ ucfirst($dokumen->status) }}
              </span>
            </div>
            <div class="mb-3"><strong>Keterangan:</strong> {{ $dokumen->keterangan ?? '-' }}</div>

            <hr>

            {{-- Dokumen Usaha --}}
            <div class="mb-4">
              <strong>Surat Usaha:</strong><br>
              @php
                $suratPaths = is_array(json_decode($dokumen->surat_usaha_path, true)) 
                  ? json_decode($dokumen->surat_usaha_path, true)
                  : [$dokumen->surat_usaha_path];
              @endphp

              @foreach ($suratPaths as $path)
                <a href="{{ asset('storage/' . $path) }}" class="btn btn-outline-info btn-sm mt-1" target="_blank">
                  <i class="fas fa-file-alt"></i> Lihat ({{ basename($path) }})
                </a><br>
              @endforeach
            </div>

            <div class="mb-4">
              <strong>Foto Usaha:</strong><br>
              @php
                $fotoPaths = is_array(json_decode($dokumen->foto_usaha_path, true)) 
                  ? json_decode($dokumen->foto_usaha_path, true)
                  : [$dokumen->foto_usaha_path];
              @endphp

              <div class="d-flex flex-wrap gap-2 mt-2">
                @foreach ($fotoPaths as $path)
                  <img src="{{ asset('storage/' . $path) }}"
                      alt="Foto Usaha"
                      class="img-thumbnail"
                      style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                      onclick="tampilkanGambar('{{ asset('storage/' . $path) }}')">
                @endforeach
              </div>
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

            <hr>

            {{-- Informasi dari profil_pembudidaya --}}
            @php
              $profil = $dokumen->pembudidaya->profil;
            @endphp

            @if($profil)
              <div class="mb-3"><strong>Alamat:</strong> {{ $profil->alamat ?? '-' }}</div>
              <div class="mb-3"><strong>Nomor Telepon:</strong> {{ $profil->nomor_telepon ?? '-' }}</div>
              <div class="mb-3">
                <strong>Deskripsi Usaha:</strong><br>
                <p>{{ $profil->deskripsi ?? '-' }}</p>
              </div>
              <div class="mb-3">
                <strong>Foto Profil:</strong><br>
                <img src="{{ asset('storage/' . $profil->foto_profil) }}" alt="Foto Profil" class="img-thumbnail shadow-sm mt-2" style="max-width: 150px; height: auto;">
              </div>
            @else
              <div class="mb-3 text-muted">
                <em>Profil pembudidaya belum dilengkapi.</em>
              </div>
            @endif

            <a href="{{ route('admin.pembudidaya.index') }}" class="btn btn-secondary">
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
    document.getElementById('previewGambar').src = src;
    $('#gambarPreviewModal').modal('show');
  }
</script>
</html>
