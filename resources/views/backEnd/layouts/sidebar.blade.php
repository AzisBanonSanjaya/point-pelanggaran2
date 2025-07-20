<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <!-- Logo Section -->
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center text-center">
            <!-- <img src="{{ asset('assets/img/sman-1.png') }}" alt="SMAN 1 BANJARAN" class="img-logo" width="60" height="50"> -->
            <span class="d-none d-lg-block fw-bold text-dark" style="font-size: 1.5rem;">
                SMAN 1 BANJARAN
            </span>
        </a>
        
        <!-- Sidebar Toggle Button -->
        <button class="btn border-0 bg-transparent toggle-sidebar-btn" 
                type="button" 
                aria-label="Toggle Sidebar">
            <i class="bi bi-list fs-3 text-dark"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <!-- Profile Dropdown -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" 
                   href="#" 
                   data-bs-toggle="dropdown">
                    <img src="{{ Auth::user()->image_url }}" 
                         alt="Profile" 
                         class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        {{ Auth::user()->name }}
                    </span>
                </a>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <!-- User Info Header -->
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <!-- Profile Link -->
                    <li>
                        <a class="dropdown-item d-flex align-items-center" 
                           href="{{ route('profile.index') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <!-- Logout Form -->
                    <li>
                        <form action="{{ route('logout') }}" 
                              method="POST" 
                              class="w-100">
                            @csrf
                            <button type="submit" 
                                    class="dropdown-item d-flex align-items-center">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
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

        <!-- Dashboard Menu -->
        @can('dashboard')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard*') ? 'active' : 'collapsed' }}" 
               href="{{ route('dashboard') }}">
                <i class="bi bi-house-door text-primary fs-5"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @endcan

        <!-- User Management Menu -->
        @can('user-list')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('user_management/user*') ? 'active' : 'collapsed' }}" 
               href="{{ route('user.index') }}">
                <i class="bi bi-person-circle text-success fs-5"></i>
                <span>User</span>
            </a>
        </li>
        @endcan

        <!-- Master Data Menu with Submenu -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('master_data/*') ? '' : 'collapsed' }}" 
               data-bs-target="#forms-nav" 
               data-bs-toggle="collapse" 
               href="#">
                <i class="bi bi-collection text-warning fs-5"></i>
                <span>Master Data</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            
            <!-- Master Data Submenu -->
            <ul id="forms-nav" 
                class="nav-content collapse {{ request()->is('master_data/*') ? 'show' : '' }}" 
                data-bs-parent="#sidebar-nav">

                <!-- Class Room Submenu -->
                @can('class-room-list')
                <li>
                    <a class="nav-link {{ request()->is('master_data/class-room*') ? 'active' : 'collapsed' }}" 
                       href="{{ route('class-room.index') }}">
                        <i class="bi bi-circle-fill text-muted me-2"></i>
                        <span>Kelas</span>
                    </a>
                </li>
                @endcan

                <!-- Category Submenu -->
                @can('category-list')
                <li>
                    <a class="nav-link {{ request()->is('category') ? 'active' : '' }}" 
                       href="{{ route('category.index') }}">
                        <i class="bi bi-circle-fill text-muted me-2"></i>
                        <span>Jenis Pelanggaran</span>
                    </a>
                </li>
                @endcan

                <!-- Interval Point Submenu -->
                @can('interval-point-list')
                <li>
                    <a class="nav-link {{ request()->is('master_data/interval*') ? 'active' : 'collapsed' }}" 
                       href="{{ route('interval.index') }}">
                        <i class="bi bi-circle-fill text-muted me-2"></i>
                        <span>Interval Poin</span>
                    </a>
                </li>
                @endcan

            </ul>
        </li>

        <!-- Penentuan Sanksi Menu -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('penentuan-sanksi*') ? 'active' : 'collapsed' }}" 
               href="{{ route('penentuan-sanksi.index') }}">
                <i class="bi bi-exclamation-triangle text-danger fs-5"></i>
                <span>Penentuan Sanksi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('manajemen-pelanggaran*') ? 'active' : 'collapsed' }}" 
            href="{{ route('manajemen-pelanggaran.index') }}">
                <i class="bi bi-person-bounding-box text-warning fs-5"></i>
                <span>Manajemen Pelanggaran Siswa</span>
            </a>
        </li>

    </ul>
</aside>
<!-- End Sidebar -->
