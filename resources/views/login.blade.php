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
            <!-- Kiri: Sambutan -->
            <div class="col-12 col-md-4 text-center mb-4 mb-md-0">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img" style="height: 70px; max-width: 100%;" />
                <h3 class="mt-3 text-primary">Selamat Datang</h3>
                <p class="text-small">Silakan login atau daftar akun terlebih dahulu!</p>

                <div class="mb-3">
                    <a href="{{ url('login') }}?form=login" id="btn-login-left" class="btn btn-primary btn-sm me-2 btn-rounded">Login</a>
                    <a href="{{ url('login') }}?form=register&tipe=investor" class="btn btn-outline-primary btn-sm btn-rounded" id="btn-register-left">Daftar</a>
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
                    <!-- LOGIN FORM -->
                    <div id="login-form">
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
                            <div class="mb-4 position-relative">
                                <div class="form-outline">
                                    <input type="password" id="loginPassword" name="password" class="form-control input-custom @error('password') is-invalid @enderror" placeholder="Masukkan kata sandi" required />
                                    <label class="form-label">Kata Sandi</label>
                                    <i class="fa fa-eye position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;" onclick="togglePassword('loginPassword', this)"></i>
                                    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-rounded" style="background-color: #0062CC;">Login</button>
                            </div>
                        </form>
                    </div>

                    <!-- REGISTER FORM -->
                    <div id="register-form" style="display: none;">
                        <h4 class="text-center mb-4" style="color: #495057;">Daftar Akun</h4>
                        <form id="registerForm" action="{{ route('register.post') }}" method="POST" class="px-3" novalidate>
                            @csrf
                            <input type="hidden" name="tipe" id="tipeInput" value="{{ old('tipe') }}"> <!-- Diisi dari JS -->

                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-outline">
                                        <input type="text" name="name" class="form-control input-custom @error('name') is-invalid @enderror" required value="{{ old('name') }}" />
                                        <label class="form-label">Nama Lengkap</label>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-outline">
                                        <input type="email" name="email" class="form-control input-custom @error('email') is-invalid @enderror" required value="{{ old('email') }}" />
                                        <label class="form-label">Email</label>
                                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-outline position-relative">
                                        <input type="password" id="regPassword" name="password" class="form-control input-custom @error('password') is-invalid @enderror" required />
                                        <label class="form-label">Password</label>
                                        <i class="fa fa-eye position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;" onclick="togglePassword('regPassword', this)"></i>
                                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-rounded" style="background-color: #0062CC;">Daftar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT -->
<script>
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



</body>

    <!-- MDB UI Kit JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>

</html>
