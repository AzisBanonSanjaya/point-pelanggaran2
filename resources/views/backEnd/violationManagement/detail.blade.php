<div class="modal fade" id="modal-detail" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Pelaporan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-4 d-flex flex-column align-items-center">
                    <!-- Judul di atas -->
                    <h5 class="mb-1">Total Point</h5> <!-- mb-1 biar jaraknya lebih dekat -->
                    <h1 id="txt-total-point" class="mb-0" style="font-size: 120px; line-height: 1;">0</h1>
                    <div id="statusWrapper">

                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Kode Pelaporan</th>
                                <td id="txt-pelaporan"></td>
                                
                            </tr>
                            <tr>
                                <th>Siswa</th>
                                <td id="txt-siswa"></td>
                            </tr>
                             <tr>
                                <th>Nis</th>
                                <td id="txt-nis"></td>
                            </tr>
                            <tr>
                               <th>Kelas</th>
                                <td id="txt-kelas"></td>
                            </tr>
                            <tr>
                               <th>Wali Kelas</th>
                                <td id="txt-wali-kelas"></td>
                            </tr>
                            <tr>
                               <th>Bukti Tindakan</th>
                                <td id="txt-file"></td>
                            </tr>
                            <tr>
                                <th>Deskripsi Tindakan</th>
                                <td id="txt-description"></td>
                            </tr>
                             <tr id="wrapper-reject">
                                <th>Alasan Ditolak</th>
                                <td id="txt-reject-reason"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                    <div class="table-responsive" id="pelanggaranWrapper">
                        <table class="table table-bordered" id="table-pelanggaran">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggaran</th>
                                    <th>Tanggal Kejadian</th>
                                    <th>Point</th>
                                    <th>Bukti</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-pelanggaran">
                               

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn-approve">Setujui Pelanggaran</button>
        </div>
    </div>
  </div>
</div><!-- End Vertically centered Modal-->
