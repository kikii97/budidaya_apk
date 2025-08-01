<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statistik - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.js"></script>
    <style>
        .card-body {
            position: relative;
        }
        .dropdown-menu {
            max-height: 200px; /* Limit height to prevent overflow */
            overflow-y: auto; /* Add scrollbar if too many items */
            z-index: 1000; /* Ensure it stays above other content */
            max-width: 120px; /* Reduced width to make it smaller */
            min-width: 100px; /* Reduced minimum width for compactness */
            font-size: 0.875rem; /* Slightly smaller font for a compact look */
            padding: 0.25rem 0; /* Reduced padding for tighter spacing */
        }
        .dropdown-menu .dropdown-header {
            padding: 0.25rem 0.5rem; /* Reduced padding for header */
            font-size: 0.875rem; /* Match smaller font size */
            color: #6c757d; /* Match Bootstrap muted text */
        }
        .dropdown-menu .dropdown-item {
            padding: 0.2rem 0.5rem; /* Reduced padding for items */
            font-size: 0.875rem; /* Match smaller font size */
            color: #212529; /* Match Bootstrap item text color */
        }
        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa; /* Match Bootstrap hover background */
        }
        .dropdown-container {
            position: relative; /* Relative positioning for dropdown container */
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('admin.partials.navbar')
    @include('admin.partials.sidebar')

    <div class="content-wrapper">
        <section class="content pt-3">
            <div class="container-fluid">
                <!-- Market Overview Card (Users and Pembudidaya) -->
                <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body position-relative">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="card-subtitle card-subtitle-dash">Jumlah pengguna dan pembudidaya per bulan pada tahun {{ $userYear }}</p>
                                    </div>
                                    <div class="dropdown-container">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle btn-lg mb-0 me-0" type="button" id="dropdownMenuButtonUser" data-toggle="dropdown" aria-expanded="false"> {{ $userYear }} </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonUser">
                                                <h6 class="dropdown-header">Pilih Tahun</h6>
                                                @foreach ($userYears as $year)
                                                    <a class="dropdown-item" href="{{ route('admin.statistik.index', ['user_year' => $year, 'commodity_year' => $commodityYear, 'order_year' => $orderYear]) }}">{{ $year }}</a>
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
                                @if ($totalUsers == 0 && $totalPembudidaya == 0)
                                    <div class="alert alert-info mt-3">Tidak ada data pengguna atau pembudidaya untuk tahun {{ $userYear }}.</div>
                                @endif
                                <div class="chartjs-bar-wrapper mt-3">
                                    <canvas id="marketingOverview"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Commodity Overview Card -->
                <div class="row flex-grow mt-4">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body position-relative">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="card-subtitle card-subtitle-dash">Jumlah komoditas per bulan pada tahun {{ $commodityYear }}</p>
                                    </div>
                                    <div class="dropdown-container">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle btn-lg mb-0 me-0" type="button" id="dropdownMenuButtonCommodity" data-toggle="dropdown" aria-expanded="false"> {{ $commodityYear }} </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonCommodity">
                                                <h6 class="dropdown-header">Pilih Tahun</h6>
                                                @foreach ($commodityYears as $year)
                                                    <a class="dropdown-item" href="{{ route('admin.statistik.index', ['user_year' => $userYear, 'commodity_year' => $year, 'order_year' => $orderYear]) }}">{{ $year }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-4 justify-content-start">
                                    <div class="d-flex align-items-center">
                                        <h2 class="mb-0 fw-bold text-primary me-1">{{ $totalCommodities }}</h2>
                                        <h5 class="mb-0">Total Komoditas</h5>
                                    </div>
                                </div>
                                @if ($totalCommodities == 0)
                                    <div class="alert alert-info mt-3">Tidak ada data komoditas untuk tahun {{ $commodityYear }}.</div>
                                @endif
                                <div class="chartjs-bar-wrapper mt-3">
                                    <canvas id="commodityOverview"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Overview Card -->
                <div class="row flex-grow mt-4">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card card-rounded">
                            <div class="card-body position-relative">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="card-subtitle card-subtitle-dash">Jumlah order per bulan pada tahun {{ $orderYear }}</p>
                                    </div>
                                    <div class="dropdown-container">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle btn-lg mb-0 me-0" type="button" id="dropdownMenuButtonOrder" data-toggle="dropdown" aria-expanded="false"> {{ $orderYear }} </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonOrder">
                                                <h6 class="dropdown-header">Pilih Tahun</h6>
                                                @foreach ($orderYears as $year)
                                                    <a class="dropdown-item" href="{{ route('admin.statistik.index', ['user_year' => $userYear, 'commodity_year' => $commodityYear, 'order_year' => $year]) }}">{{ $year }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-4 justify-content-start">
                                    <div class="d-flex align-items-center">
                                        <h2 class="mb-0 fw-bold text-primary me-1">{{ $totalOrders }}</h2>
                                        <h5 class="mb-0">Total Order</h5>
                                    </div>
                                </div>
                                @if ($totalOrders == 0)
                                    <div class="alert alert-info mt-3">Tidak ada data order untuk tahun {{ $orderYear }}.</div>
                                @endif
                                <div class="chartjs-bar-wrapper mt-3">
                                    <canvas id="orderOverview"></canvas>
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
    $(document).ready(function () {
        $('.dropdown-toggle').dropdown(); // Initialize Bootstrap dropdowns
        // Initialize User and Pembudidaya Chart
        var ctx1 = document.getElementById('marketingOverview').getContext('2d');
        new Chart(ctx1, @json($chart['data']));
        // Initialize Commodity Chart
        var ctx2 = document.getElementById('commodityOverview').getContext('2d');
        new Chart(ctx2, @json($commodityChart['data']));
        // Initialize Order Chart
        var ctx3 = document.getElementById('orderOverview').getContext('2d');
        new Chart(ctx3, @json($orderChart['data']));
    });
</script>
</body>
</html>