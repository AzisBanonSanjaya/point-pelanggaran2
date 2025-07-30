<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center text-center">
            <span class="d-none d-lg-block fw-bold text-dark" style="font-size: 1.5rem;">
                SMAN 1 BANJARAN
            </span>
        </a>
        <button class="btn border-0 bg-transparent toggle-sidebar-btn" type="button" aria-label="Toggle Sidebar">
            <i class="bi bi-list fs-3 text-dark"></i>
        </button>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ Auth::user()->image_url }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.index') }}">
                            <i class="bi bi-person"></i><span>My Profile</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center">
                                <i class="bi bi-box-arrow-right"></i><span>Sign Out</span>
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
        @can('dashboard')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard*') ? 'active' : 'collapsed' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-house-door text-primary fs-5"></i><span>Dashboard</span>
            </a>
        </li>
        @endcan

        @can('user-list')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('user_management/user*') ? 'active' : 'collapsed' }}" href="{{ route('user.index') }}">
                <i class="bi bi-person-circle text-success fs-5"></i><span>User</span>
            </a>
        </li>
        @endcan

        @can('master-data')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('master_data/*') ? '' : 'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-collection text-warning fs-5"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse {{ request()->is('master_data/*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                @can('class-room-list')
                <li><a class="{{ request()->is('master_data/class-room*') ? 'active' : '' }}" href="{{ route('class-room.index') }}"><i class="bi bi-circle-fill text-muted me-2"></i><span>Kelas</span></a></li>
                @endcan
                @can('category-list')
                <li><a class="{{ request()->is('category') ? 'active' : '' }}" href="{{ route('category.index') }}"><i class="bi bi-circle-fill text-muted me-2"></i><span>Jenis Pelanggaran</span></a></li>
                @endcan
                @can('interval-point-list')
                <li><a class="{{ request()->is('master_data/interval*') ? 'active' : '' }}" href="{{ route('interval.index') }}"><i class="bi bi-circle-fill text-muted me-2"></i><span>Interval Poin</span></a></li>
                @endcan
            </ul>
        </li>
        @endcan

        @can('penentuan-sanksi-list')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('penentuan-sanksi*') ? 'active' : 'collapsed' }}" href="{{ route('penentuan-sanksi.index') }}">
                <i class="bi bi-exclamation-triangle text-danger fs-5"></i><span>Penentuan Sanksi</span>
            </a>
        </li>
        @endcan

        @can('persetujuan-sanksi-pelanggaran-list')
         <li class="nav-item">
            <a class="nav-link {{ request()->is('penentuan-sanksi*') ? 'active' : 'collapsed' }}" href="{{ route('penentuan-sanksi.index') }}">
                <i class="bi bi-exclamation-triangle text-danger fs-5"></i><span>Penentuan Sanksi</span>
            </a>
        </li>
        @endcan
    </ul>
</aside>
<!-- End Sidebar -->

<!-- ======= Custom Sidebar & Header Style ======= -->
<style>
#header.header {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    border-bottom: 2px solid rgba(0,0,0,0.05);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: background 0.3s ease;
}
#header .logo span { font-weight: 700; color: #4154f1; }
#header .nav-profile img { width: 40px; height: 40px; border: 2px solid #4154f1; box-shadow: 0 0 5px rgba(65,84,241,0.3); }
.dropdown-menu-arrow.profile { border-radius: 10px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.dropdown-menu-arrow.profile li a:hover { background: rgba(65,84,241,0.1); color: #4154f1; }

.sidebar { background: linear-gradient(180deg, #4154f1, #f4f6fb); box-shadow: 2px 0 10px rgba(0,0,0,0.05); border-right: 1px solid rgba(0,0,0,0.05); }
.sidebar .nav-item { margin: 3px 0; }
.sidebar .nav-link { font-weight: 500; color: #333; border-radius: 8px; transition: all 0.3s ease; }
.sidebar .nav-link i { margin-right: 5px; transition: transform 0.3s ease; }
.sidebar .nav-link:hover { background: rgba(65,84,241,0.1); color: #4154f1; }
.sidebar .nav-link:hover i { transform: scale(1.2); color: #4154f1; }
.sidebar .nav-link.active { background: #4154f1; color: #fff !important; font-weight: 600; box-shadow: 0 3px 8px rgba(65,84,241,0.3); }
.sidebar .nav-link.active i { color: #fff !important; }
.nav-content a { font-size: 14px; padding-left: 20px; }
.nav-content a.active { background: #e9f0ff; color: #4154f1; font-weight: 600; }
.toggle-sidebar-btn { transition: transform 0.3s ease; }
.toggle-sidebar-btn:hover { transform: rotate(90deg); }
</style>
