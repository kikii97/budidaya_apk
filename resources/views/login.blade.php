{{-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css">

    <style>
        .text-primary {
            color: #003f63 !important;
        }

        .gradient-custom {
            background: linear-gradient(to bottom, #e9f8ff 0%, #b5e3fb 35%, #6fc7f2 70%, #41a9e1 100%);
            background-repeat: no-repeat;
            background-size: cover;
            color: #003366;
        }

        .card-custom {
            border-bottom-left-radius: 10% 50%;
            border-top-left-radius: 10% 50%;
            background-color: #f8f9fa;
        }


        .input-custom {
            background-color: white;
        }

        .text {
            color: #003f63;
            font-weight: 100;
            font-size: 14px;
        }

        .back-button {
            background-color: hsl(52, 0%, 98%);
            font-weight: 700;
            color: black;
            margin-top: 50px;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center bg-light gradient-custom" style="min-height: 100vh;">
    <div class="row mt-3 mx-3" style="margin-top:25px;">
        <div class="col-md-3">
            <div class="text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 70px;">
                <h3 class="mt-3 text-primary">Selamat Datang</h3>
                <p class="mt-2 text">Gunakan email dan kata sandi yang sudah terdaftar untuk mengakses akun Anda!</p>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-white btn-rounded back-button"
                    onclick="window.history.back();">Kembali</button>
            </div>
        </div>
        <div class="col-md-9 justify-content-center">
            <div class="card card-custom pb-4">
                <div class="card-body mt-0 mx-5">
                    <div class="text-center mb-3 pb-2 mt-3">
                        <h4 style="color: #495057;">Login</h4>
                    </div>

                    <form action="{{ route('login.post') }}" method="POST" class="mb-0" novalidate>
                        @csrf
                        <div style="display: block;">
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="email" id="form9Example1" name="email"
                                            class="form-control input-custom @error('email') is-invalid @enderror"
                                            placeholder="Masukkan email" value="{{ old('email') }}" required />
                                        <label class="form-label" for="form9Example1">Email</label>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="password" id="form9Example3" name="password"
                                            class="form-control input-custom @error('password') is-invalid @enderror"
                                            placeholder="Masukkan kata sandi" required />
                                        <label class="form-label" for="form9Example3">Kata Sandi</label>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="float-end">
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-primary btn-rounded" style="background-color: #0062CC;">
                                Login
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

</body>

</html> --}}

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Responsive</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />

    <!-- MDB UI Kit CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(to bottom, #e9f8ff 0%, #b5e3fb 35%, #6fc7f2 70%, #41a9e1 100%);
            color: #003366;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card-custom {
            border-bottom-left-radius: 10% 50%;
            border-top-left-radius: 10% 50%;
            background-color: #f8f9fa;
            box-shadow: 0 0 15px rgb(0 0 0 / 0.1);
        }

        .input-custom {
            background-color: white;
        }

        .text-primary {
            color: #003f63 !important;
        }

        .text-small {
            font-weight: 100;
            font-size: 14px;
            color: #003f63;
        }

        .back-button {
            background-color: hsl(52, 0%, 98%);
            font-weight: 700;
            color: black;
            margin-top: 50px;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .card-custom {
                border-bottom-left-radius: 10% 50%;
                border-top-left-radius: 10% 50%;
                background-color: #f8f9fa;
                box-shadow: 0 0 15px rgb(0 0 0 / 0.1);
            }

            .back-button {
                margin-top: 20px;
                width: 100%;
                background-color: #e0e0e0;
                color: #003366;
            }

            .text-primary {
                font-size: 20px;
            }

            h3 {
                font-size: 22px;
            }

            h4 {
                font-size: 20px;
            }

            .logo-img {
                height: 60px !important;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row gx-0 justify-content-center align-items-center min-vh-75">
            <!-- Left side / welcome -->
            <div class="col-12 col-md-4 text-center mb-4 mb-md-0">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img"
                    style="height: 70px; max-width: 100%;" />
                <h3 class="mt-3 text-primary">Selamat Datang</h3>
                <p class="text-small">
                    Silakan login atau daftar akun terlebih dahulu!
                </p>
                <div class="mb-3">
                    <button type="button" id="btn-login-left" class="btn btn-primary btn-sm me-2 btn-rounded"
                        style="background-color: #0062CC;" onclick="showForm('login')">Login</button>
                    <button type="button" id="btn-register-left" class="btn btn-outline-primary btn-sm btn-rounded"
                        onclick="showForm('register')">Daftar</button>
                </div>
                <button type="button" class="mt-2 btn btn-white btn-rounded d-none d-md-inline-block"
                    onclick="window.history.back();">
                    <i class="fa fa-arrow-left me-2"></i>Kembali
                </button>
            </div>

            <!-- Right side / login form -->
            <div class="col-12 col-md-6">
                <div class="card card-custom p-4">
                    <!-- Login Form -->
                    <div id="login-form">
                        <h4 class="text-center mb-4" style="color: #495057;">Login</h4>
                        <form action="{{ route('login.post') }}" method="POST"
                            style="padding-right: 15px; padding-left: 20px;" novalidate>
                            @csrf
                            <div class="mb-4">
                                <div data-mdb-input-init class="form-outline">
                                    <input type="email" id="form9Example1" name="email"
                                        class="form-control input-custom @error('email') is-invalid @enderror"
                                        placeholder="Masukkan email" value="{{ old('email') }}" required />
                                    <label class="form-label" for="form9Example1">Email</label>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <div data-mdb-input-init class="form-outline">
                                    <input type="password" id="katasandi" name="password"
                                        class="form-control input-custom @error('password') is-invalid @enderror"
                                        placeholder="Masukkan kata sandi" required />
                                    <label class="form-label" for="katasandi">Kata Sandi</label>
                                    <i class="fa fa-eye position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                            onclick="togglePassword('katasandi', this)"></i>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-primary btn-rounded d-md-none" onclick="window.history.back();"
                                    style="background-color: #868686; border-color: #495057;">
                                    <i class="fa fa-arrow-left me-2"></i>Kembali
                                </button>
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-primary btn-rounded" style="background-color: #0062CC;">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Register Form -->
                    <div id="register-form" style="display: none;">
                        <h4 class="text-center mb-4" style="color: #495057;">Daftar</h4>
                        <form action="{{ route('register.post') }}" method="POST"
                            style="padding-right: 15px; padding-left: 20px;" novalidate>
                            @csrf
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" name="name" class="form-control input-custom"
                                            required />
                                        <label class="form-label">Nama Lengkap</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="email" name="email" class="form-control input-custom"
                                            required />
                                        <label class="form-label">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline position-relative">
                                        <input type="password" id="password" name="password"
                                            class="form-control input-custom" required />
                                        <label class="form-label">Password</label>
                                        <i class="fa fa-eye position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                            onclick="togglePassword('password', this)"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline position-relative">
                                        <input type="password" id="konfirm-password" name="konfirm-password"
                                            class="form-control input-custom" required />
                                        <label class="form-label">Konfirmasi Password</label>
                                        <i class="fa fa-eye position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                            onclick="togglePassword('konfirm-password', this)"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-primary btn-rounded d-md-none" onclick="window.history.back();"
                                    style="background-color: #868686; border-color: #495057;">
                                    <i class="fa fa-arrow-left me-2"></i>Kembali
                                </button>
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-primary btn-rounded" style="background-color: #0062CC;">
                                    Daftar
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk toggle form -->
    <script>
        function showForm(formType) {
            if (formType === 'login') {
                document.getElementById('login-form').style.display = 'block';
                document.getElementById('register-form').style.display = 'none';
            } else if (formType === 'register') {
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('register-form').style.display = 'block';
            }
        }

        function togglePassword(fieldId, icon) {
            const field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                field.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

    <!-- MDB UI Kit JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>

</html>
