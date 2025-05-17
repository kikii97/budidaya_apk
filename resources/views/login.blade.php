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
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img" style="height: 70px; max-width: 100%;" />
                <h3 class="mt-3 text-primary">Selamat Datang</h3>
                <p class="text-small">Silakan login atau daftar akun terlebih dahulu!</p>

                <div class="mb-3">
                    {{-- <a href="{{ url('login') }}?form=login" id="btn-login-left" class="btn btn-primary btn-sm me-2 btn-rounded">Login</a>
                    <a href="{{ url('login') }}?form=register&tipe=investor" class="btn btn-outline-primary btn-sm btn-rounded" id="btn-register-left">Daftar</a> --}}
                    <button type="button" id="btn-login" class="btn btn-primary btn-sm me-2 btn-rounded"
                        onclick="showForm('login')">Login</button>
                    <div class="dropdown d-inline-block">
                        <button type="button" id="btn-register"
                            style="padding-right: 0.8rem; background-color: #0062CC"
                            class="btn btn-outline-primary btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false" onclick="activateRegisterButton()">
                            Daftar
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"
                                onclick="showForm('register'); showRegisterForm('investor');">Investor</a>
                            <a class="dropdown-item" href="#"
                                onclick="showForm('register'); showRegisterForm('usaha');">Usaha</a>
                        </div>
                    </div>
                </div>

                <!-- Pilih Tipe untuk Register -->
                <div class="mb-3 d-none" id="pilihTipeContainer">
                    <label for="registrasiTipe" class="form-label text">Pilih Tipe</label>
                    <select id="registrasiTipe" class="form-select form-select-sm mx-auto" name="tipe" style="width: 70%; font-size: 0.85rem;" onchange="tampilkanForm()">
                        <option value="investor">Investor</option>
                        <option value="usaha">Usaha</option>
                    </select>
                </div>

                <button type="button" class="mt-2 btn btn-white btn-rounded d-none d-md-inline-block" onclick="window.history.back();">
                    <i class="fa fa-arrow-left me-2"></i>Kembali
                </button>
            </div>

            <!-- Kanan: Form -->
            <div class="col-12 col-md-6">
                <div class="card card-custom p-4">
                    {{-- <!-- LOGIN FORM -->
                    <div id="login-form"> --}}
                    <!-- Login Form -->
                    <div id="form-login" style="display: block;"> <!-- langsung tampil -->
                        <h4 class="text-center mb-4" style="color: #495057;">Login</h4>
                        <form action="{{ route('login.post') }}" method="POST" class="px-3" novalidate>
                            @csrf
                            <div class="mb-4">
                                <div class="form-outline">
                                    <input type="email" name="email" class="form-control input-custom @error('email') is-invalid @enderror" placeholder="Masukkan email" required value="{{ old('email') }}" />
                                    <label class="form-label">Email</label>
                                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            {{-- <div class="mb-4 position-relative">
                                <div class="form-outline">
                                    <input type="password" id="loginPassword" name="password" class="form-control input-custom @error('password') is-invalid @enderror" placeholder="Masukkan kata sandi" required />
                                    <label class="form-label">Kata Sandi</label>
                                    <i class="fa fa-eye position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;" onclick="togglePassword('loginPassword', this)"></i>
                                    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror --}}

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
                                {{-- <button type="submit" class="btn btn-primary btn-rounded" style="background-color: #0062CC;">Login</button> --}}
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-primary btn-rounded d-md-none" onclick="window.history.back();"
                                    style="padding-left: 1.4rem; background-color: #868686; border-color: #495057;">
                                    <i class="fa fa-arrow-left me-2"></i>Kembali
                                </button>
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-primary btn-rounded">
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- REGISTER FORM -->
                    {{-- <div id="register-form" style="display: none;">
                        <h4 class="text-center mb-4" style="color: #495057;">Daftar Akun</h4>
                        <form id="registerForm" action="{{ route('register.post') }}" method="POST" class="px-3" novalidate> --}}
                    <!-- Register Form -->
                    <div id="form-register" style="display: none;">
                        <h4 class="text-center mb-4" style="color: #495057;">Daftar</h4>
                        <form id="form-inves" action="{{ route('register.post') }}" method="POST"
                            style="display: none; padding-right: 15px; padding-left: 20px;" novalidate>
                            @csrf
                            <input type="hidden" name="tipe" id="tipeInput" value="{{ old('tipe') }}"> <!-- Diisi dari JS -->

                            <div class="row mb-4">
                                <div class="col">
                                    {{-- <div class="form-outline">
                                        <input type="text" name="name" class="form-control input-custom @error('name') is-invalid @enderror" required value="{{ old('name') }}" /> --}}
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" name="name-inves" class="form-control input-custom"
                                            required />
                                        <label class="form-label">Nama Lengkap</label>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    {{-- <div class="form-outline">
                                        <input type="email" name="email" class="form-control input-custom @error('email') is-invalid @enderror" required value="{{ old('email') }}" /> --}}
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="email" name="email-inves" class="form-control input-custom"
                                            required />
                                        <label class="form-label">Email</label>
                                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    {{-- <div class="form-outline position-relative">
                                        <input type="password" id="regPassword" name="password" class="form-control input-custom @error('password') is-invalid @enderror" required />
                                        <label class="form-label">Password</label>
                                        <i class="fa fa-eye position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;" onclick="togglePassword('regPassword', this)"></i>
                                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror --}}
                                    <div data-mdb-input-init class="form-outline position-relative">
                                        <input type="password" id="pass-inves" name="pass"
                                            class="form-control input-custom" required />
                                        <label class="form-label">Password</label>
                                        <i class="fa fa-eye position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                            onclick="togglePassword('pass-inves', this)"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-outline position-relative">
                                        <input type="password" id="regPasswordConfirm" name="password_confirmation" class="form-control input-custom" required />
                                        <label class="form-label">Konfirmasi Password</label>
                                        <i class="fa fa-eye position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;" onclick="togglePassword('regPasswordConfirm', this)"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-rounded" style="background-color: #0062CC;">Daftar</button>
                            </div>
                        </form> --}}
                        </form>
                        <form id="form-usaha" action="" method="POST"
                            style="display: none; padding-right: 15px; padding-left: 20px;" novalidate>
                            @csrf
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" name="name-usaha" class="form-control input-custom"
                                            required />
                                        <label class="form-label">Nama</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="email" name="email-usaha" class="form-control input-custom"
                                            required />
                                        <label class="form-label">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline position-relative">
                                        <input type="password" id="pass-usaha" name="pass-usaha"
                                            class="form-control input-custom" required />
                                        <label class="form-label">Password</label>
                                        <i class="fa fa-eye position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                            onclick="togglePassword('pass-usaha', this)"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline position-relative">
                                        <input type="password" id="konfirm-pass" name="konfirm-pass"
                                            class="form-control input-custom" required />
                                        <label class="form-label">Konfirm Password</label>
                                        <i class="fa fa-eye position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                            onclick="togglePassword('konfirm-pass', this)"></i>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="text-end">
                            <button type="button" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-primary btn-rounded d-md-none" onclick="window.history.back();"
                                style="padding-left: 1.4rem; background-color: #868686; border-color: #495057;">
                                <i class="fa fa-arrow-left me-2"></i>Kembali
                            </button>
                            <button type="submit" form="form-inves" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-primary btn-rounded"
                                style="padding-left: 1.4rem; padding-right: 1.4rem; margin-right: 15px;">
                                Daftar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

    <!-- SCRIPT -->
{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const formType = urlParams.get('form');    // 'login' atau 'register'
    const tipe = urlParams.get('tipe');        // 'investor' atau 'usaha'

    // Tampilkan form sesuai param 'form'
    if (formType === 'register') {
        showForm('register');

        if (tipe) {
            const tipeSelect = document.getElementById('registrasiTipe');
            const tipeInput = document.getElementById('tipeInput');
            tipeSelect.value = tipe;
            tipeInput.value = tipe;
        }
    } else {
        showForm('login');
    }

    // Update nilai hidden input tipe saat dropdown berubah
    document.getElementById('registrasiTipe').addEventListener('change', function() {
        document.getElementById('tipeInput').value = this.value;
    });
});

