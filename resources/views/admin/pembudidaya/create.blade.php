@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Tambah Pembudidaya</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ str_replace(['The password field confirmation does not match.', 'The email has already been taken.', 'The password field must be at least 6 characters.'], 
                ['Konfirmasi kata sandi tidak cocok.', 'Email sudah terdaftar.', 'Kata sandi harus terdiri dari minimal 6 karakter.'], $error) }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('admin.pembudidaya.store') }}" method="POST">
        @csrf
        <div class="form-group mt-2">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required
                oninvalid="this.setCustomValidity('Harap isi nama lengkap.')"
                oninput="this.setCustomValidity('')">
        </div>

        <div class="form-group mt-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required
                oninvalid="this.setCustomValidity('Harap masukkan email yang valid.')"
                oninput="this.setCustomValidity('')">
        </div>

        <div class="form-group mt-2">
            <label>Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required
                oninvalid="this.setCustomValidity('Harap isi Password.')" 
                oninput="this.setCustomValidity('')">
                <span class="input-group-text bg-white">
                    <button type="button" class="btn btn-sm p-0 border-0 bg-transparent" id="togglePassword">
                        <i class="fas fa-eye-slash" id="eyeIcon"></i>
                    </button>
                </span>
            </div>
        </div>

        <div class="form-group mt-2">
            <label>Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required
                oninvalid="this.setCustomValidity('Harap isi konfirmasi Password.')" 
                oninput="this.setCustomValidity('')">
                <span class="input-group-text bg-white">
                    <button type="button" class="btn btn-sm p-0 border-0 bg-transparent" id="toggleConfirmPassword">
                        <i class="fas fa-eye-slash" id="confirmEyeIcon"></i>
                    </button>
                </span>
            </div>
        </div>

        <div class="form-group mt-2">
            <label>Alamat</label>
            <textarea name="address" class="form-control" rows="3" required
            oninvalid="this.setCustomValidity('Harap isi alamat anda.')"
            oninput="this.setCustomValidity('')"></textarea>
        </div>

        <button class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('admin.pembudidaya.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>

@include('admin.partials.toggle-password-js')
@endsection
