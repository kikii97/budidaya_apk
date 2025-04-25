<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <!-- HAMBURGER ICON (show on small and medium screens only) -->
<!-- HAMBURGER ICON (show on small and medium screens only) -->
<li class="nav-item d-block d-lg-none">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
      <i class="fas fa-bars"></i>
    </a>
  </li>
  
      <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
      </li>
    </ul>
  
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-sm btn-danger">Logout</button>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  