function showForm(type) {
    document.getElementById('login-form').style.display = (type === 'login') ? 'block' : 'none';
    document.getElementById('register-form').style.display = (type === 'register') ? 'block' : 'none';

    // Tampilkan atau sembunyikan container pilih tipe hanya saat register
    document.getElementById('pilihTipeContainer').classList.toggle('d-none', type !== 'register');

    // Ganti style tombol login/register sesuai form aktif
    document.getElementById('btn-login-left').classList.toggle('btn-primary', type === 'login');
    document.getElementById('btn-login-left').classList.toggle('btn-outline-primary', type !== 'login');
    document.getElementById('btn-register-left').classList.toggle('btn-primary', type === 'register');
    document.getElementById('btn-register-left').classList.toggle('btn-outline-primary', type !== 'register');
}

function tampilkanForm() {
    const selected = document.getElementById('registrasiTipe').value;
    if (selected) {
        // Hanya ubah lokasi jika tipe benar-benar berubah (opsional)
        const currentParams = new URLSearchParams(window.location.search);
        if (currentParams.get('tipe') !== selected) {
            window.location.href = `{{ url('login') }}?form=register&tipe=${selected}`;
        }
    }
}

function togglePassword(fieldId, icon) {
    const field = document.getElementById(fieldId);
    const isPassword = field.type === 'password';
    field.type = isPassword ? 'text' : 'password';
    icon.classList.toggle('fa-eye', !isPassword);
    icon.classList.toggle('fa-eye-slash', isPassword);
}
</script>



