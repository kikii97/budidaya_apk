@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Edit Pembudidaya</h2>

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


    <form action="{{ route('admin.pembudidaya.update', $pembudidaya->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mt-2">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required
                oninvalid="this.setCustomValidity('Harap isi nama lengkap.')"
                oninput="this.setCustomValidity('')"
                value="{{ old('name', $pembudidaya->name) }}">
        </div>

        <div class="form-group mt-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required
                oninvalid="this.setCustomValidity('Harap masukkan email yang valid.')"
                oninput="this.setCustomValidity('')"
                value="{{ old('email', $pembudidaya->email) }}">
        </div>

        <div class="form-group mt-2">
            <label>Password (kosongkan jika tidak diubah)</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control">
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
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                <span class="input-group-text bg-white">
                    <button type="button" class="btn btn-sm p-0 border-0 bg-transparent" id="toggleConfirmPassword">
                        <i class="fas fa-eye-slash" id="confirmEyeIcon"></i>
                    </button>
                </span>
            </div>
        </div>

        <div class="form-group mt-2">
            <label>Alamat</label>
            <textarea name="address" class="form-control" rows="3"
            oninvalid="this.setCustomValidity('Harap isi alamat anda.')"
            oninput="this.setCustomValidity('')">
            {{ old('address', $pembudidaya->address) }}</textarea>
        </div>

        <button class="btn btn-warning mt-3">Update</button>
        <a href="{{ route('admin.pembudidaya.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>

@include('admin.partials.toggle-password-js')
@endsection
