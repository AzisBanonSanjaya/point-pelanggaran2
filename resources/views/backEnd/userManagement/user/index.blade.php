@extends('backEnd.layouts.main')
@section('title', 'User - '.config('app.name'))
@section('content')
<div class="pagetitle">
    <h1>Data User</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">User Management</li>
        <li class="breadcrumb-item active">User</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <input type="hidden" id="json_permissions" value='@json($permissions)'>
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                      <h5 class="card-title">User List</h5>
                    </div>
                    <div class="col-md-8 mt-2">
                        <div class="d-flex justify-content-end">
                             @can('permission-create')
                                <button class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#modal-create-permission">
                                    <i class="bi bi-clipboard2-data-fill"></i> Set Permission
                                </button>
                            @endcan

                            @can('role-create')
                                <button class="btn btn-info me-2"  data-bs-toggle="modal" data-bs-target="#modal-create-role">
                                    <i class="bi bi-person-fill-add"></i>  Set Role
                                </button>
                            @endcan

                            @can('user-create')
                                <button class="btn btn-primary me-2"  data-bs-toggle="modal" data-bs-target="#modal-create">
                                    <i class="bi bi-plus-circle-fill"></i>  Create User
                                </button>

                                <button class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#modal-import">
                                    <i class="bi bi-file-excel"></i>  Import User
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <!-- Table with stripped rows -->
                    <table class="table table-striped" id="data-table-user">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">NIS/NIP</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Tgl. Lahir</th>
                            <th scope="col">No. Handphone</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
      </div>
    </div>
  </section>
  @include('backEnd.userManagement.user.create')
  @include('backEnd.userManagement.role.create')
  @include('backEnd.userManagement.permission.create')
  @include('backEnd.userManagement.user.edit')
  @include('backEnd.userManagement.user.import')
@endsection
@push('scripts')
  <script src="{{asset('assets/js/validation/user.js')}}"></script>
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
                    { data: 'username'},
                    { data: 'email'},
                    { data: 'role_name'},
                    { data: 'date_of_birth'},
                    { data: 'phone_number'},
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
                        let classRooms = response.classRooms;
                        $('#name_edit').val(response.data.name);
                        $('#username_edit').val(response.data.username);
                        $('#date_of_birth_edit').val(response.data.date_of_birth);
                        $('#phone_number_edit').val(response.data.phone_number);
                        $('#email_edit').val(response.data.email);
                        $('#password_edit').val(response.data.password);
                        let option_role = `<option value="" selected disabled>Pilih Role</option>`;
                        for (let i = 0; i < response.roles.length; i++) {
                            let selected_role = response.roles[i].selected ? "selected='"+response.roles[i].selected+"'" : ""
                            option_role += "<option value='"+response.roles[i].id+"' "+selected_role+">"+response.roles[i].name+"</option>";
                        }

                        let htmlClassRoom = '<option value="" selected disabled>Pilih Kelas</option>';
                        classRooms.forEach(classRoom => {
                            htmlClassRoom += `<option value="${classRoom.id}" ${classRoom.selected}>${classRoom.code}</option>`;
                        });
                        $('#role_id_edit').html(option_role);
                        $('#class_room_id_edit').html(htmlClassRoom);
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
            permissions = permissions ? JSON.parse(permissions) : [];
            $("#clearEditRole").removeClass('hidden');
            $("#title-role").text("Form Role Edit");
            $("#id_role").val(id);
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
            $("#id_role").val('');
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

        function editPermission(id, name){
            $("#clearEditPermission").removeClass('hidden');
            $("#title-permission").text("Form Permission Edit");
            $("#permissionId").val(id);
            $("#permission_name").val(name);
        }

        function clearEditPermission(){
            $("#permissionId").val('');
            $("#permission_name").val('');
            $("#clearEditPermission").addClass('hidden');
            $("#title-permission").text("Form Permission Create");
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
@endpush
