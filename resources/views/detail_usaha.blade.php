@extends('layouts.app')

@section('title', 'Detail Usaha - SIBIKANDA')@section('header')
@include('partials.header')
@endsection

@section('content')
@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::guard('pembudidaya')->user();
    $isOwner = $user && $pembudidaya && $user->id === $pembudidaya->id;
@endphp

<section style="padding-top: 0px;">
    <div class="container py-2" style="padding-top: 0rem !important;">
        <div class="row d-flex justify-content-center">
            <div class="col">

                <div class="rounded-top text-white d-flex flex-wrap align-items-center justify-content-between p-3">
                    <div class="d-flex align-items-center" style="gap: 15px;">
                        <div style="width: 120px;">
                        <img src="{{ $pembudidaya->profil && $pembudidaya->profil->foto_profil
                                    ? asset('storage/' . $pembudidaya->profil->foto_profil)
                                    : asset('images/akun.jpg') }}"
                            alt="profile"
                            class="img-fluid img-thumbnail rounded-circle"
                            style="width: 100px; z-index: 1;">
                        </div>
                        <div>
                            <h5 class="mb-1 text-dark">{{ $pembudidaya->name ?? 'Nama Pengguna' }}</h5>
                            <p class="mb-0" style="color:#005a8e;">
                                {{ $pembudidaya->profil->alamat ?? 'Alamat belum tersedia' }}
                            </p>
                        </div>
                    </div>

                @if ($isOwner)
                    <div class="d-flex gap-2 mt-2 mt-md-0">
                        <a href="{{ route('pembudidaya.edit') }}" class="btn btn-outline-secondary text-body">
                            Edit Profile
                        </a>

                        @if ($user->dokumenPembudidaya && $user->dokumenPembudidaya->status === 'disetujui')
                            <a href="{{ route('pembudidaya.unggah') }}" class="btn btn-outline-secondary text-body">
                                Unggah Produk
                            </a>
                        @else
                            <a href="{{ route('pembudidaya.dokumen.create') }}" class="btn btn-outline-secondary text-body">
                                Unggah Dokumen
                            </a>
                        @endif
                    </div>
                @endif

                </div>

                <div class="mt-0 p-4 text-black mb-3" style="font-size: 80%;">
                    <p class="lead fw-normal mb-1">Tentang Usaha</p>
                    <div class="p-4 bg-body-tertiary mb-5">
                    <p class="font-italic mb-1">
                        {{ $pembudidaya->profil->deskripsi ?? 'Belum ada deskripsi usaha.' }}
                    </p>
                    </div>
                    <div class="d-flex flex-row gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-2 text-body">
                                <p class="lead fw-normal mb-0">Produk Saya</p>
                                @if ($isOwner)
                                    <p class="mb-0">
                                        <a href="#!" class="text-muted" style="font-size: 12px;">Pilih Semua</a>
                                    </p>
                                @endif
                            </div>
                            <div class="d-flex overflow-auto gap-2">
                                @foreach ($produk as $item)
                                    <div class="position-relative mt-2 me-3" style="width: 100px;">
                                        <img src="{{ asset('storage/images/' . ($item->gambar_utama ?? 'default.jpg')) }}"
                                            alt="image" class="rounded-3 img-fluid" style="height: auto;">

                                        @if ($isOwner)
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('pembudidaya.produk.destroy', $item->id) }}"
                                                method="POST" class="position-absolute top-0 end-0 m-1"
                                                onsubmit="return confirm('Yakin ingin menghapus produk ini?');"
                                                style="transform: translate(50%, -50%);">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-close"
                                                    style="font-size: 13px; background-color: rgba(0, 0, 0, 0.203); border-radius: 50%; border: 2px solid white;"
                                                    aria-label="Close">
                                                </button>
                                            </form>
                                        @endif

                                        <div class="d-flex justify-content-center gap-1 mt-3">
                                            <a href="{{ route('pembudidaya.produk.detail', $item->id) }}"
                                                class="btn btn-sm btn-outline-primary"
                                                style="font-size: 12px;">Detail</a>

                                            @if ($isOwner)
                                                <a href="{{ route('pembudidaya.produk.edit', $item->id) }}"
                                                    class="btn btn-sm btn-outline-secondary"
                                                    style="font-size: 12px;">Edit</a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