</body> --}}
            <script>
                function showForm(type) {
                    const loginForm = document.getElementById('form-login');
                    const registerForm = document.getElementById('form-register');
                    const dropdown = document.querySelector('.dropdown');
                    const loginBtn = document.getElementById('btn-login');
                    const registerBtn = document.getElementById('btn-register');

                    if (type === 'login') {
                        loginForm.style.display = 'block';
                        registerForm.style.display = 'none';
                        dropdown.classList.remove('show');

                        // Aktifkan tombol login
                        loginBtn.classList.remove('btn-outline-primary');
                        loginBtn.classList.add('btn-primary');
                        loginBtn.style.backgroundColor = '#0062CC';

                        // Nonaktifkan tombol register
                        registerBtn.classList.remove('btn-primary');
                        registerBtn.classList.add('btn-outline-primary');
                        registerBtn.style.backgroundColor = '';

                    } else if (type === 'register') {
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

                function activateRegisterButton() {
                    const loginBtn = document.getElementById('btn-login');
                    const registerBtn = document.getElementById('btn-register');

                    // Aktifkan tombol register
                    registerBtn.classList.remove('btn-outline-primary');
                    registerBtn.classList.add('btn-primary');
                    registerBtn.style.backgroundColor = '#0062CC';

                    // Nonaktifkan tombol login
                    loginBtn.classList.remove('btn-primary');
                    loginBtn.classList.add('btn-outline-primary');
                    loginBtn.style.backgroundColor = '';
                }

                function showRegisterForm(type) {
                    const formInves = document.getElementById('form-inves');
                    const formUsaha = document.getElementById('form-usaha');

                    if (type === 'investor') {
                        formInves.style.display = 'block';
                        formUsaha.style.display = 'none';
                    } else if (type === 'usaha') {
                        formInves.style.display = 'none';
                        formUsaha.style.display = 'block';
                    }
                }

                // Toggle password visibility icon and input type
                function togglePassword(inputId, icon) {
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

                // Set default view on page load
                document.addEventListener('DOMContentLoaded', () => {
                    showForm('login');
                });
            </script>

            <!-- MDB UI Kit JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>

</html>
