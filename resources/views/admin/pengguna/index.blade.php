@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Manajemen Pengguna</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Pembudidaya
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
                        <td class="text-truncate" style="max-width: 200px;">
                            {{ $item->email }}
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.pengguna.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>                          
                            <form action="{{ route('admin.pengguna.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Tidak ada data pengguna.</td>
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
@endsection
