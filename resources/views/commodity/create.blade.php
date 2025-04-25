@extends('layouts.app')

@section('content')
<h2>Tambah Komoditas</h2>
<form action="{{ route('commodity.store') }}" method="POST">
    @csrf
    <label>Nama Komoditas:</label>
    <input type="text" name="name" required><br>
    <label>Icon (optional):</label>
    <input type="text" name="icon"><br>
    <button type="submit">Simpan</button>
</form>
@endsection
