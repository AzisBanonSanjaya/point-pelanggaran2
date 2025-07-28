@extends('backEnd.layouts.main')
@section('title', 'Create Penentuan Sanksi - '.config('app.name'))

@section('content')
<div class="pagetitle">
    <h1>Create Penentuan Sanksi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Penentuan Sanksi</li>
            <li class="breadcrumb-item active">Create Penentuan Sanksi</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
<input type="hidden" id="interval-point" value='{{ $calculatePoint }}'>
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="card-title">Form Penentuan Sanksi</h5>
                        </div>
                        <div class="col-md-8 mt-2">
                            <div class="d-flex justify-content-end">
                                <button type="button" data-bs-target="#modal-search-siswa" data-bs-toggle="modal" class="btn btn-info me-2">
                                    <i class="bi bi-people me-2"></i> Cari Data Siswa
                                </button>
                                <a href="{{ route('penentuan-sanksi.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('penentuan-sanksi.store')}}" method="POST" id="form-create" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="report_date" class="form-control @error('report_date') is-invalid @enderror" id="report_date" readonly autocomplete="off" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="code" class="form-label">Kode Pelaporan  <span class="text-red">*</span></label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="code" readonly autocomplete="off" value="{{ 'SPL-'.Str::random(10) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="user_name" class="form-label">Siswa <span class="text-red">*</span></label>
                               <input type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror" id="user_name" placeholder="Nama Siswa" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="classroom" class="form-label">Kelas  <span class="text-red">*</span></label>
                                <input type="text" name="classroom" class="form-control @error('classroom') is-invalid @enderror" id="classroom" readonly autocomplete="off"  placeholder="Kelas Siswa">
                            </div>
                            <div class="col-md-2">
                                <label for="major" class="form-label">Jurusan  <span class="text-red">*</span></label>
                                <input type="text" name="major" class="form-control @error('major') is-invalid @enderror" id="major" readonly autocomplete="off"  placeholder="Kelas Siswa">
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-end">
                                    <div>
                                        {{-- <button type="button" class="btn btn-secondary hidden" id="btn-calculate"><i class="bi bi-calculator"></i> Hitung Pelanggaran</button> --}}
                                        <button type="button" class="btn btn-primary" id="btn-add" data-bs-toggle="modal" data-bs-target="#modal-add"><i class="bi bi-plus-circle"></i> Tambah Pelanggaran</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive hidden" id="pelanggaranWrapper">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pelanggaran</th>
                                                <th>Tanggal Kejadian</th>
                                                <th>Keterangan</th>
                                                <th>Bukti</th>
                                                <th>Point</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-pelanggaran"></tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" style="text-align: right;">Total Point</th>
                                                <th id="total-point"></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div id="file-storage" style="display: none;"></div>
                                <input type="hidden" name="total_point" id="total_point_hidden" value="0">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-success" type="button"  id="btn-save" disabled> <i class="bi bi-save"></i> Simpan Data</button>
                                </div>
                                
                            </div>
                        </div>
                    <form>
                </div>
            </div>
        </div>
    </div>
    @include('backEnd.sanctionDecision.component.modal-add')
    @include('backEnd.sanctionDecision.component.modal-search-siswa')
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        let items = [];
        let itemCounter = 0;
        $("#modal-search-siswa").modal('show');
        $('*select[data-selectModalCreatejs="true"]').select2({
            dropdownParent: $('#modal-add'),
			width: '100%',
    	});
        $('*select[data-selectModalSiswajs="true"]').select2({
            dropdownParent: $('#modal-search-siswa'),
			width: '100%',
    	});
        $("#user_id").on('change', function(e){
            e.preventDefault();
            const classRoom = $(this).find(':selected').attr('data-kelas');
            $("#classroom").val(classRoom);
        });

        $("#btn-search-siswa").on("click", function(e){
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('siswa.fetchDataTable') }}",
                data: {
                    name: $("#search_siswa").val(),
                    classRoom: $("#search_kelas").val(),
                    jurusan: $("#search_jurusan").val(),
                },
                success: function (response) {
                    $("#tableWrapper").removeClass("d-none");
                    if ($.fn.dataTable.isDataTable("#table-siswa")) {
                        $('#table-siswa').DataTable().destroy();
                    }

                    $("#tbody-siswa-body").empty();

                    let html = "";
                    response.data.forEach((item, index) => {
                        html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.name}</td>
                            <td>${item.username}</td>
                            <td>${item.class_room.major}</td>
                            <td>${item.class_room.name}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-select-siswa" data-id="${item.id}" data-name="${item.name}" data-username="${item.username}" data-kelas="${item.class_room.name}" data-jurusan="${item.class_room.major}"><i class="bi bi-check me-1"></i>Pilih</button>
                            </td>
                        </tr>
                        `;
                    });
                    $("#tbody-siswa-body").html(html);

                    $("#table-siswa").DataTable();
                },
                error: function (response) {
                    toastr.error('Data tidak ditemukan');
                }
            });
        });

         $('#table-siswa tbody').on('click', '.btn-select-siswa', function (e) {
            e.preventDefault();
            const id = $(this).attr('data-id');
            const name = $(this).attr('data-name');
            const username = $(this).attr('data-username');
            const classRoom = $(this).attr('data-kelas');
            const major = $(this).attr('data-jurusan');
            $("#user_id").val(id);
            $("#user_name").val(name+' | '+username);
            $("#classroom").val(classRoom);
            $("#major").val(major);
            $("#modal-search-siswa").modal('hide');
        })

        $("#btn-add-pelanggaran").on("click", function(e){
            e.preventDefault();
            const categorySelect = $("#category_id");
            const valuePelanggaran = categorySelect.val();
            const pointPelanggaran = categorySelect.find(':selected').attr('data-point');
            const namePelanggaran = categorySelect.find(':selected').text();
            const valueIncidentDate = $("#incident_date").val();
            const comment = $("#comment").val();
            const fileInput = $("#modal-file-input");

            if(!valuePelanggaran || !valueIncidentDate){
                 toastr.error('Pelanggaran dan Tanggal Kejadian Harus Diisi');
                 return;
            }

            const file = fileInput[0].files[0];

            // Simpan data ke array untuk ditampilkan di tabel
            let newItem = {
                id: itemCounter,
                valuePelanggaran,
                pointPelanggaran,
                namePelanggaran,
                valueIncidentDate,
                comment,
                fileName: file ? file.name : null
            };
            items.push(newItem);

            // Pindahkan input file jika ada file yang dipilih
             if (file) {
                 fileInput.attr('name', `pelanggaran[${itemCounter}][file]`);
                
           
                fileInput.removeAttr('id');
                
                $("#file-storage").append(fileInput);
                
                $("#file-input-container").append('<input type="file" class="form-control" id="modal-file-input">');
            }

            itemCounter++; // Naikkan counter untuk item berikutnya
            updateTable();

            // Reset dan tutup modal
            $("#modal-add").modal("hide");
            categorySelect.val('').trigger('change');
            $("#incident_date").val('');
            $("#comment").val('');
            $("#info-point").html('');
        });

        // ✨ DIUBAH TOTAL: Logika untuk menghapus item
         window.deleteItem = function (idToDelete) {
            $(`#file-storage input[name='pelanggaran[${idToDelete}][file]']`).remove();
            items = items.filter(item => item.id !== idToDelete);
            updateTable();
        };

        function updateTable() {
            let totalPoint = 0;
            $("#tbody-pelanggaran").empty();

            items.forEach(function (item, index) {
                const fileDisplayName = item.fileName ? item.fileName : '<em>Tidak ada bukti</em>';
                
                let rowHtml = `
                    <tr id="tr-${item.id}">
                        <td>${index + 1}</td>
                        <td>${item.namePelanggaran}</td>
                        <td>${item.valueIncidentDate}</td>
                        <td>${item.comment}</td>
                        <td>${fileDisplayName}</td>
                        <td>${item.pointPelanggaran}</td>
                        <td>
                            <input type="hidden" name="pelanggaran[${item.id}][category_id]" value="${item.valuePelanggaran}">
                            <input type="hidden" name="pelanggaran[${item.id}][incident_date]" value="${item.valueIncidentDate}">
                            <input type="hidden" name="pelanggaran[${item.id}][comment]" value="${item.comment || ''}">
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteItem(${item.id})"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                `;
                $("#tbody-pelanggaran").append(rowHtml);
                totalPoint += parseInt(item.pointPelanggaran);
            });

            $("#total-point").text(totalPoint);
            $("#total_point_hidden").val(totalPoint);

            const hasItems = items.length > 0;
            $("#pelanggaranWrapper").toggleClass("hidden", !hasItems);
            $("#btn-save").attr("disabled", !hasItems);
        }

        $("#btn-save").on("click", function(e){
            if($("#user_id").val() == ''){
                toastr.error('Siswa Wajib Dipilih');
                return false;
            }

             Swal.fire({
                title: "Apakah Data Sudah Valid?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed){
                    $("#form-create").submit();
                }
            });
        });

    });
    function changeCategory(e){
        $("#info-point").html(`<i class="bi bi-info-circle"></i> Point Pelangaran :  ${$(e).find(':selected').attr('data-point')}`)
        console.log();
    }
</script>
@endpush