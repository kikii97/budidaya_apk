@extends('layouts.app')

@section('title', 'Edit Profil')

<!-- Header Navbar -->
@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="container py-4" style="padding-top: 1rem !important;">
    <!-- Back arrow icon -->
    <a href="{{ url()->previous() }}" class="text-muted" style="">
        <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
    <div class="card p-3 mt-2">
        <form action="{{ route('pembudidaya.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" value="{{ $pembudidaya->name }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control">{{ $pembudidaya->alamat }}</textarea>
            </div>
            <div class="mb-3">
                <label>Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ $pembudidaya->nomor_telepon }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ $pembudidaya->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label>Foto Profil</label>
                <input type="file" name="foto_profile" class="form-control">
                <small>Foto sekarang:</small><br>
                @if ($pembudidaya->profil && $pembudidaya->profil->foto_profil)
                    <img src="{{ asset('storage/' . $pembudidaya->profil->foto_profil) }}" alt="Foto Profil" width="100">
                @else
                    <p class="text-muted">Belum ada foto profil</p>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
