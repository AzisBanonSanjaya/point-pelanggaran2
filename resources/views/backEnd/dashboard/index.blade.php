@extends('backEnd.layouts.main')
@section('title', 'Dashboard - ' . config('app.name'))
@section('content')


<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Dashboard</li>
      </ol>
    </nav>

<section class="section dashboard">
    <div class="row">

       <!-- Selamat Datang -->
    <div class="col-12 mb-4">
        {{-- Anda bisa aktifkan kartu selamat datang di bawah ini jika mau --}}
        {{-- 
        <div class="card shadow-sm border-0 text-center bg-primary text-white">
            <div class="card-body py-3">
                <div class="d-flex justify-content-center mb-2">
                    <img src="{{ asset('assets/img/sman-1.png') }}" alt="Logo Sekolah" class="img-fluid" style="height: 60px;">
                </div>
                <h5 class="card-title fw-semibold mb-1" style="font-size: 1.1rem;">Selamat Datang, {{ Auth::user()->name }}</h5>
                <p class="mb-0" style="font-size: 0.9rem;">
                    Hari ini: <strong>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</strong>
                </p>
            </div>
        </div> 
        --}}
    </div>

    <!-- Statistik Singkat -->
    <div class="col-md-6 mb-4">
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

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-start border-4 border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-bar-chart-fill fs-2 text-success me-3"></i>
                    <div>
                        <h6 class="mb-1">Total Pelanggaran Bulan Ini</h6>
                        <h4 class="mb-0">{{ $totalPelanggaranByMonth }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-start border-4 border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-circle fs-2 text-info me-3"></i>
                    <div>
                        <h6 class="mb-1">Sanksi Ringan</h6>
                        <h4 class="mb-0">{{$urgensiCount['ringan']}}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-start border-4 border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-shield-exclamation fs-2 text-warning me-3"></i>
                    <div>
                        <h6 class="mb-1">Sanksi Sedang</h6>
                        <h4 class="mb-0">{{$urgensiCount['sedang']}}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-start border-4 border-danger">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-x-octagon-fill fs-2 text-danger me-3"></i>
                    <div>
                        <h6 class="mb-1">Sanksi Berat</h6>
                       <h4 class="mb-0">{{$urgensiCount['berat']}}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Pelanggaran Siswa Terbaru</h5>
                <div class="table-responsive">
                <table class="table table-striped" id="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Total Point</th>
                            <th>Urgensi</th>
                            <th>Sanksi</th>
                            <th>Status</th>
                            <th>Pelapor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sanctions as $sanction)
                        @php
                            $totalPoint = $sanction->total_point_sum;
                            $url_file = $sanction->file ? asset('storage/'. $sanction->file) : null;
                            $intervalPoint = App\Models\MasterData\IntervalPoint::orderBy('from')->get();

                            $matchedInterval = $intervalPoint->first(function ($point) use ($totalPoint) {
                                return $totalPoint >= $point->from && $totalPoint <= $point->to;
                            });

                            if (!$matchedInterval && $intervalPoint->count() > 0) {
                                $matchedInterval = $intervalPoint->last(); 
                            }

                            $from = '';
                            $to = '';
                            $status = '';
                            $statusSanksi = '';
                            if ($matchedInterval) {
                               $from = $matchedInterval->from >= 110 ? '>= '.$matchedInterval->from: $matchedInterval->from;
                               $to = $matchedInterval->from >= 110 ? '' : 's.d. '.$matchedInterval->to;
                                if ($matchedInterval->type === 'Ringan') {
                                    $status = '<span class="badge bg-info text-dark" style="font-size: 11px"><i class="bi bi-exclamation-octagon me-1"></i> '.$from.' '.$to.' '.$matchedInterval->name. '</span>';
                                } elseif ($matchedInterval->type === 'Sedang') {
                                     $status = '<span class="badge bg-warning text-dark" style="font-size: 11px"><i class="bi bi-exclamation-octagon me-1"></i> '.$from.' '.$to.' '.$matchedInterval->name. '</span>';
                                } elseif ($matchedInterval->type === 'Berat') {
                                    $status = '<span class="badge bg-danger" style="font-size: 11px"><i class="bi bi-exclamation-octagon me-1"></i> '.$from.' '.$to.' '.$matchedInterval->name. '</span>';
                                }
                            }

                            if($sanction->status == 1){
                                $statusSanksi = '<span class="badge bg-info" style="font-size: 11px">Menunggu Tindakan</span>';
                            }elseif($sanction->status == 2){
                                $statusSanksi = '<span class="badge bg-success" style="font-size: 11px">Selesai Ditindak</span>';
                            }elseif($sanction->status == 3){
                                $statusSanksi = '<span class="badge bg-warning text-dark" style="font-size: 11px">Menunggu Persetujuan Kepala Sekolah</span>';
                            }elseif($sanction->status == 4){
                                $statusSanksi = '<span class="badge bg-danger" style="font-size: 11px">Sanksi Ditolak Guru BK</span>';
                            }
                            $sanction->type_pelanggaran = $status;
                            $sanction->url_file = $url_file;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sanction->student->name}}</td>
                            <td>{{ $sanction->student->classRoom->code}}</td>
                            <td>{{ $sanction->total_point_sum }}</td>
                            <td>
                                 @if ($matchedInterval->type === 'Ringan') 
                                    <span class="badge bg-info" style="font-size: 11px">RINGAN</span>
                                @elseif ($matchedInterval->type === 'Sedang') 
                                        <span class="badge bg-warning text-dark" style="font-size: 11px"> SEDANG</span>
                                @elseif ($matchedInterval->type === 'Berat') 
                                    <span class="badge bg-danger" style="font-size: 11px">BERAT</span>
                                @endif
                            </td>
                            <td>
                                @if(in_array($sanction->status, [1,3]))
                                    <span class="badge bg-secondary" style="font-size: 11px">SANKSI BELUM ADA</span>
                                @else
                                {!! $status !!}
                                @endif
                            </td>
                            <td>{!! $statusSanksi !!}</td>
                            <td>{{$sanction->userCreated?->name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- End Table -->
            </div>
        </div>
    </div>

</div>
<style>
/* Background dengan gradasi animasi */
body {
    background: linear-gradient(120deg, #4154f1, #6a82fb, #2d98da);
    background-size: 300% 300%;
    animation: gradientAnimation 10s ease infinite;
}
@keyframes gradientAnimation {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Card dashboard */
.card {
    border: none !important;
    border-radius: 12px;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(8px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* Judul halaman */
.pagetitle h1 {
    color: #fff;
    font-weight: 700;
    text-shadow: 0 2px 6px rgba(0,0,0,0.3);
}
.breadcrumb {
    background: transparent;
    color: #fff;
}
.breadcrumb-item a { color: #fff; }

/* Table */
.table {
    border-radius: 10px;
    overflow: hidden;
}
.table thead {
    background: #4154f1;
    color: #fff;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(65,84,241,0.05);
}
.table tbody tr:hover {
    background-color: rgba(65,84,241,0.15);
}

/* Badge styling */
.badge {
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Statistik cards icons */
.card i {
    padding: 10px;
    background: rgba(65,84,241,0.1);
    border-radius: 50%;
}

/* Efek animasi fade-in untuk semua elemen */
.section.dashboard .row > div {
    animation: fadeIn 0.8s ease forwards;
    opacity: 0;
}
@keyframes fadeIn {
    to { opacity: 1; }
}
</style>
</section>
@endsection
