<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Pembudidaya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS AdminLTE & FontAwesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
  <style>
    .preview-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      margin-right: 15px;
      margin-bottom: 15px;
    }
    .preview-doc {
      display: inline-block;
      margin-right: 10px;
      margin-bottom: 10px;
      position: relative;
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
      line-height: 20px;
      text-align: center;
    }
  </style>
  <style>
  .preview-img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    margin-right: 15px; /* Jarak horizontal antar gambar */
    margin-bottom: 15px; /* Jarak vertikal antar baris gambar */
  }
  .preview-doc {
    display: inline-block;
    margin-right: 15px; /* Jarak horizontal antar dokumen */
    margin-bottom: 15px; /* Jarak vertikal antar baris dokumen */
    position: relative;
  }
  .position-relative {
    position: relative;
    display: inline-block; /* Memastikan setiap wrapper berdiri sendiri */
    padding: 5px; /* Memberikan ruang di sekitar gambar agar tombol tidak menempel */
  }
  .remove-btn {
    position: absolute;
    top: 0; /* Menempel di sudut atas */
    right: 0; /* Menempel di sudut kanan */
    background: red;
    color: white;
    border: none;
    font-size: 12px;
    border-radius: 50%;
    cursor: pointer;
    width: 20px;
    height: 20px;
    line-height: 20px;
    text-align: center;
    z-index: 1; /* Memastikan tombol berada di atas */
  }
</style>
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
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('admin.pembudidaya.update', $pembudidaya->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Input Data Umum -->
          <div class="form-group mt-2">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $pembudidaya->name) }}" required>
          </div>

          <div class="form-group mt-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $pembudidaya->email) }}" required>
          </div>

          <div class="form-group mt-2">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $pembudidaya->profil->alamat ?? '') }}">
          </div>

          <div class="form-group mt-2">
            <label>Nomor Telepon</label>
            <input type="text" name="nomor_telepon" class="form-control" value="{{ old('nomor_telepon', $pembudidaya->profil->nomor_telepon ?? '') }}">
          </div>

          <div class="form-group mt-2">
            <label>Deskripsi Usaha</label>
            <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $pembudidaya->profil->deskripsi ?? '') }}</textarea>
          </div>

          <div class="form-group mt-2">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $pembudidaya->dokumenPembudidaya->keterangan ?? '') }}</textarea>
          </div>

          <div class="form-group mt-2">
            <label>Foto Profil Saat Ini</label><br>
            @if (!empty($pembudidaya->profil->foto_profil))
              <img src="{{ asset('storage/' . $pembudidaya->profil->foto_profil) }}" alt="Foto Profil" class="img-thumbnail" style="width: 150px;">
            @else
              <p class="text-muted">Belum ada foto profil.</p>
            @endif
          </div>

          <div class="form-group mt-2">
            <label>Unggah Foto Profil Baru</label>
            <input type="file" name="foto_profil" class="form-control" accept="image/*">
          </div>

          <hr>
          <h6>Dokumen Usaha</h6>

          <!-- SURAT USAHA -->
          <div class="form-group">
            <label for="surat_usaha">Surat Usaha (PDF, JPG, PNG)</label>
            <div id="existingSuratUsaha" class="mb-2"></div>
            <input type="file" name="surat_usaha[]" id="surat_usaha" class="form-control" multiple accept=".pdf,image/*">
            <div id="previewSuratBaru" class="d-flex flex-wrap mt-2"></div>
          </div>

          <!-- FOTO USAHA -->
          <div class="form-group">
            <label for="foto_usaha">Foto Usaha (JPG, PNG)</label>
            <div id="existingFotoUsaha" class="d-flex flex-wrap mb-2"></div>
            <input type="file" name="foto_usaha[]" id="foto_usaha" class="form-control" multiple accept="image/*">
            <div id="previewFotoBaru" class="d-flex flex-wrap mt-2"></div>
          </div>

          <button type="submit" class="btn btn-primary mt-3">Update</button>
          <a href="{{ route('admin.pembudidaya.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </form>
      </div>
    </section>
  </div>

  <footer class="main-footer text-sm text-center">
    <strong>&copy; {{ date('Y') }} Admin Panel.</strong> All rights reserved.
  </footer>
</div>

