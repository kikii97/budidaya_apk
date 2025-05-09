<!DOCTYPE html>
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
    {{-- <div class="card p-4 shadow-lg border-0 col-12 col-md-6 col-lg-4" style="border-radius: 15px;">
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
    </div> --}}

    <div class="row mt-3 mx-3" style="margin-top:25px;">
        <div class="col-md-3">
            <div style="" class="text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 70px;">
                <h3 class="mt-3 text-primary">Selamat Datang</h3>
                <p class="text">Daftarkan diri Anda sebagai Investor atau Usaha!</p>

                <!-- Pilihan Registrasi -->
                <div class="mb-3">
                    <label for="registrasiTipe" class="form-label text">Pilih Tipe Registrasi</label>
                    <select id="registrasiTipe" class="form-select" onchange="tampilkanForm()">
                        <option value="investor">Registrasi Investor</option>
                        <option value="usaha">Registrasi Usaha</option>
                    </select>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                    class="btn btn-white btn-rounded back-button">Go back</button>
            </div>
        </div>
        <div class="col-md-9 justify-content-center">
            <div class="card card-custom pb-4">
                <div class="card-body mt-0 mx-5">
                    <div class="text-center mb-3 pb-2 mt-3">
                        <h4 style="color: #495057;">Registrasi</h4>
                    </div>

                    <form id="formRegistrasi" class="mb-0">
                        <!-- Form Registrasi Investor -->
                        <div id="formInvestasi" class="form-registrasi" style="display: block;">
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form9Example1" class="form-control input-custom" />
                                        <label class="form-label" for="form9Example1">First name</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form9Example2" class="form-control input-custom" />
                                        <label class="form-label" for="form9Example2">Last name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form9Example3" class="form-control input-custom" />
                                        <label class="form-label" for="form9Example3">City</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form9Example4" class="form-control input-custom" />
                                        <label class="form-label" for="form9Example4">Zip</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form9Example6" class="form-control input-custom" />
                                        <label class="form-label" for="form9Example6">Address</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="email" id="typeEmail" class="form-control input-custom" />
                                        <label class="form-label" for="typeEmail">Email</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Registrasi Usaha -->
                        <div id="formUsaha" class="form-registrasi" style="display: none;">
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form9Example1" class="form-control input-custom" />
                                        <label class="form-label" for="form9Example1">Nama Usaha</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form9Example2" class="form-control input-custom" />
                                        <label class="form-label" for="form9Example2">Pemilik Usaha</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form9Example3" class="form-control input-custom" />
                                        <label class="form-label" for="form9Example3">Jenis Usaha</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form9Example4" class="form-control input-custom" />
                                        <label class="form-label" for="form9Example4">Alamat Usaha</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="email" id="typeEmail" class="form-control input-custom" />
                                        <label class="form-label" for="typeEmail">Email Usaha</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="float-end">
                            <!-- Submit button -->
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-primary btn-rounded" style="background-color: #0062CC;">Place
                                order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function tampilkanForm() {
            var tipe = document.getElementById("registrasiTipe").value;
            if (tipe === "investor") {
                document.getElementById("formInvestasi").style.display = "block";
                document.getElementById("formUsaha").style.display = "none";
            } else {
                document.getElementById("formInvestasi").style.display = "none";
                document.getElementById("formUsaha").style.display = "block";
            }
        }
    </script>


    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
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

            $("#togglePassword").on("click", function() {
                togglePassword("password", "eyeIcon");
            });

            $("#toggleConfirmPassword").on("click", function() {
                togglePassword("password_confirmation", "confirmEyeIcon");
            });
        });
    </script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

</body>

</html>
