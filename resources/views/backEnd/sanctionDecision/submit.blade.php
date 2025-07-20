<div class="modal fade" id="modal-submit" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Ajukan Sanksi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data" id="form-submit">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 d-flex flex-column align-items-center">
                        <!-- Judul di atas -->
                        <h5 class="mb-1">Total Point</h5> <!-- mb-1 biar jaraknya lebih dekat -->
                        <h1 id="txt-total-point" class="mb-0 txt-total-point" style="font-size: 120px; line-height: 1;">0</h1>
                        <div id="statusWrapper" class="statusWrapper">

                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>Kode Pelaporan</th>
                                    <td class="txt-pelaporan"></td>
                                    
                                </tr>
                                <tr>
                                    <th>Siswa</th>
                                    <td class="txt-siswa"></td>
                                </tr>
                                <tr>
                                    <th>Nis</th>
                                    <td class="txt-nis"></td>
                                </tr>
                                <tr>
                                <th>Kelas</th>
                                    <td class="txt-kelas"></td>
                                </tr>
                                <tr>
                                <th>Wali Kelas</th>
                                    <td class="txt-wali-kelas"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <hr>
                        <div class="form-group">
                            <label class="form-label">Bukti Pelanggaran</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Keterangan Lainnya</label>
                            <textarea name="description" id="description" class="form-control" rows="7" placeholder="Masukan Keterangan Lainnya"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Kirim</button>
            </div>
        </form>
        
    </div>
  </div>
</div><!-- End Vertically centered Modal-->
