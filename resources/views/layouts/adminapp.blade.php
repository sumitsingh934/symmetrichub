<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr"
      data-theme="theme-default"
      data-assets-path="{{ asset('admin/assets/') }}"
      data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Admin Dashboard')</title>
  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon/favicon.ico') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <!-- Bootstrap 5 CSS -->




  <!-- Icons & Core CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/theme-default.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('adminassets/plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('adminassets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('adminassets/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/2.1.1/css/colReorder.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />








  <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('admin/assets/js/config.js') }}"></script>

  @stack('head')
</head>
<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Sidebar -->
      @include('partials.sidebar')

      <!-- Layout page -->
      <div class="layout-page">
        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Main content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            @yield('content')
          </div>
          <!-- /Main content -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- /Content wrapper -->
      </div>
      <!-- /Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- /Layout wrapper -->

  <!-- Core JS -->
  <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>

  <!-- Vendors JS -->
  <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('admin/assets/js/main.js') }}"></script>

  <!-- Page JS -->
  <script src="{{ asset('admin/assets/js/dashboards-analytics.js') }}"></script>

  <script async defer src="https://buttons.github.io/buttons.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('adminassets/plugins/toastr/toastr.min.js') }} "></script>
    <script src="{{ asset('adminassets/plugins/select2/js/select2.min.js') }} "></script>
    <script src="{{ asset('adminassets/plugins/datatable/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('adminassets/plugins/datatable/js/dataTables.bootstrap5.min.js') }} "></script>
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('adminassets/js/crud.js') }} "></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  @stack('scripts')
</body>
</html>
