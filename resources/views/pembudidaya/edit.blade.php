@extends('layouts.app')

@section('title', 'Edit Profil')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="container py-4">
    <!-- Back arrow -->
    <a href="{{ url()->previous() }}" class="text-muted">
        <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>

    <div class="card p-3 mt-2">
        <form action="{{ route('pembudidaya.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name', $pembudidaya->name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control">{{ old('alamat', optional($pembudidaya->profil)->alamat) }}</textarea>
            </div>

            <div class="mb-3">
                <label>Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', optional($pembudidaya->profil)->nomor_telepon) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ old('deskripsi', optional($pembudidaya->profil)->deskripsi) }}</textarea>
            </div>

            <div class="mb-3">
                <label>Foto Profil</label>
                <input type="file" name="foto_profile" class="form-control">
                @if ($pembudidaya->profil && $pembudidaya->profil->foto_profil)
                    <small class="d-block mt-2">Foto saat ini:</small>
                    <img src="{{ asset('storage/' . $pembudidaya->profil->foto_profil) }}" alt="Foto Profil" width="100" class="mb-2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="hapusFoto" name="hapus_foto">
                        <label class="form-check-label" for="hapusFoto">Hapus foto profil</label>
                    </div>
                @else
                    <p class="text-muted mt-2">Belum ada foto profil</p>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
