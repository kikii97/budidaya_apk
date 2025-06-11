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
                        <td>{{ $index + 1 + ($pembudidaya->currentPage() - 1) * $pembudidaya->perPage() }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ $item->email }}</td>
                        {{-- Dokumen --}}
                        <td>
                            @php
                                $dokumen = $item->dokumenPembudidaya;
                            @endphp

                            @if ($dokumen && ($dokumen->surat_usaha_path || $dokumen->foto_usaha_path))
                                {{-- Surat Usaha --}}
                                @if ($dokumen->surat_usaha_path)
                                    @php
                                        $suratExtension = pathinfo($dokumen->surat_usaha_path, PATHINFO_EXTENSION);
                                    @endphp
                                    @if (in_array(strtolower($suratExtension), ['pdf', 'doc', 'docx']))
                                        <a href="{{ asset('storage/' . $dokumen->surat_usaha_path) }}" class="btn btn-sm btn-info d-block mb-2" target="_blank" style="font-size: 0.8rem;">
                                            <i class="fas fa-file-alt"></i> Lihat Surat Usaha
                                        </a>
                                    @endif
                                @endif

                                {{-- Foto Usaha --}}
                                @if ($dokumen->foto_usaha_path)
                                    <img src="{{ asset('storage/' . $dokumen->foto_usaha_path) }}" alt="Foto Usaha" class="img-thumbnail mb-2" style="width: 100px;">
                                @endif
                            @else
                                <span class="text-muted">Tidak ada dokumen</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            @if (!$item->dokumenPembudidaya)
                                <span class="badge bg-secondary"><i class="fas fa-minus-circle"></i> Belum Upload</span>
                            @else
                                @php $status = $item->dokumenPembudidaya->status; @endphp
                                @if ($status === 'disetujui')
                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Disetujui</span>
                                @elseif ($status === 'ditolak')
                                    <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Menunggu</span>
                                @endif
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="text-nowrap">
                            @if ($item->dokumenPembudidaya)
                                {{-- Tombol Detail selalu ditampilkan --}}
                                <a href="{{ route('admin.dokumen.show', $item->dokumenPembudidaya->id) }}" class="btn btn-sm btn-primary mb-1">
                                    <i class="fas fa-eye"></i> Detail
                                </a>

                                @if ($item->dokumenPembudidaya->status === 'menunggu')
                                    <form action="{{ route('admin.dokumen.approve', $item->dokumenPembudidaya->id) }}" method="POST" style="display:inline-block; margin-bottom:5px;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui dokumen pembudidaya ini?')">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.dokumen.reject', $item->dokumenPembudidaya->id) }}" method="POST" style="display:inline-block;">
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
