<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Pembudidaya</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #e0f7fa;
        }
        .card {
            background-color: #ffffff;
            border-radius: 15px;
        }
        .btn-primary {
            background-color: #00796b;
            border: none;
        }
        .btn-primary:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg border-0" style="width: 400px;">
        <div class="card-body">
            <h3 class="text-center mb-4 fw-bold text-success">Daftar Pembudidaya</h3>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ str_replace(
                                [
                                    'The password field confirmation does not match.',
                                    'The email has already been taken.',
                                    'The password field must be at least 6 characters.'
                                ],
                                [
                                    'Konfirmasi kata sandi tidak cocok.',
                                    'Email sudah terdaftar.',
                                    'Kata sandi harus terdiri dari minimal 6 karakter.'
                                ],
                                $error
                            ) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pembudidaya.register.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control rounded-pill shadow-sm" name="name" required
                        oninvalid="this.setCustomValidity('Harap isi nama anda.')"
                        oninput="this.setCustomValidity('')">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control rounded-pill shadow-sm" name="email" required
                        oninvalid="this.setCustomValidity('Harap masukkan email yang valid.')"
                        oninput="this.setCustomValidity('')">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input type="text" class="form-control rounded-pill shadow-sm" name="address" required
                        oninvalid="this.setCustomValidity('Harap isi alamat anda.')"
                        oninput="this.setCustomValidity('')">
                </div>

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" class="form-control rounded-pill shadow-sm pe-5" id="password" name="password" required
                            oninvalid="this.setCustomValidity('Harap isi kata sandi.')"
                            oninput="this.setCustomValidity('')">
                        <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent" id="togglePassword">
                            <i class="fa-solid fa-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3 position-relative">
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" class="form-control rounded-pill shadow-sm pe-5" id="password_confirmation" name="password_confirmation" required
                            oninvalid="this.setCustomValidity('Harap konfirmasi kata sandi.')"
                            oninput="this.setCustomValidity('')">
                        <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent" id="toggleConfirmPassword">
                            <i class="fa-solid fa-eye-slash" id="confirmEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="documents" class="form-label">Unggah Dokumen/Gambar</label>
                    <input type="file" class="form-control rounded shadow-sm" id="documents" name="documents[]" multiple
                        accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                        oninvalid="this.setCustomValidity('Harap unggah setidaknya satu dokumen.')"
                        oninput="this.setCustomValidity('')">
                    <small class="text-muted">Bisa pilih lebih dari satu file (jpg, png, pdf, doc).</small>
                    <div id="filePreview" class="mt-2"></div> <!-- Preview file tampil disini -->
                </div>                

                <button type="submit" class="btn btn-primary w-100 rounded-pill mt-2">Daftar</button>
                <button type="button" class="btn btn-secondary w-100 rounded-pill mt-2" onclick="history.back()">Kembali</button>
            </form>

            <p class="text-center mt-3">Sudah punya akun? 
                <a href="{{ route('pembudidaya.login') }}" class="text-decoration-none text-success fw-bold">Masuk</a>
            </p>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let filesArray = [];
    
            $('#documents').on('change', function (e) {
                // Jika ada file baru, tambah ke filesArray
                const newFiles = Array.from(e.target.files);
                filesArray = filesArray.concat(newFiles);
                renderFilePreview();
            });
    
            function renderFilePreview() {
                const preview = $('#filePreview');
                preview.empty();
    
                if (filesArray.length === 0) {
                    preview.html('<small class="text-muted">Belum ada file yang dipilih.</small>');
                    return;
                }
    
                filesArray.forEach((file, index) => {
                    const fileElement = $(`
                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded mb-1">
                            <span class="text-truncate" style="max-width: 70%;" title="${file.name}">${file.name}</span>
                            <button type="button" class="btn btn-sm btn-danger rounded-pill" onclick="removeFile(${index})">Hapus</button>
                        </div>
                    `);
                    preview.append(fileElement);
                });
    
                updateInputFiles();
            }
    
            window.removeFile = function(index) {
                filesArray.splice(index, 1);
                renderFilePreview();
            };
    
            function updateInputFiles() {
                const dataTransfer = new DataTransfer();
                filesArray.forEach(file => {
                    dataTransfer.items.add(file);
                });
                $('#documents')[0].files = dataTransfer.files;
            }
        });
    </script>
    
    
</body>
</html>
