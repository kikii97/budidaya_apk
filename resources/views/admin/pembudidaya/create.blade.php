<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Pembudidaya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS AdminLTE & FontAwesome -->
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
        <h2>Tambah Pembudidaya</h2>

        {{-- Tampilkan error validasi --}}
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

        <form action="{{ route('admin.pembudidaya.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group mt-2">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required
              oninvalid="this.setCustomValidity('Harap isi nama lengkap.')"
              oninput="this.setCustomValidity('')"
              value="{{ old('name') }}">
          </div>

          <div class="form-group mt-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required
              oninvalid="this.setCustomValidity('Harap masukkan email yang valid.')"
              oninput="this.setCustomValidity('')"
              value="{{ old('email') }}">
          </div>

          <div class="form-group mt-2">
            <label>Unggah Surat Kepemilikan Usaha (PDF, JPG, PNG)</label>
            <input type="file" id="suratUsaha" name="surat_usaha[]" class="form-control" accept=".pdf,image/*" multiple required>
            <ul id="documentPreview" class="mt-2 list-unstyled"></ul>
          </div>

          <div class="form-group mt-2">
            <label>Unggah Foto Tambak / Kolam / Usaha</label>
            <input type="file" id="fotoUsaha" name="foto_usaha[]" class="form-control" accept="image/*" multiple required>
            <div id="photoPreview" class="mt-2 d-flex flex-wrap"></div>
          </div>

          <div class="form-group mt-2">
            <label>Keterangan Tambahan (Opsional)</label>
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Tulis informasi tambahan mengenai usaha Anda...">{{ old('keterangan') }}</textarea>
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

          <button type="submit" class="btn btn-success mt-3">Simpan</button>
          <a href="{{ route('admin.pembudidaya.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </form>
      </div>
    </section>
  </div>

  <footer class="main-footer text-sm text-center">
    <strong>&copy; {{ date('Y') }} Admin Panel.</strong> All rights reserved.
  </footer>
</div>

<style>
  input[type="file"].form-control {
    display: block;
    width: 100%;
    height: calc(1.8125rem + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
  }
  .preview-thumb {
    position: relative;
    margin-right: 10px;
    margin-bottom: 10px;
  }
  .preview-thumb img {
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
  .remove-btn {
    position: absolute;
    top: -5px;
    right: -5px;
    background: red;
    color: white;
    border: none;
    font-size: 12px;
    border-radius: 50%;
    cursor: pointer;
    width: 20px;
    height: 20px;
  }
</style>

<!-- JS Script -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const password = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
  });

  document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
    const password = document.getElementById('password_confirmation');
    const icon = document.getElementById('confirmEyeIcon');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
  });

  let selectedDocs = [];
  document.getElementById('suratUsaha').addEventListener('change', function (event) {
    const newFiles = Array.from(event.target.files);
    selectedDocs = selectedDocs.concat(newFiles);
    updateDocumentPreview();
  });

  function updateDocumentPreview() {
    const previewList = document.getElementById('documentPreview');
    previewList.innerHTML = '';

    selectedDocs.forEach((file, index) => {
      const listItem = document.createElement('li');
      listItem.textContent = file.name;

      const removeBtn = document.createElement('button');
      removeBtn.textContent = '×';
      removeBtn.className = 'btn btn-sm btn-danger btn-xs ml-2';
      removeBtn.onclick = function () {
        selectedDocs.splice(index, 1);
        updateDocumentPreview();
      };

      listItem.appendChild(removeBtn);
      previewList.appendChild(listItem);
    });

    const input = document.getElementById('suratUsaha');
    const dt = new DataTransfer();
    selectedDocs.forEach(file => dt.items.add(file));
    input.files = dt.files;
  }

  let selectedPhotos = [];
  document.getElementById('fotoUsaha').addEventListener('change', function (event) {
    const newFiles = Array.from(event.target.files);
    selectedPhotos = selectedPhotos.concat(newFiles);
    updatePhotoPreview();
  });

  function updatePhotoPreview() {
    const preview = document.getElementById('photoPreview');
    preview.innerHTML = '';

    selectedPhotos.forEach((file, index) => {
      const reader = new FileReader();
      reader.onload = function (e) {
        const wrapper = document.createElement('div');
        wrapper.className = 'preview-thumb';

        const img = document.createElement('img');
        img.src = e.target.result;

        const removeBtn = document.createElement('button');
        removeBtn.textContent = '×';
        removeBtn.className = 'remove-btn';
        removeBtn.onclick = function () {
          selectedPhotos.splice(index, 1);
          updatePhotoPreview();
        };

        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        preview.appendChild(wrapper);
      };
      reader.readAsDataURL(file);
    });

    const input = document.getElementById('fotoUsaha');
    const dt = new DataTransfer();
    selectedPhotos.forEach(file => dt.items.add(file));
    input.files = dt.files;
  }
</script>
</body>
</html>
