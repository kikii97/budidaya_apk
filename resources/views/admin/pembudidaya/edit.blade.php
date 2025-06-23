<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Pembudidaya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AdminLTE & FontAwesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  @include('admin.partials.navbar')
  @include('admin.partials.sidebar')

  <div class="content-wrapper">
    <section class="content pt-4">
      <div class="container-fluid">
        <h2>Edit Pembudidaya</h2>

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ str_replace([
                    'The password field confirmation does not match.',
                    'The email has already been taken.',
                    'The password field must be at least 6 characters.'
                ], [
                    'Konfirmasi kata sandi tidak cocok.',
                    'Email sudah terdaftar.',
                    'Kata sandi harus terdiri dari minimal 6 karakter.'
                ], $error) }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('admin.pembudidaya.update', $pembudidaya->id) }}" method="POST" class="mb-5">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required
              value="{{ old('name', $pembudidaya->name) }}"
              oninvalid="this.setCustomValidity('Harap isi nama lengkap.')"
              oninput="this.setCustomValidity('')">
          </div>

          <div class="form-group mt-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required
              value="{{ old('email', $pembudidaya->email) }}"
              oninvalid="this.setCustomValidity('Harap masukkan email yang valid.')"
              oninput="this.setCustomValidity('')">
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
              oninput="this.setCustomValidity('')">{{ old('address', $pembudidaya->address) }}</textarea>
          </div>

          <button type="submit" class="btn btn-warning mt-3">
            <i class="fas fa-save"></i> Update
          </button>
          <a href="{{ route('admin.pembudidaya.index') }}" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </form>
      </div>
    </section>
  </div>

  <footer class="main-footer text-sm text-center">
    <strong>&copy; {{ date('Y') }} Admin Panel.</strong> All rights reserved.
  </footer>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- Toggle Password Script -->
<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const input = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    } else {
      input.type = 'password';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    }
  });

  document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
    const input = document.getElementById('password_confirmation');
    const icon = document.getElementById('confirmEyeIcon');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    } else {
      input.type = 'password';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    }
  });
</script>
</body>
</html>
