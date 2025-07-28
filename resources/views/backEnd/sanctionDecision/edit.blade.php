@extends('backEnd.layouts.main')
@section('title', 'Edit Penentuan Sanksi - '.config('app.name'))

@section('content')
<div class="pagetitle">
    <h1>Edit Penentuan Sanksi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Penentuan Sanksi</li>
            <li class="breadcrumb-item active">Edit Penentuan Sanksi</li>
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
                    <form action="{{route('penentuan-sanksi.update', $sanctionDecision->id)}}" method="POST" id="form-edit" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-2">
                                <label for="code" class="form-label">Kode Pelaporan  <span class="text-red">*</span></label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="code" disabled   autocomplete="off" value="{{ $sanctionDecision->code }}">
                            </div>
                            <div class="col-md-5">
                                <label for="user_id" class="form-label">Siswa <span class="text-red">*</span></label>
                                 <input type="text" name="user_id" class="form-control @error('user_id') is-invalid @enderror" id="user_id" disabled autocomplete="off" value="{{ $sanctionDecision->student->name }}">
                            </div>
                            <div class="col-md-5">
                                <label for="classroom" class="form-label">Kelas  <span class="text-red">*</span></label>
                                <input type="text" name="classroom" class="form-control @error('classroom') is-invalid @enderror" id="classroom" disabled autocomplete="off"  placeholder="Kelas Siswa" value="{{ $sanctionDecision->student?->classRoom?->name }}">
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-end">
                                    <div>
                                        {{-- <button type="button" class="btn btn-outline-secondary hidden" id="btn-calculate"><i class="bi bi-calculator"></i> Hitung Pelanggaran</button> --}}
                                        <button type="button" class="btn btn-outline-primary" id="btn-add" data-bs-toggle="modal" data-bs-target="#modal-add"><i class="bi bi-plus-circle"></i> Tambah Pelanggaran</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive" id="pelanggaranWrapper">
                                    <table class="table table-bordered" id="table-pelanggaran">
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
                                        @php
                                            $totalPoint = 0;
                                        @endphp
                                        <tbody id="tbody-pelanggaran">
                                            @foreach ($sanctionDecision->sanctionDecisionDetail as $key => $detail)
                                                <tr id="tr-{{ $key + 1 }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $detail->category->name }}</td>
                                                <td>{{ date('d/m/Y', strtotime($detail->incident_date)) }}</td>
                                                <td>{{ $detail->comment }}</td>
                                                <td><input type="file" class="form-control" name="file[{{ $key+1 }}]"></td>
                                                <td>{{ $detail->category->point }}</td>
                                                <td>
                                                    <input type="hidden" name="detail_id[{{ $key + 1 }}]" value="{{ $detail->id }}">
                                                    <input type="hidden" name="sanction_decision_id[{{ $key + 1 }}]" value="{{ $detail->sanction_decision_id }}">
                                                    <input type="hidden" name="category_id[{{ $key + 1 }}]" value="{{ $detail->category->id }}">
                                                    <input type="hidden" name="incident_date[{{ $key + 1 }}]" value="{{ $detail->incident_date }}">
                                                    <input type="hidden" name="comment[{{ $key + 1 }}]" value="{{ $detail->comment }}">
                                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-url="{{ route('penentuan-sanksi.deleteDetail', $detail->id) }}"><i class="bi bi-trash"></i></a>
                                                </td>
                                               </tr>
                                                @php
                                                    $totalPoint += intVal($detail->category->point);
                                                @endphp
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" style="text-align: right;">Total Point</th>
                                                <th id="total-point"><input type="hidden" name="total_point" value="{{$totalPoint}}">{{$totalPoint}}</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-outline-success" type="button"  id="btn-save"> <i class="bi bi-save"></i> Simpan Data</button>
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
        $("#tbody-pelanggaran tr").each(function() {
            let row = $(this);
            let index = row.find("td:eq(0)").text(); // Get the existing 'No'
            let valuePelanggaran = row.find("input[name^='category_id']").val();
            let sanctionDetailId = row.find("input[name^='sanction_decision_id']").val();
            let detailId = row.find("input[name^='detail_id']").val();
            let namePelanggaran = row.find("td:eq(1)").text();
            let pointPelanggaran = row.find("td:eq(5)").text();
            let valueIncidentDate = row.find("input[name^='incident_date']").val();
            let comment = row.find("input[name^='comment']").val();

            let newItem = {sanctionDetailId, detailId, valuePelanggaran,pointPelanggaran, namePelanggaran, valueIncidentDate, comment, isExisting: true, originalIndex: index};
            items.push(newItem);
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

       $('#table-pelanggaran tbody').on('click', '.delete', function () {
            const url = $(this).data('url');
            console.log(url);
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
                            <input type="hidden" name="comment[${index+1}]" value="${item.comment}">`;
                    if (!item.isExisting) {
                        html += ` <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteItem(${index})"><i class="bi bi-trash"></i></a>`;
                    } else {
                        // If it's an existing item, keep the original delete button
                        let deleteUrl = $("#tbody-pelanggaran tr").eq(index).find(".delete").data('url');
                        let detailId = deleteUrl.split('/').pop();
                        html += ` <input type="hidden" name="sanction_decision_id[${index+1}]" value="${item.sanctionDetailId}"> 
                                <input type="hidden" name="detail_id[${index+1}]" value="${item.detailId}"> 
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-url="{{ route('penentuan-sanksi.deleteDetail', '') }}/${detailId}"><i class="bi bi-trash"></i></a>`;
                    }
                html +=`</td>`;
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
                    $("#form-edit").submit();
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