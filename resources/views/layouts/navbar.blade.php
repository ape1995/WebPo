<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark" style="background-color: #c61325">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
      <li class="nav-item">
        <a class="nav-link" type="button"  data-toggle="modal" data-target="#modalChangePassword">
          <i class="fas fa-key"></i> Change Password
        </a>
      </li>
      

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/logout') }}" role="button">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
</nav>
<!-- /.navbar -->