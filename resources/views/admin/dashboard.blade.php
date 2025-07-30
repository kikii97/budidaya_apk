<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
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

        {{-- Statistik Singkat --}}
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{ $jumlahPengguna }}</h3>
                <p>Pengguna</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-tie"></i>
              </div>
              <a href="{{ route('admin.pengguna.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $jumlahPembudidaya }}</h3>
                <p>Pembudidaya</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="{{ route('admin.pembudidaya.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $jumlahKomoditas }}</h3>
                <p>Komoditas</p>
              </div>
              <div class="icon">
                <i class="fas fa-box"></i>
              </div>
              <a href="{{ route('admin.produk.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>

          {{-- Judul Tabel Pembudidaya Menunggu Persetujuan --}}
          <div class="px-2 pt-2 pb-1">
            <h5 class="mb-3" style="font-weight: bold; color: #000;">
              <i class="fas fa-clock" style="color: #000;"></i> Pembudidaya Menunggu Persetujuan
            </h5>
          </div>

          <div class="table-responsive border rounded">
            <table class="table table-bordered table-striped table-hover align-middle mb-0">
              <thead class="table-dark text-center">
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
                @forelse($pembudidayaMenunggu as $index => $pb)
                  @php $dokumen = $pb->dokumenPembudidaya; @endphp
                  <tr>
                    <td class="text-center">{{ $pembudidayaMenunggu->firstItem() + $index }}</td>
                    <td>{{ $pb->name }}</td>
                    <td class="text-truncate" style="max-width: 200px;">{{ $pb->email }}</td>

                    {{-- Dokumen --}}
                    <td>
                      @if ($dokumen && ($dokumen->surat_usaha_path || $dokumen->foto_usaha_path))
                        @php 
                          $suratPaths = $dokumen->surat_usaha_path 
                            ? (is_array(json_decode($dokumen->surat_usaha_path, true)) 
                                ? json_decode($dokumen->surat_usaha_path, true) 
                                : [$dokumen->surat_usaha_path]) 
                            : [];

                          $fotoPaths = $dokumen->foto_usaha_path 
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
                      @else
                        <span class="text-muted">Tidak ada dokumen</span>
                      @endif
                    </td>

                    {{-- Status --}}
                    <td class="text-center">
                      <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Menunggu</span>
                    </td>

                    {{-- Aksi --}}
                    <td class="text-nowrap text-center">
                      <a href="{{ route('admin.dokumen.show', $dokumen->id) }}" class="btn btn-sm btn-primary mb-1">
                        <i class="fas fa-eye"></i> Detail
                      </a>
                      <form action="{{ route('admin.dokumen.approve', $dokumen->id) }}" method="POST" class="d-inline-block mb-1">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui dokumen pembudidaya ini?')">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                      </form>
                      <form action="{{ route('admin.dokumen.reject', $dokumen->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Tolak dokumen pembudidaya ini?')">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada pembudidaya yang menunggu.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-center mt-3">
            {{ $pembudidayaMenunggu->links() }}
          </div>

          {{-- Tabel Komoditas Menunggu Persetujuan --}}
          <div class="px-2 pt-2 pb-1">
            <h5 class="mb-3" style="font-weight: bold; color: #000;">
              <i class="fas fa-clock" style="color: #000;"></i> Komoditas Menunggu Persetujuan
            </h5>
          </div>

          <div class="table-responsive border rounded">
            <table class="table table-bordered table-striped table-hover align-middle mb-0">
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
                @forelse($produkMenunggu as $index => $item)
                  <tr>
                    <td class="text-center">{{ $produkMenunggu->firstItem() + $index }}</td>
                    {{-- Gambar --}}
                    <td>
                      @php $gambarList = json_decode($item->gambar, true); @endphp
                      @if (!empty($gambarList) && is_array($gambarList))
                        <div class="d-flex flex-wrap gap-1" style="max-width: 150px;">
                          @foreach ($gambarList as $gambar)
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
                      <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Menunggu</span>
                    </td>
                    {{-- Aksi --}}
                    <td class="text-nowrap text-center">
                      <a href="{{ route('admin.produk.detail', $item->id) }}" class="btn btn-sm btn-primary mb-1" data-bs-toggle="tooltip" title="Lihat Detail">
                        <i class="fas fa-eye"></i> Detail
                      </a>

                      <form action="{{ route('admin.produk.approve', $item->id) }}" method="POST" class="d-inline-block mb-1">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui komoditas ini?')">
                          <i class="fas fa-check"></i> Setujui
                        </button>
                      </form>

                      <form action="{{ route('admin.produk.reject', $item->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Tolak komoditas ini?')">
                          <i class="fas fa-times"></i> Tolak
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="15" class="text-center text-muted">Tidak ada produk yang menunggu.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- Pagination --}}
          <div class="d-flex justify-content-center mt-3">
            {{ $produkMenunggu->links() }}
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
