<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center bg-light" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg border-0" style="width: 380px; border-radius: 15px;">
        <div class="card-body">
            <h3 class="text-center mb-4 fw-bold text-primary">Login</h3>

            {{-- Menampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>
                                {{
                                    str_replace(
                                        [
                                            'The password field confirmation does not match.',
                                            'The email has already been taken.',
                                            'The password field must be at least 6 characters.',
                                            'These credentials do not match our records.',
                                        ],
                                        [
                                            'Konfirmasi kata sandi tidak cocok.',
                                            'Email sudah terdaftar.',
                                            'Kata sandi harus terdiri dari minimal 6 karakter.',
                                            'Email atau kata sandi tidak sesuai.',
                                        ],
                                        $error
                                    )
                                }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email"
                        class="form-control rounded-pill shadow-sm @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="Masukkan email"
                        oninvalid="this.setCustomValidity('Harap masukkan email yang valid.')"
                        oninput="this.setCustomValidity('')"
                    >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="input-group">
                        <input 
                            type="password"
                            class="form-control rounded-pill shadow-sm pe-5 @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            required
                            minlength="6"
                            placeholder="Masukkan kata sandi"
                            oninvalid="this.setCustomValidity('Harap isi kata sandi.')"
                            oninput="this.setCustomValidity('')"
                        >
                        <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y bg-transparent border-0" id="togglePassword">
                            <i class="fa-solid fa-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill">Login</button>
                <a href="javascript:history.back()" class="btn btn-secondary w-100 rounded-pill mt-2">Kembali</a>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Password -->
    <script>
        $(document).ready(function () {
            $('#togglePassword').on('click', function () {
                const passwordField = $('#password');
                const eyeIcon = $('#eyeIcon');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                eyeIcon.toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>
</body>
</html>
