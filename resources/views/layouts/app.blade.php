<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/circular-std/style.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/vector-map/jqvmap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jvectormap/jquery-jvectormap-2.0.2.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/flag-icon-css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <title>{{ config('app.name', 'Deterge App') }}</title>
    @yield('styles')
</head>

<body>
    @yield('content')
    <!-- jquery 3.3.1 js-->
    <script src="{{ asset('vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstrap bundle js-->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <!-- slimscroll js-->
    <script src="{{ asset('vendor/slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- main js-->
    <script src="{{ asset('libs/js/main-js.js') }}"></script>
    <!-- jvactormap js-->
    <script src="{{ asset('vendor/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('vendor/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('vendor/jvectormap/jquery-jvectormap-africa-mill.js') }}"></script>
    <!-- sparkline js-->
    <script src="{{ asset('vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
    <script src="{{ asset('vendor/charts/sparkline/spark-js.js') }}"></script>
    @yield('scripts')
</body>
</html>
