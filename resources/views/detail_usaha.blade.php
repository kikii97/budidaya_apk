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
                        <div style="
                            width: 100px;
                            height: 100px;
                            border-radius: 50%;
                            overflow: hidden;
                            background-color: #f0f0f0;
                            flex-shrink: 0;
                        ">
                            <img src="{{ $pembudidaya->profil && $pembudidaya->profil->foto_profil
                                        ? asset('storage/' . $pembudidaya->profil->foto_profil)
                                        : asset('images/akun.jpg') }}"
                                alt="profile"
                                style="
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                    display: block;
                                ">
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
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-2 gap-2 text-body">
                                <p class="lead fw-normal mb-0">Produk Saya</p>
                            <form id="bulkDeleteForm" action="{{ route('pembudidaya.pembudidaya.produk.destroy.multiple') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk yang dipilih?');">
                            @csrf
                            @method('DELETE')
                            @if ($isOwner && count($produk))
                                <div class="d-flex align-items-center gap-2" style="line-height: 1;">
                                    <div class="d-flex align-items-center" style="gap: 6px;">
                                        <input type="checkbox" id="selectAllCheckbox" class="form-check-input" style="transform: scale(1.3); margin-top: 0.1rem;">
                                        <label for="selectAllCheckbox" class="form-check-label text-muted" style="font-size: 13px;">Pilih Semua</label>
                                    </div>
                                    <button type="submit" form="bulkDeleteForm" class="btn btn-sm btn-outline-danger">
                                        Hapus Produk Terpilih
                                    </button>
                                </div>
                            @endif
                            </div>
                                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4 row-cols-lg-5 g-3">
                                    @foreach ($produk as $item)
                                        <div class="col">
                                            <div class="card position-relative">
                                                @if ($isOwner)
                                                    <input type="checkbox" name="produk_ids[]" value="{{ $item->id }}"
                                                        class="form-check-input produk-checkbox position-absolute top-0 start-0 m-1"
                                                        style="z-index: 2; transform: scale(1.3);">
                                                @endif

                                                <img src="{{ asset('storage/images/' . ($item->gambar_utama ?? 'default.jpg')) }}"
                                                    alt="image" class="card-img-top img-fixed-ratio">

                                                <div class="card-body text-center p-2">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="{{ route('produk.detail', $item->id) }}"
                                                            class="btn btn-sm btn-outline-primary">Detail</a>
                                                        @if ($isOwner)
                                                            <a href="{{ route('pembudidaya.produk.edit', $item->id) }}"
                                                                class="btn btn-sm btn-outline-secondary">Edit</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<style>
@media (max-width: 576px) {
    .form-check-input {
        transform: scale(1.2);
        margin-right: 4px;
    }

    .btn-outline-danger {
        font-size: 12px;
        padding: 4px 8px;
    }

    .card-img-top {
        height: 90px;
    }

    .card-body .btn {
        font-size: 12px;
        padding: 4px 6px;
    }
    .card-body {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    }
    .img-fixed-ratio {
    aspect-ratio: 4 / 3;
    width: 100%;
    object-fit: cover;
    }
}
</style>
<script>
    document.getElementById('selectAllCheckbox')?.addEventListener('change', function () {
        document.querySelectorAll('.produk-checkbox').forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection
