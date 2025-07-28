@extends('backEnd.layouts.main')
@section('title', 'Interval Poin - '.config('app.name'))

@section('content')
<div class="pagetitle">
    <h1>Data Interval Poin</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Master Data</li>
            <li class="breadcrumb-item active">Interval Poin</li>
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
                        <h5 class="card-title">Interval Poin List</h5>
                    </div>
                    <div class="col-md-8 mt-2">
                        <div class="d-flex justify-content-end">
                            @can('interval-point-create')
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create">
                                    <i class="bi bi-plus-circle-fill"></i> Tambah Interval Poin
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Interval Poin</th>
                                <th>Nama Sanksi</th>
                                <th>Urgensi Pelanggaran</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($intervalPoints as $interval)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $interval->from.' - '.$interval->to }}</td>
                                <td>{{ $interval->name }}</td>
                                <td>{!! $interval->formatted_type !!}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-gear-fill"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('interval-point-edit')
                                            <a class="dropdown-item edit" href="#"
                                                data-url-update="{{ route('interval.update', $interval->id) }}"
                                                data-url="{{ route('interval.show', $interval->id) }}">
                                                <i class="bi bi-pencil-fill"></i> Edit
                                            </a>
                                            @endcan
                                            @can('interval-point-delete')
                                            <a class="dropdown-item delete" href="#"
                                                data-url-destroy="{{ route('interval.destroy', $interval->id) }}">
                                                <i class="bi bi-trash-fill"></i> Delete
                                            </a>
                                            @endcan
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
</section>

@include('backEnd.masterData.intervalPoint.create')
@include('backEnd.masterData.intervalPoint.edit')
@endsection

@push('scripts')
<script src="{{asset('assets/js/validation/intervalPoint.js')}}"></script>
<script>
    
    $('#data-table tbody').on('click', '.edit', function () {
        let url = $(this).data('url');
        let updateUrl = $(this).data('url-update');
        $.ajax({
            url: url,
            type: 'GET',
        }).done(function (response) {
            if (response.status) {
                $("#from_edit").val(response.data.from);
                $("#to_edit").val(response.data.to);
                $("#name_edit").val(response.data.name);
                let htmlType = `<option value="Ringan"  ${response.data.type == 'Ringan' ? 'selected' : ''}>Ringan</option>`;
                    htmlType += `<option value="Sedang"  ${response.data.type == 'Sedang' ? 'selected' : ''}>Sedang</option>`;
                    htmlType += `<option value="Berat"  ${response.data.type == 'Berat' ? 'selected' : ''}>Berat</option>`;       
                $("#type_edit").html(htmlType);
                $("#form-edit").attr('action', updateUrl);
                $('#modal-edit').modal('show');
            }
        }).fail(function () {
            console.log("Error loading data");
        });
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
