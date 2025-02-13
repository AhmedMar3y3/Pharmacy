<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>لوحة التحكم</title>
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <!-- Custom RTL Support -->
  <style>
    /* RTL adjustments */
    body {
      direction: rtl;
      font-family: 'Cairo', sans-serif;
    }

    .sidebar {
      right: 0;
      left: auto;
    }

    @media (min-width: 1200px) {
      #main,
      #footer {
        margin-right: 300px;
        margin-left: 0;
      }
    }
  </style>
</head>

<body>
  @if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif

 <!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
    <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
      <span class="d-none d-lg-block" style="margin-right: 15px; color: white;">صيدلية دكتور رامي</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>

  <!-- Move the profile section to the right -->
  <nav class="header-nav ms-auto"> 
    <ul class="d-flex align-items-center">
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"> <!-- Use 'dropdown-menu-end' for right alignment -->
          <li class="dropdown-header">
            <h6>{{ Auth::user()->name }}</h6>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center">
                <i class="bi bi-box-arrow-right"></i>
                <span>تسجيل الخروج</span>
              </button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</header>



  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span style="background-color: ">الصفحة الرئيسية</span>
        </a>
      </li>

      <li class="nav-heading">الصفحات</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('medications.index') ? 'active' : '' }}" href="{{ route('medications.index') }}">
            <i class="bi bi-capsule"></i>
          <span>الأدوية</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('invoices.index') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
            <i class="bi bi-receipt"></i>
          <span>الفواتير</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('clients.index') ? 'active' : '' }}" href="{{ route('clients.index') }}">
          <i class="fa fa-users"></i>
          <span>العملاء</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('contracts.index') ? 'active' : '' }}" href="{{ route('contracts.index') }}">
            <i class="bi bi-file-earmark-text"></i>
          <span>العقود</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}" href="{{ route('reports.index') }}">
            <i class="bi bi-bar-chart"></i>
          <span>التقارير</span>
        </a>
      </li>

    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}" href="{{ route('profile.index') }}">
        <i class="bi bi-fan"></i>
        <span>الإعدادات<span>  
      </a>
    </li>
    

    </ul>
  </aside>

  <main id="main" class="main">
    @yield('main')
  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; {{ date('Y') }} جميع الحقوق محفوظة لشركة <strong></strong> <a href="https://fourthpyramidagcy.com/">Nexus</a>
      </div>
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
