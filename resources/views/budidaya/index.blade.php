@extends('layouts.app')

@section('content')
<h2>Data Budidaya</h2>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Form Input --}}
<div class="card mb-4">
    <div class="card-header">Tambah Budidaya</div>
    <div class="card-body">
        <form action="{{ route('budidaya.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Jenis Komoditas</label>
                <select name="commodity_type_id" class="form-control" required>
                    <option value="">-- Pilih Komoditas --</option>
                    @foreach($commodities as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Nama Lokasi Budidaya</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Desa Sumber Rejeki" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" placeholder="Deskripsi singkat tentang lokasi budidaya"></textarea>
            </div>

            <div class="mb-3">
                <label>Profil Usaha</label>
                <textarea name="profil_usaha" class="form-control" placeholder="Profil usaha budidaya, misal: Usaha budidaya rumput laut skala kecil"></textarea>
            </div>

            <div class="mb-3">
                <label>Kapasitas Usaha</label>
                <input type="text" name="kapasitas_usaha" class="form-control" placeholder="Contoh: 500 Kg per bulan" required>
            </div>

            <div class="mb-3">
                <label>Proses Budidaya</label>
                <textarea name="proses_budidaya" class="form-control" placeholder="Deskripsikan proses budidaya rumput laut"></textarea>
            </div>

            <div class="mb-3">
                <label>Kendala Produksi</label>
                <input type="text" name="kendala_produksi" class="form-control" placeholder="Contoh: Cuaca buruk atau hama">
            </div>

            <div class="mb-3">
                <label>Masa Produksi Puncak</label>
                <input type="text" name="masa_puncak_produksi" class="form-control" placeholder="Contoh: 6 bulan setelah tanam">
            </div>

            <div class="mb-3">
                <label>Produksi Tahunan</label>
                <input type="text" name="produksi_tahunan" class="form-control" placeholder="Contoh: 6000 Kg per tahun">
            </div>

            <div class="mb-3">
                <label>Pemasaran</label>
                <input type="text" name="pemasaran" class="form-control" placeholder="Contoh: Pasar lokal dan ekspor">
            </div>

            <div class="mb-3">
                <label>Kisaran Harga</label>
                <input type="text" name="kisaran_harga" class="form-control" placeholder="Contoh: Rp 15.000 - Rp 20.000 per Kg">
            </div>

            <div class="mb-3">
                <label>Uji Kualitas Air</label>
                <textarea name="uji_kualitas_air" class="form-control" placeholder="Deskripsi uji kualitas air yang dilakukan"></textarea>
            </div>

            <div class="mb-3">
                <label>Latitude</label>
                <input type="text" name="latitude" class="form-control" placeholder="Contoh: -6.987654" required>
            </div>

            <div class="mb-3">
                <label>Longitude</label>
                <input type="text" name="longitude" class="form-control" placeholder="Contoh: 107.123456" required>
            </div>

            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

{{-- List Tabel --}}
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Komoditas</th>
            <th>Nama Lokasi</th>
            <th>Deskripsi</th>
            <th>Profil Usaha</th>
            <th>Kapasitas Usaha</th>
            <th>Latitude</th>
            <th>Longitude</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->commodityType->name }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ $item->profil_usaha }}</td>
            <td>{{ $item->kapasitas_usaha }}</td>
            <td>{{ $item->latitude }}</td>
            <td>{{ $item->longitude }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">Belum ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
