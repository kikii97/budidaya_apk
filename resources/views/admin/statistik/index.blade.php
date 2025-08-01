<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statistik - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('admin.partials.navbar')
    @include('admin.partials.sidebar')

    <div class="content-wrapper">
        <section class="content pt-3">
            <div class="container-fluid">

                <!-- Market Overview Card -->
                <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="card-subtitle card-subtitle-dash">Jumlah pengguna dan pembudidaya per bulan pada tahun {{ $selectedYear }}</p>
                                    </div>
                                    <div>
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{ $selectedYear }} </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                <h6 class="dropdown-header">Pilih Tahun</h6>
                                                @foreach ($years as $year)
                                                    <a class="dropdown-item" href="{{ route('admin.statistik.index', ['year' => $year]) }}">{{ $year }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-4 justify-content-start">
    <div class="d-flex align-items-center me-4">
        <h2 class="mb-0 fw-bold text-primary me-1">{{ $totalUsers }}</h2>
        <h5 class="mb-0">Pengguna</h5>
    </div>
    <div class="d-flex align-items-center">
        <h2 class="mb-0 fw-bold text-primary me-1">{{ $totalPembudidaya }}</h2>
        <h5 class="mb-0">Pembudidaya</h5>
    </div>
</div>


                                <div class="chartjs-bar-wrapper mt-3">
                                    <canvas id="marketingOverview"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="main-footer text-sm text-center">
        <strong>&copy; {{ date('Y') }} Admin Panel.</strong> All rights reserved.
    </footer>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('marketingOverview').getContext('2d');
        new Chart(ctx, @json($chart['data']));
    });
</script>
</body>
</html>