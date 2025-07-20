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
                            <th scope="col">Kelas</th>
                            <th scope="col">Kode</th>
                            <th scope="col">Wali Kelas</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classRooms as $data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->code}}</td>
                                    <td>{{$data->user?->name.' | '.$data->user?->username}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bi bi-gear-fill"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @can('class-room-edit')
                                                    <a class="dropdown-item edit" href="#" data-url-update="{{route('class-room.update', $data->id)}}" data-url="{{route('class-room.show', $data->id)}}">
                                                        <em class="bi bi-pencil-fill open-card-option"></em>
                                                        Edit
                                                    </a>
                                                @endcan
                                                 <a class="dropdown-item detail" href="#" data-user="{{ $data->user?->name.' | '.$data->user?->username }}" data-code="{{ $data->code }}" data-student='@json($data->student)' data-count="{{ $data->student->count() }}">
                                                    <em class="bi bi-people-fill open-card-option"></em>
                                                    Detail Siswa
                                                </a>
                                                @can('class-room-delete')
                                                    <a class="dropdown-item delete" href="#" data-url-destroy="{{route('class-room.destroy', $data->id)}}">
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
  @include('backEnd.masterData.classRoom.create')
  @include('backEnd.masterData.classRoom.edit')
  @include('backEnd.masterData.classRoom.show')
@endsection
@push('scripts')
    <script src="{{asset('assets/js/validation/classRoom.js')}}"></script>
    <script>
        $('#data-table tbody').on('click', '.edit', function () {
            let url = $(this).data('url-update');
            let url_hit = $(this).data('url');
            $.ajax({
                url: url_hit,
                type: 'GET',
            }).done(function (response) {
                if(response.status){
                    let users = response.users;
                    let alphabets = response.alphabets;

                    let htmlName = `<option  value="Kelas X (10)" ${response.data.name == 'Kelas X (10)' ? 'selected' : ''}>Kelas X (10)</option>`;
                        htmlName += `<option value="Kelas XI (11)" ${response.data.name == 'Kelas XI (11)' ? 'selected' : ''}>Kelas XI (11)</option>`;
                        htmlName += `<option value="Kelas XII (12)" ${response.data.name == 'Kelas XII (12)' ? 'selected' : ''}>Kelas XII (12)</option>`;


                    let htmlMajor = `<option value="${response.data.major}"  ${response.data.major == 'IPA' ? 'selected' : ''}>IPA</option>`;
                        htmlMajor += `<option value="${response.data.major}" ${response.data.major == 'IPS' ? 'selected' : ''}>IPS</option>`;

                    let htmlUser = '';
                    users.forEach(user => {
                       htmlUser += `<option value="${user.id}" ${user.selected}>${user.name}</option>`;
                    });
                    
                    let htmlAlphabets = '';
                    alphabets.forEach(alphabet => {
                       htmlAlphabets += `<option value="${alphabet}" ${alphabet == response.selectedAlphabet ? 'selected' : ''}>${alphabet}</option>`;
                    });

                    $("#name_edit").html(htmlName);
                    $("#code_edit").html(htmlAlphabets);
                    $("#major_edit").html(htmlMajor);
                    $("#user_id_edit").html(htmlUser);
                    $("#form-edit").attr('action', url);
                    $('#modal-edit').modal('show');
                }
            })
            .fail(function () {
                console.log("error");
            });
        });

        $('#data-table tbody').on('click', '.detail', function (e) {
            e.preventDefault();
            const students = $(this).attr('data-student') ? JSON.parse($(this).attr('data-student')) : [];
            const count = $(this).attr('data-count');
            const code = $(this).attr('data-code');
            const user = $(this).attr('data-user');

            $("#count-student").text(count);
            $("#code-class").text(code);
            $("#user-class").text(user);

            const formattedStudents = students.map((student, index) => {
                return {
                    no: index + 1,
                    name: student.name.toUpperCase(),
                    nis: `${student.username}`,
                    date_of_birth: student.formatted_date_of_birth,
                    phone_number: student.phone_number,
                };
            });

            // Inisialisasi DataTable
            if ($.fn.DataTable.isDataTable('#table-students')) {
                $('#table-students').DataTable().clear().destroy();
            }
            $('#table-students').DataTable({
                data: formattedStudents,
                columns: [
                    { data: 'no', title: 'No' },
                    { data: 'name', title: 'Nama' },
                    { data: 'nis', title: 'NIS' },
                    { data: 'date_of_birth', title: 'Tgl. Lahir' },
                    { data: 'phone_number', title: 'No. Handphone' }
                ]
            });
            $("#modal-show").modal('show');
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

