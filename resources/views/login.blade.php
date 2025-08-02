<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>

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

        input,
        textarea,
        button {
            font-family: 'Inter', sans-serif;
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
            <!-- Kiri: Sambutan -->
            <div class="col-12 col-md-4 text-center mb-4 mb-md-0">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img"
                    style="height: 70px; max-width: 100%;" />
                <h3 class="mt-3 text-primary">Selamat Datang</h3>
                <p class="text-small">Silakan login atau daftar akun terlebih dahulu!</p>

                <div class="mb-3">
                    <a href="{{ url()->current() }}?form=login" type="button" id="btn-login"
                        class="btn btn-primary btn-sm me-2 btn-rounded" onclick="showForm('login')">Login</a>
                    <div class="dropdown d-inline-block">
                        <button type="button" id="btn-register"
                            style="padding-right: 0.8rem; background-color: #0062CC"
                            class="btn btn-outline-primary btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Registrasi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ url()->current() }}?form=register&tipe=investor"
                                onclick="showForm('register'); showRegisterForm('investor');">Pengepul</a>
                            <a class="dropdown-item" href="{{ url()->current() }}?form=register&tipe=usaha"
                                onclick="showForm('register'); showRegisterForm('usaha');">Pembudidaya</a>
                        </div>
                    </div>
                </div>
                <button type="button" class="mt-2 btn btn-white btn-rounded" onclick="window.history.back();">
                    <i class="fa fa-arrow-left me-2"></i>Kembali
                </button>
            </div>

            <!-- Kanan: Form -->
            <div class="col-12 col-md-6">
                <div class="card card-custom p-4">
                    <!-- Login Form -->
                    <div id="form-login" style="display: block;"> <!-- langsung tampil -->
                        <h4 class="text-center mb-4" style="color: #495057;">Login</h4>
                        <form action="{{ route('login.post') }}" method="POST" class="px-3" novalidate>
                            @csrf
                            <div class="mb-4">
                                <div class="form-outline">
                                    <input type="email" name="email"
                                        class="form-control input-custom @error('email') is-invalid @enderror"
                                        placeholder="Masukkan email" required value="{{ old('email') }}" />
                                    <label class="form-label">Email</label>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <div data-mdb-input-init class="form-outline">
                                    <input type="password" id="katasandi" name="password"
                                        class="form-control input-custom pe-5 @error('password') is-invalid @enderror"
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
                            <div class="text-center mt-4">
                                {{-- Tombol Masuk --}}
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-primary btn-rounded px-4 py-2 mb-2" style="width: 220px;">
                                    Login
                                </button>
                                {{-- Garis Pembatas --}}
                                {{-- <div class="d-flex align-items-center justify-content-center mb-2" style="gap: 8px;">
                                    <hr class="flex-grow-1" style="border-top: 1px solid #919191; margin: 0;">
                                    <span class="text-muted" style="font-size: 13px;">atau</span>
                                    <hr class="flex-grow-1" style="border-top: 1px solid #919191; margin: 0;">
                                </div> --}}
                                {{-- Tombol Masuk dengan Google --}}
                                <a href="{{ route('login.google.with.tipe', ['tipe' => 'investor']) }}"
                                    class="btn btn-primary btn-rounded px-4 py-2 mb-2"
                                    style="background-color: #d0d0d0; color:#495057; width: 220px;">
                                    <img src="{{ asset('images/Google__G__logo.svg.webp') }}"
                                        alt="Google Logo" style="width: 16px; height: 16px;" class="me-2">
                                    Login with Google
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Register Form -->
                    <div id="form-register" style="display: none;">
                        <h4 class="text-center mb-4" style="color: #495057;">Daftar</h4>
                        <form id="form-inves" action="{{ route('register.post') }}" method="POST"
                            style="display: none; padding-right: 15px; padding-left: 20px;" novalidate>
                            @csrf
                            <input type="hidden" name="tipe" id="tipeInput" value="investor">
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" name="name"
                                            class="form-control input-custom @error('name') is-invalid @enderror"
                                            required value="{{ old('name') }}" />
                                        <label class="form-label">Nama Lengkap</label>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="email" name="email"
                                            class="form-control input-custom @error('email') is-invalid @enderror"
                                            required value="{{ old('email') }}" />
                                        <label class="form-label">Email</label>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline position-relative">
                                        <input type="password" id="pass-inves" name="password"
                                            class="form-control input-custom pe-5" required />
                                        <label class="form-label">Password</label>
                                        <i class="fa fa-eye position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                            onclick="togglePassword('pass-inves', this)"></i>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-outline position-relative">
                                        <input type="password" id="regPasswordConfirm" name="password_confirmation"
                                            class="form-control input-custom pe-5" required />
                                        <label class="form-label">Konfirmasi Password</label>
                                        <i class="fa fa-eye position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                            onclick="togglePassword('regPasswordConfirm', this)"></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form id="form-usaha" action="{{ route('register.post') }}" method="POST"
                            style="display: none; padding-right: 15px; padding-left: 20px;" novalidate>
                            @csrf
                            <input type="hidden" name="tipe" value="usaha">
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" name="name"
                                            class="form-control input-custom @error('name') is-invalid @enderror"
                                            required value="{{ old('name') }}" />
                                        <label class="form-label">Nama</label>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="email" name="email"
                                            class="form-control input-custom @error('email') is-invalid @enderror"
                                            required value="{{ old('email') }}" />
                                        <label class="form-label">Email</label>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline position-relative">
                                        <input type="password" id="pass-usaha" name="password"
                                            class="form-control input-custom pe-5" required />
                                        <label class="form-label">Password</label>
                                        <i class="fa fa-eye position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                            onclick="togglePassword('pass-usaha', this)"></i>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline position-relative">
                                        <input type="password" id="konfirm-pass" name="password_confirmation"
                                            class="form-control input-custom pe-5" required />
                                        <label class="form-label">Konfirmasi Password</label>
                                        <i class="fa fa-eye position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                            onclick="togglePassword('konfirm-pass', this)"></i>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            {{-- Tombol Daftar --}}
                            <button type="submit" form="form-inves" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-primary btn-rounded px-4 py-2 mb-2" style="width: 220px;">
                                Daftar
                            </button>
                            {{-- Garis Pembatas --}}
                            <div class="d-flex align-items-center justify-content-center mb-2" style="gap: 8px;">
                                <hr class="flex-grow-1" style="border-top: 1px solid #919191; margin: 0;">
                                <span class="text-muted" style="font-size: 13px;">atau</span>
                                <hr class="flex-grow-1" style="border-top: 1px solid #919191; margin: 0;">
                            </div>
                            {{-- Tombol Masuk dengan Google --}}
                            <a href="{{ route('login.google.with.tipe', ['tipe' => 'usaha']) }}"
                                class="btn d-inline-flex align-items-center justify-content-center shadow-sm"
                                style="background-color: #ffffff; color: rgba(0,0,0,0.54); border: 1px solid #ddd; border-radius: 50px; font-weight: 500; font-size: 12px; padding: 6px 12px;">
                                <img src="{{ asset('images/Google__G__logo.svg.webp') }}"
                                    alt="Google Logo" style="width: 16px; height: 16px;" class="me-2">
                                DAFTAR dengan Google
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    // Ambil elemen-elemen utama
                    const loginForm = document.getElementById('form-login');
                    const registerForm = document.getElementById('form-register');
                    const loginBtn = document.getElementById('btn-login');
                    const registerBtn = document.getElementById('btn-register');
                    const formInves = document.getElementById('form-inves');
                    const formUsaha = document.getElementById('form-usaha');
                    const submitBtn = document.querySelector('#form-register button[type="submit"]');
                    const dropdown = document.querySelector('.dropdown');

                    // Ambil parameter URL
                    const params = new URLSearchParams(window.location.search);
                    const formType = params.get('form'); // 'login' atau 'register'
                    const tipe = params.get('tipe'); // 'investor' atau 'usaha'

                    // Fungsi untuk toggle tombol aktif/nonaktif
                    function toggleButtons(type) {
                        if (type === 'login') {
                            // Tampilkan form login, sembunyikan register
                            loginForm.style.display = 'block';
                            registerForm.style.display = 'none';
                            dropdown?.classList.remove('show');

                            // Aktifkan tombol login
                            loginBtn.classList.remove('btn-outline-primary');
                            loginBtn.classList.add('btn-primary');
                            loginBtn.style.backgroundColor = '#0062CC';

                            // Nonaktifkan tombol register
                            registerBtn.classList.remove('btn-primary');
                            registerBtn.classList.add('btn-outline-primary');
                            registerBtn.style.backgroundColor = '';
                        } else if (type === 'register') {
                            // Tampilkan form register, sembunyikan login
                            loginForm.style.display = 'none';
                            registerForm.style.display = 'block';

                            // Aktifkan tombol register
                            registerBtn.classList.remove('btn-outline-primary');
                            registerBtn.classList.add('btn-primary');
                            registerBtn.style.backgroundColor = '#0062CC';

                            // Nonaktifkan tombol login
                            loginBtn.classList.remove('btn-primary');
                            loginBtn.classList.add('btn-outline-primary');
                            loginBtn.style.backgroundColor = '';
                        }
                    }

                    // Fungsi untuk tampilkan form investor atau usaha di form register
                    function showRegisterForm(type) {
                        if (type === 'investor') {
                            formInves.style.display = 'block';
                            formUsaha.style.display = 'none';
                            submitBtn.setAttribute('form', 'form-inves'); // Submit ke form investor
                        } else if (type === 'usaha') {
                            formInves.style.display = 'none';
                            formUsaha.style.display = 'block';
                            submitBtn.setAttribute('form', 'form-usaha'); // Submit ke form usaha
                        }
                    }

                    // Fungsi toggle password (bisa dipanggil dari event onclick icon)
                    window.togglePassword = function(inputId, icon) {
                        const input = document.getElementById(inputId);
                        if (input.type === "password") {
                            input.type = "text";
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            input.type = "password";
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    }

                    // Tampilkan form sesuai parameter URL, default ke login jika kosong atau tidak valid
                    if (formType === 'register') {
                        toggleButtons('register');
                        if (tipe === 'investor' || tipe === 'usaha') {
                            showRegisterForm(tipe);
                        } else {
                            // Default form register ke investor jika tipe tidak valid
                            showRegisterForm('investor');
                        }
                    } else {
                        toggleButtons('login');
                    }

                    // Update link Google Login/Register agar sesuai tipe
                    const googleLoginLink = document.querySelector('#form-login a[href*="auth/google"]');
                    const googleRegisterLink = document.querySelector('#form-register a[href*="auth/google"]');

                    if (tipe) {
                        if (googleLoginLink) {
                            googleLoginLink.href = `/auth/google/${tipe}`;
                        }
                        if (googleRegisterLink) {
                            googleRegisterLink.href = `/auth/google/${tipe}`;
                        }
                    }
                });
            </script>


            <!-- MDB UI Kit JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>

</html>
