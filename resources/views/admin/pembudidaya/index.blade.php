@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Manajemen Pembudidaya</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
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
                    <th>Alamat</th>
                    <th>Dokumen</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembudidaya as $index => $item)
                    <tr>
                        <td>{{ $index + 1 + ($pembudidaya->currentPage() - 1) * $pembudidaya->perPage() }}</td>
                        <td class="text-wrap">{{ $item->name }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ $item->email }}</td>
                        <td class="text-wrap" style="max-width: 300px;">{{ $item->address ?? '-' }}</td>
                        <td>
                            @php
                                $dokumen = json_decode($item->documents, true);
                            @endphp

                            @if ($dokumen)
                                @foreach ($dokumen as $doc)
                                    @php
                                        $file_path = str_replace('\\/', '/', $doc);
                                        $extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
                                    @endphp

                                    @if (in_array($extension, ['pdf', 'doc', 'docx']))
                                        <a href="{{ asset('storage/' . $file_path) }}" class="btn btn-sm btn-info d-block mb-2" target="_blank" style="font-size: 0.8rem;">
                                            <i class="fas fa-file-alt"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <img src="{{ asset('storage/' . $file_path) }}" alt="Dokumen" class="img-thumbnail mb-2" style="width: 100px;">
                                    @endif
                                @endforeach
                            @else
                                <span class="text-muted">Tidak ada dokumen</span>
                            @endif
                        </td>

                        <td>
                            @if (is_null($item->is_approved))
                                <span class="badge bg-secondary">Menunggu</span>
                            @elseif ($item->is_approved)
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>

                        <td class="text-nowrap">
                            @if (is_null($item->is_approved))
                                {{-- Tombol Setujui --}}
                                <form action="{{ route('admin.pembudidaya.approve', $item->id) }}" method="POST" style="display:inline-block; margin-bottom:5px;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui pembudidaya ini?')">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>

                                {{-- Tombol Tolak --}}
                                <form action="{{ route('admin.pembudidaya.reject', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Tolak pembudidaya ini?')">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </form>
                            @else
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.pembudidaya.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data pembudidaya.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $pembudidaya->links() }}
    </div>
</div>
@endsection
