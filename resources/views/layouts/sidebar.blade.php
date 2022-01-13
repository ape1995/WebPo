<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-danger elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{ asset('assets/images/yamazaki.png') }}" alt="Logo" class="brand-image img-rounded elevation-3" >
      <img src="{{ asset('assets/images/my-roti.png') }}" alt="Logo" class="img-rounded brand-text" width="40%" >
      {{-- <span class="brand-text font-weight-light">Yamazaki</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-1 pb-1 pl-2 mb-1 d-flex">
        <div class="info">
          <a class="d-block">Hello, {{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        @include('layouts.menu')
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>