
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Foodest</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/map.css') }}">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7Ri7hLGyfRD0pwimvavQrrGRWCI4Tf_Q&libraries=places,geometry"></script>
</head>
<body class="hold-transition sidebar-mini" >
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/') }}" class="nav-link">Home</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="./imgs/logo.png" alt="Foodest Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Foodest</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="imgs/profile/{{Auth::user()->photo}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt purple"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="nav-icon fas fa-user orange"></i>
              <p>
                Profile
              </p>
            </router-link>
          </li> 
          @if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant') || \Gate::allows('isUser'))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog teal"></i>
              <p>
                Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            @if(\Gate::allows('isAdmin'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" class="nav-link">
                  <i class="fas fa-users nav-icon blue"></i>
                  <p>Users</p>
                </router-link>
              </li>
            </ul>
            @endif
            @if(\Gate::allows('isAdmin'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/emails" class="nav-link">
                  <i class="fas fa-envelope nav-icon blue"></i>
                  <p>Emails</p>
                </router-link>
              </li>
            </ul>
            @endif
            @if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/my-restaurants" class="nav-link">
                  <i class="fas fa-utensils nav-icon blue"></i>
                  <p>Restaurants</p>
                </router-link>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/restaurant-orders" class="nav-link">
                  <i class="fas fa-store nav-icon blue"></i>
                  <p>Restaurant Orders</p>
                </router-link>
              </li>
            </ul>
            @endif
            @if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/my-products" class="nav-link">
                  <i class="fas fa-hamburger nav-icon blue"></i>
                  <p>Foods</p>
                </router-link>
              </li>
            </ul>
            @endif
            @if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant') || \Gate::allows('isUser'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/my-orders" class="nav-link">
                  <i class="fas fa-shopping-basket nav-icon blue"></i>
                  <p>My Orders</p>
                </router-link>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/track-order-map" class="nav-link">
                  <i class="fas fa-shipping-fast nav-icon blue"></i>
                  <p>Track Order</p>
                </router-link>
              </li>
            </ul>
            @endif
          </li> 
          @endif    
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a class="nav-link logout" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="nav-icon fas fa-sign-out-alt red"></i>
                <p>
                  {{ __('Log Out') }}
                </p>
              </a>
          </form>
          </li>    
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <router-view></router-view> 

        <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2021 <a href="https://github.com/AndZeka/Foodest" target="blank">Foodest</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
@auth
  <script>
    window.user = @json(auth()->user())
  </script>
@endauth

<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/map.js') }}"></script>
</body>
</html>
