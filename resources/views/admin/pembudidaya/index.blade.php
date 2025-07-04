<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Pembudidaya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AdminLTE CSS -->
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
        <h1 class="mb-4">Manajemen Pembudidaya</h1>

        {{-- Alert Success --}}
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        {{-- Alert Error --}}
        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <a href="{{ route('admin.pembudidaya.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Tambah Pembudidaya
        </a>

        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th style="width: 50px;">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Dokumen</th>
                <th style="width: 120px;">Status</th>
                <th style="width: 200px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($pembudidaya as $index => $item)
                <tr>
                  <td>{{ $pembudidaya->firstItem() + $index }}</td>
                  <td>{{ $item->name }}</td>
                  <td class="text-truncate" style="max-width: 200px;">{{ $item->email }}</td>

                  {{-- Dokumen --}}
                  <td>
                    @php 
                      $dokumen = $item->dokumenPembudidaya; 
                      $suratPaths = $dokumen && $dokumen->surat_usaha_path 
                        ? (is_array(json_decode($dokumen->surat_usaha_path, true)) 
                          ? json_decode($dokumen->surat_usaha_path, true) 
                          : [$dokumen->surat_usaha_path]) 
                        : [];

                      $fotoPaths = $dokumen && $dokumen->foto_usaha_path 
                        ? (is_array(json_decode($dokumen->foto_usaha_path, true)) 
                          ? json_decode($dokumen->foto_usaha_path, true) 
                          : [$dokumen->foto_usaha_path]) 
                        : [];
                    @endphp

                    {{-- Tampilkan Surat Usaha --}}
                    @foreach ($suratPaths as $path)
                      <a href="{{ asset('storage/' . $path) }}" target="_blank" class="btn btn-sm btn-info d-block mb-1" style="font-size: 0.75rem;">
                        <i class="fas fa-file-alt"></i> {{ basename($path) }}
                      </a>
                    @endforeach

                    {{-- Tampilkan Foto Usaha --}}
                    @foreach ($fotoPaths as $path)
                      <img src="{{ asset('storage/' . $path) }}" alt="Foto Usaha" class="img-thumbnail mb-1" style="width: 90px;">
                    @endforeach

                    @if (empty($suratPaths) && empty($fotoPaths))
                      <span class="text-muted">Tidak ada dokumen</span>
                    @endif
                  </td>

                  {{-- Status --}}
                  <td>
                    @if (!$dokumen)
                      <span class="badge bg-secondary"><i class="fas fa-minus-circle"></i> Belum Upload</span>
                    @else
                      @if ($dokumen->status === 'disetujui')
                          <span class="badge bg-success"><i class="fas fa-check-circle"></i> Disetujui</span>
                      @elseif ($dokumen->status === 'ditolak')
                          <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Ditolak</span>
                      @else
                          <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Menunggu</span>
                      @endif
                    @endif
                  </td>

                  {{-- Aksi --}}
                  <td class="text-nowrap">
                    @if ($dokumen)
                      <a href="{{ route('admin.dokumen.show', $dokumen->id) }}" class="btn btn-sm btn-primary mb-1">
                        <i class="fas fa-eye"></i> Detail
                      </a>

                      @if ($dokumen->status === 'menunggu')
                        <form action="{{ route('admin.dokumen.approve', $dokumen->id) }}" method="POST" style="display:inline-block;">
                          @csrf
                          <button type="submit" class="btn btn-sm btn-success mb-1" onclick="return confirm('Setujui dokumen pembudidaya ini?')">
                              <i class="fas fa-check"></i> Setujui
                          </button>
                        </form>
                        <form action="{{ route('admin.dokumen.reject', $dokumen->id) }}" method="POST" style="display:inline-block;">
                          @csrf
                          <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Tolak dokumen pembudidaya ini?')">
                              <i class="fas fa-times"></i> Tolak
                          </button>
                        </form>
                      @else
                        <form action="{{ route('admin.pembudidaya.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                              <i class="fas fa-trash"></i> Hapus
                          </button>
                        </form>
                      @endif
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted">Tidak ada data pembudidaya.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $pembudidaya->links() }}
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
</body>
</html>
