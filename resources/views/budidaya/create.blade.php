@extends('layouts.app')

@section('content')
<h2>Tambah Budidaya</h2>
<form action="{{ route('budidaya.store') }}" method="POST">
    @csrf
    <label>Jenis Komoditas:</label>
    <select name="commodity_type_id" required>
        @foreach($commodities as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </select><br>

    <label>Nama Lokasi:</label>
    <input type="text" name="name" required><br>

    <label>Deskripsi:</label>
    <textarea name="description"></textarea><br>

    <label>Latitude:</label>
    <input type="text" name="latitude" required><br>

    <label>Longitude:</label>
    <input type="text" name="longitude" required><br>

    <button type="submit">Simpan</button>
</form>
@endsection
