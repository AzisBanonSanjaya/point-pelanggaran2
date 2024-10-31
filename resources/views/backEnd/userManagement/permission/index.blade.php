@extends('backEnd.layouts.main')
@section('title', 'Permission - '.config('app.name'))
@section('content')
<div class="pagetitle">
    <h1>Data Permission</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">User Management</li>
        <li class="breadcrumb-item active">Permission</li>
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
                      <h5 class="card-title">Permission List</h5>
                    </div>
                    <div class="col-md-8 mt-2">
                        <div class="d-flex justify-content-end">
                            @can('permission-create')
                                  <button class="btn btn-outline-primary"  data-bs-toggle="modal" data-bs-target="#modal-create">
                                    <i class="bi bi-plus-circle-fill"></i>  Create Permission
                                </button>
                            @endcan

                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <!-- Table with stripped rows -->
                    <table class="table table-striped" id="data-table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Tanggal Buat</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td>{{\Carbon\Carbon::parse($permission->created_at)->translatedFormat('l, d F Y')}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bi bi-gear-fill"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @can('role-edit')
                                                    <a class="dropdown-item edit" href="#"  data-id="{{$permission->id}}" data-url-update="{{route('permission.update', $permission->id)}}" data-url="{{route('permission.show', $permission->id)}}">
                                                    <em class="bi bi-pencil-fill open-card-option"></em>
                                                        Edit
                                                </a>
                                                @endcan
                                                @can('permission-delete')
                                                <a class="dropdown-item delete" href="#" data-id="{{$permission->id}}" data-url-destroy="{{route('permission.destroy', $permission->id)}}">
                                                    <em class="bi bi-trash-fill close-card"></em>
                                                    Delete
                                                </a>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
      </div>
    </div>
  </section>
  @include('backEnd.userManagement.permission.create')
  @include('backEnd.userManagement.permission.edit')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            @if (count($errors) > 0)
                $('#modal-create').modal('show');
            @endif
            $('#data-table tbody').on('click', '.edit', function () {
                var id = $(this).data('id');
                var url = $(this).data('url-update');
                var url_hit = $(this).data('url');
                $.ajax({
                    url: url_hit,
                    type: 'GET',
                }).done(function (response) {
                    if(response.status){
                        $('#name_edit').val(response.data.name);
                        $("#form-edit").attr('action', url);
                        $('#modal-edit').modal('show');
                    }
                })
                .fail(function () {
                    console.log("error");
                });
            });
            $('#data-table tbody').on('click', '.delete', function () {
                var id = $(this).data('id');
                var url = $(this).data('url-destroy');
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
        });
    </script>
@endpush
