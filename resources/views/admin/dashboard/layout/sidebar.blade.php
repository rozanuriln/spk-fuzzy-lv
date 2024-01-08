
<!-- Sidebar Menu -->
@php
    $user_id = auth()->user()->id;
        // dd($user_id);
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{ asset('adminlte') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">BACKEND</span>
    </a>

    <!-- Sidebar -->

    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('adminlte') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="/dashboard" >
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('employee') ? 'active' : '' }}" aria-current="page" href="/employee">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Karyawan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('user') ? 'active' : '' }}" aria-current="page" href="/user">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link {{ Request::is('variabel') ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Master
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/variabel" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Variabel</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/himpunan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Himpunan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/fungsi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fungsi</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- <li class="nav-item">
            <a class="nav-link {{ Request::is('position') ? 'active' : '' }}" aria-current="page" href="/position">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Jabatan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('criteria') ? 'active' : '' }}" aria-current="page" href="/criteria">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Kriteria
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('calculation') ? 'active' : '' }}" aria-current="page" href="/calculation">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Data Hasil Perhitungan
              </p>
            </a>
          </li> --}}

          {{-- <li class="nav-item d-none">
            <a class="nav-link {{ Request::is('position') ? 'active' : '' }}" aria-current="page" href="{{ route('position.index') }}">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Jabatan
              </p>
            </a>
          </li>
          <li class="nav-item d-none">
            <a class="nav-link {{ Request::is('criteria') ? 'active' : '' }}" aria-current="page" href="{{ route('criteria.index') }}">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Kriteria
              </p>
            </a>
          </li> --}}
          <li class="nav-item">
          <div class="navbar-nav">
            <div class="nav-item text-nowrap">
              <form action="/logout" method="post">
                  @csrf
                <button type="submit" class="nav-link px-3 bg-dark border-0">Keluar <span data-feather="log-out"></span></button>
                </form>
            </div>
          </div>
          </li>


      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
