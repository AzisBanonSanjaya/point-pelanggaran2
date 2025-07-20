@extends('backEnd.layouts.main')
@section('title', 'Dashboard - ' . config('app.name'))
@section('content')

<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Dashoard</li>
      </ol>
    </nav>

<section class="section dashboard">
    <div class="row">

       <!-- Selamat Datang -->
    <div class="col-12 mb-4">
        {{-- <div class="card shadow-sm border-0 text-center bg-primary text-white">
            <div class="card-body py-3">
                <div class="d-flex justify-content-center mb-2">
                    <img src="{{ asset('assets/img/sman-1.png') }}" alt="Logo Sekolah" class="img-fluid" style="height: 60px;">
                </div>
                <h5 class="card-title fw-semibold mb-1" style="font-size: 1.1rem;">Selamat Datang, {{ Auth::user()->name }}</h5>
                <p class="mb-0" style="font-size: 0.9rem;">
                    Hari ini: <strong>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</strong>
                </p>
            </div>
        </div> --}}
    </div>
        <!-- Statistik Singkat -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-2 text-primary me-3"></i>
                        <div>
                            <h6 class="mb-1">Total Pelanggaran</h6>
                            <h4 class="mb-0">{{ $totalPelanggaran }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-lines-fill fs-2 text-success me-3"></i>
                        <div>
                            <h6 class="mb-1">Siswa Terdata</h6>
                            <h4 class="mb-0">{{ $totalSiswa }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-start border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people-fill fs-2 text-danger me-3"></i>
                        <div>
                            <h6 class="mb-1">Guru & Wali Kelas</h6>
                            <h4 class="mb-0">{{ $totalGuru }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Pengguna -->
        <div class="col-md-4 mb-4">
            <div class="card info-card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-person-badge fs-1 text-primary"></i>
                    <h5 class="mt-3 mb-1 fw-semibold">Guru BK</h5>
                    <p class="text-muted small">Mengelola data pelanggaran dan memberikan sanksi.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card info-card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-person-check-fill fs-1 text-success"></i>
                    <h5 class="mt-3 mb-1 fw-semibold">Wali Kelas</h5>
                    <p class="text-muted small">Memonitor siswa dan menyetujui pelanggaran.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card info-card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle fs-1 text-warning"></i>
                    <h5 class="mt-3 mb-1 fw-semibold">Siswa</h5>
                    <p class="text-muted small">Melihat data pelanggaran dan sanksi yang diberikan.</p>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
