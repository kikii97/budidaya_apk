@extends('admin.dashboard')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Detail Dokumen Pembudidaya</h5>
    </div>
    <div class="card-body">
        <!-- Informasi Umum Pembudidaya -->
        <div class="mb-3">
            <strong>Nama:</strong> {{ $dokumen->pembudidaya->name }}
        </div>
        <div class="mb-3">
            <strong>Email:</strong> {{ $dokumen->pembudidaya->email }}
        </div>
        <div class="mb-3">
            <strong>Status:</strong> 
            <span class="badge 
                @if($dokumen->status === 'disetujui') bg-success 
                @elseif($dokumen->status === 'ditolak') bg-danger 
                @else bg-warning text-dark @endif">
                {{ ucfirst($dokumen->status) }}
            </span>
        </div>
        <div class="mb-3">
            <strong>Keterangan:</strong> {{ $dokumen->keterangan ?? '-' }}
        </div>

        <hr>

        <!-- Dokumen Usaha -->
        <div class="mb-4">
            <strong>Surat Usaha:</strong><br>
            <a href="{{ asset('storage/' . $dokumen->surat_usaha_path) }}" class="btn btn-outline-info btn-sm mt-1" target="_blank">
                <i class="fas fa-file-alt"></i> Lihat Surat Usaha ({{ basename($dokumen->surat_usaha_path) }})
            </a>
        </div>

        <div class="mb-4">
            <strong>Foto Usaha:</strong><br>
            <img src="{{ asset('storage/' . $dokumen->foto_usaha_path) }}" alt="Foto Usaha" class="img-thumbnail shadow-sm mt-2" style="max-width: 300px; height: auto;">
        </div>

        <hr>

        <!-- Informasi Profil dari profil_pembudidaya -->
        @php
            $profil = $dokumen->pembudidaya->profil;
        @endphp

        @if($profil)
            <div class="mb-3">
                <strong>Alamat:</strong> {{ $profil->alamat ?? '-' }}
            </div>
            <div class="mb-3">
                <strong>Nomor Telepon:</strong> {{ $profil->nomor_telepon ?? '-' }}
            </div>
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

        <!-- Tombol Kembali -->
        <a href="{{ route('admin.pembudidaya.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
