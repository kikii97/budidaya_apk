@extends('layouts.app')

@section('content')
<h2>Data Komoditas</h2>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Form Input --}}
<div class="card mb-4">
    <div class="card-header">Tambah Komoditas</div>
    <div class="card-body">
        <form action="{{ route('commodity.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Komoditas</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Pilih Icon</label>
                <div class="mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="icon" value="🦐" id="icon1">
                        <label class="form-check-label" for="icon1">
                            🦐
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="icon" value="🌿" id="icon2">
                        <label class="form-check-label" for="icon2">
                            🌿
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="icon" value="🐟" id="icon3">
                        <label class="form-check-label" for="icon3">
                            🐟
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="icon" value="🐠" id="icon4">
                        <label class="form-check-label" for="icon4">
                            🐠
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="icon" value="🐡" id="icon5">
                        <label class="form-check-label" for="icon5">
                            🐡
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="icon" value="🎏" id="icon6">
                        <label class="form-check-label" for="icon6">
                            🎏
                        </label>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
</div>

{{-- List Tabel --}}
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Komoditas</th>
            <th>Icon</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td style="font-size: 1.5rem;">{{ $item->icon }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">Belum ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
