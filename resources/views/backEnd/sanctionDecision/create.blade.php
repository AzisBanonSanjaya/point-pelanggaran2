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
                                <a href="{{ route('penentuan-sanksi.index') }}" class="btn btn-outline-info">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('penentuan-sanksi.store')}}" method="POST" id="form-create" enctype="multipart/form-data">
                        @csrf
                         <input type="hidden" name="report_date" class="form-control @error('report_date') is-invalid @enderror" id="report_date" readonly autocomplete="off" value="{{ date('Y-m-d') }}">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="code" class="form-label">Kode Pelaporan  <span class="text-red">*</span></label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="code" readonly autocomplete="off" value="{{ 'SPL-'.Str::random(10) }}">
                            </div>
                            <div class="col-md-5">
                                <label for="user_id" class="form-label">Siswa <span class="text-red">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror"  name="user_id" id="user_id" data-selectjs="true" data-placeholder="Pilih Siswa">
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($students as $student)
                                    <option value="{{ $student->id }}" data-kelas="{{ $student->classRoom?->code }}">{{ $student->name.' |'.$student->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="classroom" class="form-label">Kelas  <span class="text-red">*</span></label>
                                <input type="text" name="classroom" class="form-control @error('classroom') is-invalid @enderror" id="classroom" readonly autocomplete="off"  placeholder="Kelas Siswa">
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-end">
                                    <div>
                                        {{-- <button type="button" class="btn btn-outline-secondary hidden" id="btn-calculate"><i class="bi bi-calculator"></i> Hitung Pelanggaran</button> --}}
                                        <button type="button" class="btn btn-outline-primary" id="btn-add" data-bs-toggle="modal" data-bs-target="#modal-add"><i class="bi bi-plus-circle"></i> Tambah Pelanggaran</button>
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
                                
                                <div id="alertWrapper">

                                </div>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-outline-success" type="button"  id="btn-save" disabled> <i class="bi bi-save"></i> Simpan Data</button>
                                </div>
                                
                            </div>
                        </div>
                    <form>
                </div>
            </div>
        </div>
    </div>
    @include('backEnd.sanctionDecision.component.modal-add')
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        let items = [];

        $('*select[data-selectModalCreatejs="true"]').select2({
            dropdownParent: $('#modal-add'),
			width: '100%',
    	});
        $("#user_id").on('change', function(e){
            e.preventDefault();
            const classRoom = $(this).find(':selected').attr('data-kelas');
            $("#classroom").val(classRoom);
        });

        $("#btn-add-pelanggaran").on("click", function(e){
            e.preventDefault();
            const valuePelanggaran = $("#category_id").val();
            const pointPelanggaran = $("#category_id").find(':selected').attr('data-point');
            const namePelanggaran = $("#category_id").find(':selected').text();
            const valueIncidentDate = $("#incident_date").val();
            const comment = $("#comment").val();

            if(valuePelanggaran == '' || valuePelanggaran == null){
                 toastr.error('Pelanggaran Harus Diisi');
                 return false;
            }

            if(valueIncidentDate == '' || valueIncidentDate == null){
                toastr.error('Tanggal Kejadian Harus Diisi');
                return false;
            }

            let newItem = {valuePelanggaran,pointPelanggaran, namePelanggaran, valueIncidentDate, comment};
            items.push(newItem);

            updateTable();
            $("#btn-save").attr('disabled', false)
            $("#modal-add").modal("hide");
            $("#pelanggaranWrapper").removeClass("hidden");
            $("#btn-calculate").removeClass("hidden");
        });

        $("#btn-calculate").on("click", function(e){
            e.preventDefault();
            const intervalPoint = $("#interval-point").val() ? JSON.parse($("#interval-point").val()) : [];
            const totalPoint = parseInt($("#total-point").text());

            let matchedInterval = intervalPoint.find(point => totalPoint >= point.from && totalPoint <= point.to);
            let html = "";
            if (!matchedInterval && intervalPoint.length > 0) {
                matchedInterval = intervalPoint[intervalPoint.length - 1];
            }

            if (matchedInterval) {
                let status = ''
                if(matchedInterval.type == 'Ringan'){
                    status = 'alert-info';
                }else if(matchedInterval.type == 'Sedang'){
                    status = 'alert-warning';
                }else if(matchedInterval.type == 'Berat'){
                    status = 'alert-danger';
                }
                html = `
                <div class="alert ${status} alert-dismissible fade show" role="alert">
                    
                    <h4 class="alert-heading"><i class="bi bi-exclamation-octagon me-1"></i> ${matchedInterval.type} (${ matchedInterval.from >= 110 ? '>= '+matchedInterval.from : matchedInterval.from} 
                        ${matchedInterval.from >= 110 ? '' : 's.d. '+ matchedInterval.to}) 
                        ${matchedInterval.name}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                `;
            }

            if(totalPoint == 0){
                html ='';
            }

            $("#alertWrapper").html(html);
        })

         window.deleteItem = function (index) {
                items.splice(index, 1);
                updateTable();
            };

        function updateTable() {
            let html = "";
            let totalPoint = 0;
            items.forEach(function (item, index) {
                html += `<tr id="tr-${index + 1}">`;
                html += `<td>${index + 1}</td>`;
                html += `<td>${item.namePelanggaran}</td>`;
                html += `<td>${item.valueIncidentDate}</td>`;
                html += `<td>${item.comment}</td>`;
                html += `<td><input type="file" class="form-control" name="file[${index}]"></td>`;
                html += `<td>${item.pointPelanggaran}</td>`;
                html += `<td>
                            <input type="hidden" name="category_id[${index+1}]" value="${item.valuePelanggaran}">
                            <input type="hidden" name="incident_date[${index+1}]" value="${item.valueIncidentDate}">
                            <input type="hidden" name="comment[${index+1}]" value="${item.comment}">
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteItem(${index})"><i class="bi bi-trash"></i></a>
                        </td>`;
                html += '</tr>';
                totalPoint += parseInt(item.pointPelanggaran);
            });
            $("#total-point").html(`<input type="hidden" name="total_point" value="${totalPoint}">${totalPoint}`);
            $("#tbody-pelanggaran").html(html);
            $("#btn-save").attr("disabled", false)
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