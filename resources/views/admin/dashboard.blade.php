<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AdminLTE CSS (CDN atau local asset) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">

  <!-- Optional theme (dark/light) -->
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    
    @include('admin.partials.navbar')

    @include('admin.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content pt-3">
        <div class="container-fluid">
          @yield('content')
        </div>
      </section>
    </div>

    <!-- Footer (optional) -->
    <footer class="main-footer text-sm text-center">
      <strong>&copy; {{ date('Y') }} Admin Panel.</strong> All rights reserved.
    </footer>

  </div>

  <!-- AdminLTE Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
