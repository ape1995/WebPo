<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('assets/images/yamazaki.ico') }}">
  <meta name="theme-color" content="#c61325"/>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>
    @hasSection('title')
      @yield('title')
    @else
      {{ config('app.name') }}
    @endif
  </title>

  {{-- <link rel="manifest" href="/manifest.json"> --}}

  <!-- Google Font: Source Sans Pro -->
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">

  {{-- Datatables --}}
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
  {{-- Datatables --}}
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
  {{-- Select2 --}}
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" />
  <link rel="stylesheet" type="text/css" href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css">
  {{-- Timepicker --}}
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
  
  @yield('css')
  <style>
    label{
      font-size: 12px !important;
    }
    .btn-xs {
      padding: 5px 5px;
      font-size: 14px;
      border-radius: 2px;
    }
    .money{
      text-align: right;
    }
    .carousel-inner img {
      width: 100%;
      height: 100%;
    }
    .hide-component {
      display: none;
    }
    .table {
      font-size: 12px !important;
    }
    .card {
      font-size: 13px !important;
    }
    .nav-link {
      font-size: 13px !important;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">

  @include('layouts.change_password')

  <div class="wrapper">

    @include('layouts.navbar')

    @include('layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <div class="container my-1">
        @include('flash-message')
        @include('adminlte-templates::common.errors')
      </div>

      @yield('content')
      
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
      <div class="float-right d-none d-sm-inline">
        YI
      </div>
      <strong>Yamazaki Indonesia</strong>
    </footer>
  </div>
  <!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

{{-- Datatables --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

{{-- select2 --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
{{-- Masking --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
{{-- time picker --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>  

<script>
    $.fn.select2.defaults.set("theme", "bootstrap");
    $(".select2js").select2({
        width: null
    })
</script>

{{-- <script>
  window.onload = () => {
    'use strict';

    if ('serviceWorker' in navigator) {
      navigator.serviceWorker
              .register('/sw.js');
    }
  }

</script> --}}

@stack('page_scripts')
@yield('js')

</body>
</html>