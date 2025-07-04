@extends('layouts.app')

@section('title', 'Unggah Dokumen Pembudidaya')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="container py-4" style="padding-top: 1rem !important;">
        <a href="{{ route('pembudidaya.detail_usaha') }}" class="text-muted small">
            <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>

        <div class="card p-3 mt-3" style="font-size: 0.85rem;">
            @if (session('success'))
                <div class="alert alert-success small">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger small">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pembudidaya.dokumen.store') }}" method="POST" enctype="multipart/form-data" style="font-size: 0.9rem;">
                @csrf
                <input type="hidden" name="pembudidaya_id" value="{{ session('pembudidaya_id') }}">

                <div class="mb-3">
                    <label class="form-label small">Unggah Surat Kepemilikan Usaha (PDF, JPG, PNG)</label>
                    <input type="file" class="form-control form-control-sm" name="surat_usaha[]" id="suratUsaha" accept=".pdf,image/*" multiple required>
                    <ul id="previewSuratUsaha" class="mt-2 list-unstyled small"></ul>
                </div>

                <div class="mb-3">
                    <label class="form-label small">Unggah Foto Tambak / Kolam / Usaha</label>
                    <input type="file" class="form-control form-control-sm" name="foto_usaha[]" id="fotoUsaha" accept="image/*" multiple required>
                    <ul id="previewFotoUsaha" class="mt-2 list-unstyled small"></ul>
                </div>

                <div class="mb-3">
                    <label class="form-label small">Keterangan Tambahan (Opsional)</label>
                    <textarea name="keterangan" class="form-control form-control-sm" rows="3"
                        placeholder="Tulis informasi tambahan mengenai usaha Anda..."></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-warning btn-sm">Unggah Dokumen</button>
                </div>
            </form>
        </div>
    </div>
<script>
  let suratFiles = [], fotoFiles = [];

  function updateInputFiles(inputId, filesArray) {
    const dt = new DataTransfer();
    filesArray.forEach(file => dt.items.add(file));
    document.getElementById(inputId).files = dt.files;
  }

  function renderFileList(previewId, filesArray, inputId, fileType) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';

    filesArray.forEach((file, index) => {
      const li = document.createElement('li');
      li.textContent = file.name;

      const btn = document.createElement('button');
      btn.textContent = '×';
      btn.type = 'button';
      btn.className = 'btn btn-sm btn-danger btn-xs ml-2';
      btn.onclick = () => {
        filesArray.splice(index, 1);
        updateInputFiles(inputId, filesArray);
        renderFileList(previewId, filesArray, inputId, fileType);
      };

      li.appendChild(btn);
      preview.appendChild(li);
    });
  }

  document.getElementById('suratUsaha').addEventListener('change', (e) => {
    suratFiles = suratFiles.concat(Array.from(e.target.files));
    updateInputFiles('suratUsaha', suratFiles);
    renderFileList('previewSuratUsaha', suratFiles, 'suratUsaha', 'dokumen');
  });

  document.getElementById('fotoUsaha').addEventListener('change', (e) => {
    fotoFiles = fotoFiles.concat(Array.from(e.target.files));
    updateInputFiles('fotoUsaha', fotoFiles);
    renderFileList('previewFotoUsaha', fotoFiles, 'fotoUsaha', 'foto');
  });
</script>

@endsection
