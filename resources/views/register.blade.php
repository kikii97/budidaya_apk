<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center bg-light" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg border-0 col-12 col-md-6 col-lg-4" style="border-radius: 15px;">
        <div class="card-body">
            <h3 class="text-center mb-4 fw-bold text-primary">Daftar</h3>

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

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control rounded-pill shadow-sm" id="name" name="name" required 
                    oninvalid="this.setCustomValidity('Harap isi nama anda.')" 
                    oninput="this.setCustomValidity('')">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control rounded-pill shadow-sm" id="email" name="email" required 
                    oninvalid="this.setCustomValidity('Harap masukkan email yang valid.')" 
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
                <button type="submit" class="btn btn-primary w-100 rounded-pill">Daftar</button>
                <button type="button" class="btn btn-secondary w-100 rounded-pill mt-2" onclick="history.back()">Kembali</button>
            </form>

            <p class="text-center mt-3">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Masuk</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            function togglePassword(inputId, iconId) {
                let input = $("#" + inputId);
                let icon = $("#" + iconId);

                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    icon.removeClass("fa-eye-slash").addClass("fa-eye"); // Mata terbuka
                } else {
                    input.attr("type", "password");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash"); // Mata tertutup
                }
            }

            $("#togglePassword").on("click", function () {
                togglePassword("password", "eyeIcon");
            });

            $("#toggleConfirmPassword").on("click", function () {
                togglePassword("password_confirmation", "confirmEyeIcon");
            });
        });
    </script>
</body>
</html>