<!-- JS Script -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script>
  // Initialize existing files with null check and path normalization
  const existingSurat = @json($pembudidaya->dokumenPembudidaya && $pembudidaya->dokumenPembudidaya->surat_usaha_path ? json_decode($pembudidaya->dokumenPembudidaya->surat_usaha_path, true) : [])
    .map(path => path ? { path: path.replace(/\\\//g, '/'), index: null } : null)
    .filter(p => p && p.path);
  const existingFoto = @json($pembudidaya->dokumenPembudidaya && $pembudidaya->dokumenPembudidaya->foto_usaha_path ? json_decode($pembudidaya->dokumenPembudidaya->foto_usaha_path, true) : [])
    .map(path => path ? { path: path.replace(/\\\//g, '/'), index: null } : null)
    .filter(p => p && p.path);
  let selectedSurat = [];
  let selectedFoto = [];

  // Debug logs
  console.log('Existing Surat Usaha:', existingSurat);
  console.log('Existing Foto Usaha:', existingFoto);
  existingFoto.forEach(item => console.log('Foto URL:', '{{ asset("storage/") }}' + item.path));
  existingFoto.forEach(item => console.log('Full Path Check:', '/storage/' + item.path));

  // Initialize existing previews
  function initExistingPreviews() {
    const existingSuratDiv = $('#existingSuratUsaha');
    const existingFotoDiv = $('#existingFotoUsaha');
    existingSuratDiv.html('');
    existingFotoDiv.html('');

    existingSurat.forEach((item, index) => {
      const wrapper = $('<div class="preview-doc position-relative"></div>');
      const link = $('<a href="{{ asset("storage/") }}' + item.path + '" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fas fa-file-alt"></i> ' + item.path.split('/').pop() + '</a>');
      const removeBtn = $('<button type="button" class="remove-btn" data-index="' + index + '">×</button>');
      removeBtn.on('click', function() {
        if (confirm('Yakin ingin menghapus dokumen ini?')) {
          const input = $('<input type="hidden" name="remove_files[]" value="' + item.path + '">');
          $('form').append(input);
          wrapper.remove();
          existingSurat.splice(index, 1);
          initExistingPreviews();
        }
      });
      wrapper.append(link).append(removeBtn);
      existingSuratDiv.append(wrapper);
    });

    existingFoto.forEach((item, index) => {
      const wrapper = $('<div class="position-relative"></div>');
      const img = $('<img src="/storage/' + item.path + '" alt="Foto Usaha" class="preview-img">');
      img.on('error', function() {
        $(this).attr('src', 'https://via.placeholder.com/120?text=Image+Not+Found');
        console.error('Failed to load image:', '/storage/' + item.path);
      });
      const removeBtn = $('<button type="button" class="remove-btn" data-index="' + index + '">×</button>');
      removeBtn.on('click', function() {
        if (confirm('Yakin ingin menghapus foto ini?')) {
          const input = $('<input type="hidden" name="remove_files[]" value="' + item.path + '">');
          $('form').append(input);
          wrapper.remove();
          existingFoto.splice(index, 1);
          initExistingPreviews();
        }
      });
      wrapper.append(img).append(removeBtn);
      existingFotoDiv.append(wrapper);
    });
  }

  // Handle new surat uploads
  $('#surat_usaha').on('change', function(e) {
    const newFiles = Array.from(e.target.files).map(file => ({ file: file, index: null }));
    selectedSurat = selectedSurat.concat(newFiles);
    updateSuratPreview();
  });

  // Handle new foto uploads
  $('#foto_usaha').on('change', function(e) {
    const newFiles = Array.from(e.target.files).map(file => ({ file: file, index: null }));
    selectedFoto = selectedFoto.concat(newFiles);
    updateFotoPreview();
  });

  // Update surat preview
  function updateSuratPreview() {
    const previewDiv = $('#previewSuratBaru');
    previewDiv.html('');
    selectedSurat.forEach((item, index) => {
      const wrapper = $('<div class="preview-doc position-relative"></div>');
      const reader = new FileReader();
      reader.onload = function(event) {
        const link = $('<a href="#" class="btn btn-outline-primary btn-sm"><i class="fas fa-file-alt"></i> ' + item.file.name + '</a>');
        const removeBtn = $('<button type="button" class="remove-btn" data-index="' + index + '">×</button>');
        removeBtn.on('click', function() {
          selectedSurat.splice(index, 1);
          updateSuratPreview();
        });
        wrapper.append(link).append(removeBtn);
        previewDiv.append(wrapper);
      };
      reader.readAsDataURL(item.file);
    });
  }

  // Update foto preview
  function updateFotoPreview() {
    const previewDiv = $('#previewFotoBaru');
    previewDiv.html('');
    selectedFoto.forEach((item, index) => {
      const wrapper = $('<div class="position-relative"></div>');
      const reader = new FileReader();
      reader.onload = function(event) {
        const img = $('<img src="' + event.target.result + '" alt="Foto Usaha" class="preview-img">');
        const removeBtn = $('<button type="button" class="remove-btn" data-index="' + index + '">×</button>');
        removeBtn.on('click', function() {
          selectedFoto.splice(index, 1);
          updateFotoPreview();
        });
        wrapper.append(img).append(removeBtn);
        previewDiv.append(wrapper);
      };
      reader.readAsDataURL(item.file);
    });
  }

  // Initialize on page load
  $(document).ready(function() {
    initExistingPreviews();
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>