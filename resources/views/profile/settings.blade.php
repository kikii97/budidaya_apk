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
    <div class="card p-3 mt-2" style="zoom: 80%">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control">{{ $user->alamat }}</textarea>
            </div>
            <div class="mb-3">
                <label>Jenis Usaha</label>
                <input type="text" name="jenis_usaha" value="{{ $user->jenis_usaha }}" class="form-control">
            </div>
            <div class="mb-3">
                <label>Foto Profil</label>
                <input type="file" name="foto_profile" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
