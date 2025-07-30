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
                                <a href="{{ route('penentuan-sanksi.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{route('penentuan-sanksi.update', $sanctionDecision->id)}}" method="POST" id="form-edit" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" id="user_id" value="{{ $sanctionDecision->user_id }}">
                        
                        <div class="row">
                            <div class="col-md-2">
                                <label for="code" class="form-label">Kode Pelaporan</label>
                                <input type="text" class="form-control" id="code" disabled value="{{ $sanctionDecision->code }}">
                            </div>
                            <div class="col-md-6">
                                <label for="user_name" class="form-label">Siswa</label>
                               <input type="text" class="form-control" id="user_name" value="{{ $sanctionDecision->student->name }} | {{ $sanctionDecision->student->username }}" disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="classroom" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="classroom" disabled value="{{ $sanctionDecision->student?->classRoom?->name }}">
                            </div>
                             <div class="col-md-2">
                                <label for="major" class="form-label">Jurusan</label>
                                <input type="text" class="form-control" id="major" disabled value="{{ $sanctionDecision->student?->classRoom?->major }}">
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" id="btn-add" data-bs-toggle="modal" data-bs-target="#modal-add"><i class="bi bi-plus-circle"></i> Tambah Pelanggaran</button>
                                </div>
                                <hr>
                                <div class="table-responsive" id="pelanggaranWrapper">
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
                                        <tbody id="tbody-pelanggaran">
                                            {{-- Data akan dirender oleh JavaScript --}}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" style="text-align: right;">Total Point</th>
                                                <th id="total-point">0</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                
                                <div id="file-storage" style="display: none;"></div>
                                <input type="hidden" name="total_point" id="total_point_hidden" value="0">

                                <div class="d-flex justify-content-end mt-3">
                                    <button class="btn btn-success" type="button" id="btn-save"> <i class="bi bi-save"></i> Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal Tambah Pelanggaran (Sama seperti di halaman create) --}}
    <div class="modal fade" id="modal-add" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="category_id" class="form-label">Pelanggaran <span class="text-red">*</span></label>
                            <select class="form-select" id="category_id" data-selectModalCreatejs="true" data-placeholder="Pilih Pelanggaran" onchange="changeCategory(this)">
                                <option value="">-- Pilih Pelanggaran --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" data-point="{{ $category->point }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <span class="fw-bold" id="info-point" style="font-size: 13px;"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="incident_date" class="form-label">Tanggal Kejadian <span class="text-red">*</span></label>
                            <input type="date" class="form-control" id="incident_date">
                        </div>
                        <div class="col-md-4" id="file-input-container">
                            <label for="modal-file-input" class="form-label">Bukti Kejadian</label>
                            <input type="file" class="form-control" id="modal-file-input">
                        </div>
                        <div class="col-lg-12 my-3">
                            <label for="comment" class="form-label">Keterangan Lainnya</label>
                            <textarea placeholder="Keterangan Lainnya" id="comment" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-add-pelanggaran">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        let items = [];
        let itemCounter = {{ $sanctionDecision->sanctionDecisionDetail->count() }};

        // Inisialisasi Select2
        $('*select[data-selectModalCreatejs="true"]').select2({
            dropdownParent: $('#modal-add'),
            width: '100%',
        });

        // Fungsi untuk memuat data awal dari server ke array JavaScript
        function loadInitialData() {
            let initialData = @json($sanctionDecision->sanctionDecisionDetail);
            initialData.forEach((detail, index) => {
                items.push({
                    id: detail.id, // Gunakan ID detail sebagai ID unik
                    isExisting: true, // Tandai sebagai data lama
                    valuePelanggaran: detail.category_id,
                    namePelanggaran: detail.category.name,
                    pointPelanggaran: detail.category.point,
                    valueIncidentDate: detail.incident_date,
                    comment: detail.comment,
                    fileName: detail.file, // Nama file yang sudah ada
                    fileUrl: detail.file_url // URL untuk melihat file
                });
            });
            updateTable(); // Render tabel dengan data awal
        }

        // Tambah item baru dari modal
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
            itemCounter++; // Gunakan counter untuk ID item baru

            items.push({
                id: `new-${itemCounter}`, // ID unik untuk item baru
                isExisting: false,
                valuePelanggaran,
                pointPelanggaran,
                namePelanggaran,
                valueIncidentDate,
                comment,
                fileName: file ? file.name : null
            });

            if (file) {
                fileInput.attr('name', `pelanggaran[new-${itemCounter}][file]`);
                fileInput.removeAttr('id');
                $("#file-storage").append(fileInput);
                $("#file-input-container").append('<input type="file" class="form-control" id="modal-file-input">');
            }

            updateTable();
            $("#modal-add").modal("hide");
            categorySelect.val('').trigger('change');
            $("#incident_date").val('');
            $("#comment").val('');
            $("#info-point").html('');
        });

        // Hapus item dari tabel (baik data lama maupun baru)
        window.deleteItem = function (idToDelete) {
            // Hapus juga file yang mungkin sudah dipindahkan ke storage
            $(`#file-storage input[name='pelanggaran[${idToDelete}][file]']`).remove();
            
            // Hapus item dari array
            items = items.filter(item => item.id != idToDelete);
            
            toastr.warning('Item dihapus dari daftar. Perubahan akan disimpan saat menekan tombol Simpan.');
            updateTable();
        };

        // Render ulang seluruh tabel berdasarkan array 'items'
        function updateTable() {
            let totalPoint = 0;
            $("#tbody-pelanggaran").empty();

            if (items.length === 0) {
                let emptyRow = `<tr><td colspan="7" class="text-center">Belum ada data pelanggaran</td></tr>`;
                $("#tbody-pelanggaran").html(emptyRow);
            }

            items.forEach(function (item, index) {
                let fileDisplay = '<em>Tidak ada bukti</em>';
                if (item.isExisting && item.fileName) {
                    fileDisplay = `<a href="${item.fileUrl}" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i> Lihat Bukti</a>`;
                } else if (item.fileName) {
                     fileDisplay = item.fileName;
                }

                let rowHtml = `
                    <tr id="tr-${item.id}">
                        <td>${index + 1}</td>
                        <td>${item.namePelanggaran}</td>
                        <td>${item.valueIncidentDate}</td>
                        <td>${item.comment || ''}</td>
                        <td>${fileDisplay}</td>
                        <td>${item.pointPelanggaran}</td>
                        <td>
                            <input type="hidden" name="pelanggaran[${item.id}][category_id]" value="${item.valuePelanggaran}">
                            <input type="hidden" name="pelanggaran[${item.id}][incident_date]" value="${item.valueIncidentDate}">
                            <input type="hidden" name="pelanggaran[${item.id}][comment]" value="${item.comment || ''}">
                            ${item.isExisting ? `<input type="hidden" name="pelanggaran[${item.id}][detail_id]" value="${item.id}">` : ''}
                            
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteItem('${item.id}')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                `;
                $("#tbody-pelanggaran").append(rowHtml);
                totalPoint += parseInt(item.pointPelanggaran);
            });

            $("#total-point").text(totalPoint);
            $("#total_point_hidden").val(totalPoint);
            $("#btn-save").attr("disabled", items.length === 0);
        }

        // Simpan perubahan
        $("#btn-save").on("click", function(e){
            e.preventDefault();
             Swal.fire({
                title: "Simpan Perubahan?",
                text: "Pastikan semua data sudah benar.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Simpan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed){
                    $("#form-edit").submit();
                }
            });
        });

        // Panggil fungsi untuk memuat data awal
        loadInitialData();
    });

    function changeCategory(e){
        const point = $(e).find(':selected').attr('data-point');
        if (point) {
            $("#info-point").html(`<i class="bi bi-info-circle"></i> Point Pelanggaran: ${point}`);
        } else {
            $("#info-point").html('');
        }
    }
</script>
@endpush
