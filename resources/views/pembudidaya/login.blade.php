<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pembudidaya</title>
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
    <div class="card p-4 shadow-lg border-0" style="width: 380px;">
        <div class="card-body">
            <h3 class="text-center mb-4 fw-bold text-success">Login Pembudidaya</h3>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

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

            <form action="{{ route('pembudidaya.login.post') }}" method="POST">
                @csrf
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
                <button type="submit" class="btn btn-primary w-100 rounded-pill">Login</button>
                <button type="button" class="btn btn-secondary w-100 rounded-pill mt-2" onclick="history.back()">Kembali</button>
            </form>

            <p class="text-center mt-3">
                <a href="{{ route('pembudidaya.register') }}" class="text-decoration-none text-success fw-bold">Daftar sebagai Pembudidaya</a>
            </p>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#togglePassword").on("click", function () {
                let passwordField = $("#password");
                let eyeIcon = $("#eyeIcon");
                if (passwordField.attr("type") === "password") {
                    passwordField.attr("type", "text");
                    eyeIcon.removeClass("fa-eye-slash").addClass("fa-eye");
                } else {
                    passwordField.attr("type", "password");
                    eyeIcon.removeClass("fa-eye").addClass("fa-eye-slash");
                }
            });
        });
    </script>
</body>
</html>
