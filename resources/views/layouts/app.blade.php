<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title', 'Default Title')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('admin/assets/img/favicon/favicon.ico')}}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/pages/page-auth.css') }}" />
    <script src="{{asset('admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{asset('admin/assets/js/config.js') }}"></script>
    @stack('styles')
</head>
<body>
    @yield('content')

    <script src="{{asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{asset('admin/assets/vendor/js/menu.js') }}"></script>
    <script src="{{asset('admin/assets/js/main.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js') }}"></script>
    @stack('scripts')
</body>
</html>
