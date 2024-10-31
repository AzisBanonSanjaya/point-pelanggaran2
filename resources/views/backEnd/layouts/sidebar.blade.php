<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
    <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center text-center">
        <img src="{{ asset('assets/img/sman1.jfif') }}" alt="SMAN 1 BANJARAN" class="img-logo" width="60" height="50">
        {{-- <span class="d-none d-lg-block">NiceAdmin</span> --}}
    </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{Auth::user()->image_url}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->name}}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{Auth::user()->name}}</h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{route('profile.index')}}">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <form action="{{ route('logout') }}" method="POST">
					@csrf
					<button type="submit" class="dropdown-item">Sign Out</button>
				</form>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

  <!-- Main Sidebar Container -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        @can('dashboard')
            <li class="nav-item">
            <a class="nav-link  {{ (request()->is('dashboard*')) ? 'active' : 'collapsed' }}" href="{{route('dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
            </li><!-- End Dashboard Nav -->
        @endcan

        @can('user-list')
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('user_management/user*')) ? 'active' : 'collapsed' }}" href="{{route('user.index')}}"  class="">
                <i class="bi bi-person"></i><span>User</span>
                </a>
            </li>
        @endcan

        <!-- @can('user-list') -->
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('master_data/kelas*')) ? 'active' : 'collapsed' }}" href="{{route('kelas.index')}}"  class="">
                <i class="bi bi-person"></i><span>kelas</span>
                </a>
            </li>
        <!-- @endcan -->

    </ul>
  </aside><!-- End Sidebar-->
