<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Pengguna</title>
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

        <h2 class="mb-4">Edit Pengguna</h2>

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

        <form action="{{ route('admin.pengguna.update', $pengguna->id) }}" method="POST" class="mb-5">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $pengguna->name }}" required
              oninvalid="this.setCustomValidity('Harap isi nama anda.')" 
              oninput="this.setCustomValidity('')">
          </div>

          <div class="form-group mt-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $pengguna->email }}" required
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

          <button class="btn btn-warning mt-3"><i class="fas fa-save"></i> Update</button>
          <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Kembali</a>
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

<!-- Toggle Password -->
<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
    } else {
      passwordInput.type = 'password';
      eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
    }
  });

  document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
    const confirmInput = document.getElementById('password_confirmation');
    const confirmEyeIcon = document.getElementById('confirmEyeIcon');
    if (confirmInput.type === 'password') {
      confirmInput.type = 'text';
      confirmEyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
    } else {
      confirmInput.type = 'password';
      confirmEyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
    }
  });
</script>
</body>
</html>
