@extends('backEnd.layouts.main')
@section('title', 'Persetujuan Sanksi Pelanggaran - '.config('app.name'))

@section('content')
<div class="pagetitle">
    <h1>Data Persetujuan Sanksi Pelanggaran</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Persetujuan Sanksi Pelanggaran</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="card-title">Persetujuan Sanksi Pelanggaran List</h5>
                    </div>
                </div>

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
                                <th>Action</th>
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
                                    $matchedInterval = $intervalPoint->last(); // fallback jika tidak ada yang cocok
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

                                // if(!Auth::user()->hasRole('Guru Bk')){
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
                                        <span class="badge bg-info text-dark" style="font-size: 11px">RINGAN</span>
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
                                <td>{!! $statusSanksi    !!}</td>
                                <td>{{$sanction->userCreated?->name}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-gear-fill"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item detail" href="javascript:void(0)" data-sanction='@json($sanction)'>
                                                <i class="bi bi-search"></i> Detail
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- End Table -->
            </div>
        </div>
        </div>
    </div>
    @include('backEnd.violationManagement.detail')
</section>

@endsection

@push('scripts')
<script>
    $('#data-table tbody').on('click', '.detail', function () {
        let response = $(this).attr('data-sanction') ? JSON.parse($(this).attr('data-sanction')) : [];
        $("#txt-pelaporan").text(response.code);
        $("#txt-siswa").text(response.student.name);
        $("#txt-kelas").text(response.student.class_room.code);
        $("#txt-nis").text(response.student.username);
        $("#txt-wali-kelas").text(response.student.class_room.user?.name);
        $("#txt-total-point").text(response.total_point_sum);
        $("#txt-file").html(response.url_file ? `<a href="${response.url_file}" class="btn btn-info btn-sm" target="_blank ">Lihat File</a>` : '-');
        $("#txt-description").text(response.description);

        if(response.status == 1 || response.status == 3){
            $("#statusWrapper").html(
                `<span class="badge bg-secondary" style="font-size: 11px">SANKSI BELUM ADA</span>`
            );
        }else{
            $("#statusWrapper").html(
                response.type_pelanggaran
            );
        }

        if(response.status == 3){
            $("#btn-reject").removeClass('hidden');
            $("#btn-approve").removeClass('hidden');
            $("#btn-reject").attr('data-id', response.id);
            $("#btn-approve").attr('data-id', response.id);
          
        }else{
            $("#btn-reject").addClass('hidden');
            $("#btn-approve").addClass('hidden');
        }

        if(response.status == 4){
            $("#wrapper-reject").removeClass('hidden');
            $("#txt-reject-reason").text(response.reason_reject);

        }else{
            $("#wrapper-reject").addClass('hidden');
             $("#txt-reject-reason").text('-');
        }
        
        if(response.sanction_decision_detail.length > 0){
            let html = "";
            response.sanction_decision_detail.forEach(function(item, index) {
                html += `<tr>`;
                html += `<td>${index + 1}</td>`;
                html += `<td>${item.category.name}</td>`;
                html += `<td>${item.incident_date}</td>`;
                html += `<td>${item.category.point}</td>`;
                if(item.file){
                    html += `<td><button type="button" class="btn btn-sm btn-info" onclick="onFile('${item.file_url}')"><i class="bi bi-image me-2"></i>Lihat File</button></td>`;
                }else{
                    html += `<td>TIDAK ADA</td>`;
                }
                html += `<td>${item.comment ?? '-'}</td>`;
                html += `</tr>`;
            });
            $("#tbody-pelanggaran").html(html)
        }
        $('#modal-detail').modal('show');
           
    });

   $("#btn-approve").on("click", function(e){
        e.preventDefault();
        let id = $(this).attr('data-id');
         Swal.fire({
            title: "Apakah kamu yakin untuk menyetujui sanksi ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#146c43",
            confirmButtonText: "Ya, Approve!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('penentuan-sanksi.approve') }}",
                    type: "POST",
                    data: {
                        "id": id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire("Berhasil!", "Data berhasil diapprove", "success").then(() => location.reload());
                        } else {
                            Swal.fire("Gagal!", "Gagal menyetujui data", "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Gagal!", "Terjadi kesalahan", "error");
                    }
                });
            }
        });
    });

    function onFile(file){
        Swal.fire({
            imageUrl: file,
            imageAlt: "File"
        });
    }
</script>
@endpush