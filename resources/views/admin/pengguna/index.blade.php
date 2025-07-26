<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Pengguna</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  {{-- Navbar dan Sidebar --}}
  @include('admin.partials.navbar')
  @include('admin.partials.sidebar')

  <div class="content-wrapper">
    <section class="content pt-3">
      <div class="container-fluid">
        <h1 class="mb-4">Manajemen Pengguna</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Tambah Pengguna
        </a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengguna as $index => $item)
                        <tr>
                            <td>{{ $pengguna->firstItem() + $index }}</td>
                            <td class="text-wrap">{{ $item->name }}</td>
                            <td class="text-truncate" style="max-width: 200px;">{{ $item->email }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.pengguna.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.pengguna.destroy', $item->id) }}" method="POST" style="display:inline-block; margin-left: 4px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $pengguna->links() }}
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
