@extends('backEnd.layouts.main')
@section('title', 'Jenis Pelanggaran - '.config('app.name'))
@section('content')
<div class="pagetitle">
    <h1>Data Jenis Pelanggaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Jenis Pelanggaran</li>
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
                        <h5 class="card-title">Jenis Pelanggaran List</h5>
                    </div>
                    <div class="col-md-8 mt-2">
                        <div class="d-flex justify-content-end">
                            @can('user-create')
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-create">
                                    <i class="bi bi-plus-circle-fill"></i>  Tambah Jenis Pelanggaran
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="data-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Pelanggaran</th>
                                <th scope="col">Urgensi Pelangaran</th>
                                <th scope="col">Point Pelanggaran</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{!! $category->formatted_type !!}</td>
                                    <td>{{ $category->point }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bi bi-gear-fill"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @can('category-edit')
                                                    <a class="dropdown-item edit" href="#"
                                                       data-url-update="{{route('category.update', $category->id)}}"
                                                       data-url="{{route('category.show', $category->id)}}">
                                                        <em class="bi bi-pencil-fill open-card-option"></em> Edit
                                                    </a>
                                                @endcan
                                                @can('category-delete')
                                                    <a class="dropdown-item delete" href="#"
                                                       data-url-destroy="{{route('category.destroy', $category->id)}}">
                                                        <em class="bi bi-trash-fill close-card"></em> Delete
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

@include('backEnd.masterData.category.create')
@include('backEnd.masterData.category.edit')
@endsection
@push('scripts')
    <script src="{{asset('assets/js/validation/category.js')}}"></script>
    <script>
        $('#data-table tbody').on('click', '.edit', function () {
            let url = $(this).data('url-update');
            let url_hit = $(this).data('url');
            $.ajax({
                url: url_hit,
                type: 'GET',
            }).done(function (response) {
                if(response.status){
                    $("#name_edit").val(response.data.name);
                    $("#point_edit").val(response.data.point);
                    let htmlType = `<option value="Ringan"  ${response.data.type == 'Ringan' ? 'selected' : ''}>Ringan</option>`;
                        htmlType += `<option value="Sedang"  ${response.data.type == 'Sedang' ? 'selected' : ''}>Sedang</option>`;
                        htmlType += `<option value="Berat"  ${response.data.type == 'Berat' ? 'selected' : ''}>Berat</option>`;       
                    $("#type_edit").html(htmlType);
                    $("#form-edit").attr('action', url);
                    $('#modal-edit').modal('show');
                }
            })
            .fail(function () {
                console.log("error");
            });
        });

        $('#data-table tbody').on('click', '.delete', function () {
            let url = $(this).data('url-destroy');
            Swal.fire({
                title: "Are you sure delete it?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed){
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            if(response.status){
                                Swal.fire("Done!", "It was succesfully deleted!", "success").then(function(){
                                    location.reload();
                                });
                            }else{
                                Swal.fire("Error deleting!", "Please try again", "error").then(function(){
                                    location.reload();
                                });
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            Swal.fire("Error deleting!", "Please try again", "error").then(function(){
                                location.reload();
                            });
                    }
                    });
                }
            });
        });
    </script>
@endpush

