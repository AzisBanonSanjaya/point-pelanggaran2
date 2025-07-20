@extends('backEnd.layouts.main')
@section('title', 'Penentuan Sanksi - '.config('app.name'))

@section('content')
<div class="pagetitle">
    <h1>Data Penentuan Sanksi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Penentuan Sanksi</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="card-title">Penentuan Sanksi List</h5>
                    </div>
                    <div class="col-md-8 mt-2">
                        <div class="d-flex justify-content-end">
                            {{-- @can('reporting-create')
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-create">
                                    <i class="bi bi-plus-circle-fill"></i> Create Pelaporan
                                </button>
                            @endcan --}}
                            
                                <a href="{{ route('penentuan-sanksi.create') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-plus-circle-fill"></i> Create Penentuan Sanksi
                                </a>
                            
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code Pelaporan</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Total Point</th>
                                <th>Sanksi</th>
                                <th>Status</th>
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
                                         $status = '<span class="badge bg-warning" style="font-size: 11px"><i class="bi bi-exclamation-octagon me-1"></i> '.$from.' '.$to.' '.$matchedInterval->name. '</span>';
                                    } elseif ($matchedInterval->type === 'Berat') {
                                        $status = '<span class="badge bg-danger" style="font-size: 11px"><i class="bi bi-exclamation-octagon me-1"></i> '.$from.' '.$to.' '.$matchedInterval->name. '</span>';
                                    }
                                }

                                if($sanction->status == 1){
                                    $statusSanksi = '<span class="badge bg-warning" style="font-size: 11px">Sanksi Belum Diajukan</span>';
                                }elseif($sanction->status == 2){
                                    $statusSanksi = '<span class="badge bg-info" style="font-size: 11px">Sanksi Sudah Diajukan</span>';
                                }elseif($sanction->status == 3){
                                    $statusSanksi = '<span class="badge bg-success" style="font-size: 11px">Sanksi Sudah Diapprove</span>';
                                }elseif($sanction->status == 4){
                                    $statusSanksi = '<span class="badge bg-danger" style="font-size: 11px">Sanksi Ditolak Guru BK</span>';
                                }

                                $sanction->type_pelanggaran = $status;
                                $sanction->url_file = $url_file;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sanction->code }}</td>
                                <td>{{ $sanction->student->name}}</td>
                                <td>{{ $sanction->student->classRoom->code}}</td>
                                <td>{{ $sanction->total_point_sum }}</td>
                                <td>{!! $status !!}</td>
                                <td>{!! $statusSanksi    !!}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-gear-fill"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            {{-- @can('reporting-edit') --}}
                                            @if($sanction->status != 3)
                                            <a class="dropdown-item edit" href="{{ route('penentuan-sanksi.edit', $sanction->id) }}">
                                                <i class="bi bi-pencil-fill"></i> Edit
                                            </a>
                                             @endif
                                            @if($sanction->status == 1)
                                            <a class="dropdown-item submit" href="javascript:void(0)" data-url="{{ route('penentuan-sanksi.submitted', $sanction->id) }}" data-sanction='@json($sanction)'>
                                                <i class="bi bi-check"></i> Ajukan Sanksi
                                            </a>
                                            @endif
                                            <a class="dropdown-item detail" href="javascript:void(0)" data-sanction='@json($sanction)'>
                                                <i class="bi bi-search"></i> Detail
                                            </a>
                                            {{-- @endcan --}}
                                            {{-- @can('reporting-delete') --}}
                                                {{-- <a class="dropdown-item delete" href="#"
                                                    data-url-destroy="{{ route('penentuan-sanksi.destroy', $sanction->id) }}">
                                                    <i class="bi bi-trash-fill"></i> Delete
                                                </a> --}}
                                            {{-- @endcan --}}
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
    @include('backEnd.sanctionDecision.detail')
    @include('backEnd.sanctionDecision.submit')
</section>

@endsection

@push('scripts')
<script>
    $('#data-table tbody').on('click', '.edit', function () {
        let url = $(this).data('url');
        let updateUrl = $(this).data('url-update');
        $.ajax({
            url: url,
            type: 'GET',
        }).done(function (response) {
            if (response.status) {
                $("#tanggal_edit").val(response.data.tanggal);
                $("#siswa_edit").val(response.data.siswa_id);
                $("#jenis_pelanggaran_edit").val(response.data.jenis_pelanggaran);
                $("#poin_edit").val(response.data.poin);
                $("#keterangan_edit").val(response.data.keterangan);
                $("#form-edit").attr('action', updateUrl);
                $('#modal-edit').modal('show');
            }
        }).fail(function () {
            console.log("Error loading data");
        });
    });

    $('#data-table tbody').on('click', '.detail', function () {
        let response = $(this).attr('data-sanction') ? JSON.parse($(this).attr('data-sanction')) : [];
        $("#txt-pelaporan").text(response.code);
        $("#txt-siswa").text(response.student.name);
        $("#txt-kelas").text(response.student.class_room.code);
        $("#txt-nis").text(response.student.username);
        $("#txt-wali-kelas").text(response.student.class_room.user.name);
        $("#txt-total-point").text(response.total_point_sum);
        $("#statusWrapper").html(response.type_pelanggaran);
        $("#txt-file").html(response.url_file ? `<a href="${response.url_file}" class="btn btn-info btn-sm" target="_blank ">Lihat File</a>` : '-');
        $("#txt-description").text(response.description);

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
                html += `<td>${item.comment ?? '-'}</td>`;
                html += `</tr>`;
            });
            $("#tbody-pelanggaran").html(html)
        }
        $('#modal-detail').modal('show');
           
    });

    $('#data-table tbody').on('click', '.submit', function () {
        let response = $(this).attr('data-sanction') ? JSON.parse($(this).attr('data-sanction')) : [];
        let url = $(this).attr('data-url');
        $("#form-submit").attr('action', url);
        $(".txt-pelaporan").text(response.code);
        $(".txt-siswa").text(response.student.name);
        $(".txt-kelas").text(response.student.class_room.code);
        $(".txt-nis").text(response.student.username);
        $(".txt-wali-kelas").text(response.student.class_room.user?.name);
        $(".txt-total-point").text(response.total_point_sum);
        
        $(".statusWrapper").html(response.type_pelanggaran);
        $('#modal-submit').modal('show');
    });

    $('#data-table tbody').on('click', '.delete', function () {
        let url = $(this).data('url-destroy');
        Swal.fire({
            title: "Apakah kamu yakin?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire("Berhasil!", "Data berhasil dihapus", "success").then(() => location.reload());
                        } else {
                            Swal.fire("Gagal!", "Gagal menghapus data", "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Gagal!", "Terjadi kesalahan", "error");
                    }
                });
            }
        });
    });
</script>
@endpush