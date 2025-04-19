@extends('backEnd.layouts.main')
@section('title', 'Kelas - '.config('app.name'))
@section('content')
<div class="pagetitle">
    <h1>Data Kelas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Kelas</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  {{-- <input type="hidden" id="json_permissions" value='@json($permissions)'> --}}
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                      <h5 class="card-title">Kelas List</h5>
                    </div>
                    <div class="col-md-8 mt-2">
                        <div class="d-flex justify-content-end">
                            <!-- @can('role-create')
                                <button class="btn btn-outline-info me-2"  data-bs-toggle="modal" data-bs-target="#modal-create-role">
                                    <i class="bi bi-person-fill-add"></i>  Set Role
                                </button>
                            @endcan -->

                            @can('user-create')
                                <button class="btn btn-outline-primary"  data-bs-toggle="modal" data-bs-target="#modal-create">
                                    <i class="bi bi-plus-circle-fill"></i>  Create Kelas
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
                            <!-- <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Tanggal Buat</th> -->
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelas as $data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$data->name}}</td>
                                    {{-- <td>{{\Carbon\Carbon::parse($role->created_at)->translatedFormat('l, d F Y')}}</td> --}}
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bi bi-gear-fill"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @can('role-edit')
                                                    <a class="dropdown-item edit" href="#"  data-id="{{$role->id}}" data-url-update="{{route('role.update', $role->id)}}" data-url="{{route('role.show', $role->id)}}">
                                                    <em class="bi bi-pencil-fill open-card-option"></em>
                                                        Edit
                                                </a>
                                                @endcan
                                                @can('role-delete')
                                                <a class="dropdown-item delete" href="#" data-id="{{$role->id}}" data-url-destroy="{{route('role.destroy', $role->id)}}">
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
  @include('backEnd.dataMaster.kelas.create')
  {{-- @include('backEnd.userManagement.role.create')
  @include('backEnd.userManagement.user.edit')  --}}
@endsection
{{-- <!-- @push('scripts')
  <script src="{{asset('assets/js/validation/role.js')}}"></script>
    <script>
        $(document).ready(function () {
            @if (count($errors) > 0)
                $('#modal-create').modal('show');
            @endif
            $('*select[data-selectModalCreateMultiplejs="true"]').select2({
                dropdownParent: $('#modal-create-role'),
                placeholder: function() {
                    return $(this).attr('data-placeholder');
                },
                allowClear: true,
                width: '100%',
            });

            let table = $('#data-table-user').DataTable({
                processing: true,
                serverSide: true,
                scrollToTop: true,
                ajax:{
                    "url": "{{ route('user.fetchDataTable') }}",
                    "type": "GET",
                },
                columns: [
                    { data: 'no', orderable: false, searchable: false },
                    { data: 'name'},
                    { data: 'email'},
                    { data: 'role_name'},
                    { data: 'created_at'},
                    { data: 'actions', orderable: false, searchable: false },
                ],
            });


            $('#data-table-user tbody').on('click', '.edit', function () {
                var id = $(this).data('id');
                var url = $(this).data('url-update');
                var url_hit = $(this).data('url');
                $.ajax({
                    url: url_hit,
                    type: 'GET',
                }).done(function (response) {
                    if(response.status){
                        $('#name_edit').val(response.data.name);
                        $('#username_edit').val(response.data.username);
                        $('#email_edit').val(response.data.email);
                        $('#password_edit').val(response.data.password);
                        let option_role = "";
                        for (let i = 0; i < response.roles.length; i++) {
                            let selected_role = response.roles[i].selected ? "selected='"+response.roles[i].selected+"'" : ""
                            option_role += "<option value='"+response.roles[i].id+"' "+selected_role+">"+response.roles[i].name+"</option>";
                        }
                        $('#role_id_edit').html(option_role);
                        $("#form-edit").attr('action', url);
                        $('#modal-edit').modal('show');
                    }
                })
                .fail(function () {
                    console.log("error");
                });
            });
            $('#data-table-user tbody').on('click', '.delete', function () {
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

        function editRole(id, name, permissions){
            $("#clearEditRole").removeClass('hidden');
            $("#title-role").text("Form Role Edit");
            $("#role_id").val(id);
            $("#role_name").val(name);
            $("#permission_id_create").empty();
            let dataPermission = $("#json_permissions").val() ? JSON.parse($("#json_permissions").val()) : null;
            let html = "";
            dataPermission.forEach(data => {
                    if(permissions.includes(data.id)){
                        html += `<option value="${data.id}" selected>${data.name}</option>`;
                    }else{
                        html += `<option value="${data.id}">${data.name}</option>`;
                    }
            });
            $("#permission_id_create").html(html);
        }

        function clearEditRole(){
            $("#role_id").val('');
            $("#role_name").val('');
            $("#permission_id_create").empty();
            let dataPermission = $("#json_permissions").val() ? JSON.parse($("#json_permissions").val()) : null;
            let html = "";
            dataPermission.forEach(data => {
                html += `<option value="${data.id}">${data.name}</option>`;
            });
            $("#permission_id_create").html(html);
            $("#clearEditRole").addClass('hidden');
            $("#title-role").text("Form Role Create");
        }

        function deleteRole(id, url){
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
        }
    </script>
@endpush --> --}}
