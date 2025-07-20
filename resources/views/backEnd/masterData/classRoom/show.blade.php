<div class="modal fade" id="modal-show" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card info-card customers-card" style="background: #bbd3ff">
                        <div class="card-body">
                            <h5 class="card-title">Total Siswa</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="count-student">0</h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                 <div class="col-lg-4">
                    <div class="card info-card customers-card" style="background: #bbd3ff">
                        <div class="card-body">
                            <h5 class="card-title">Kelas</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-book-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="code-class">-</h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                 <div class="col-lg-4">
                    <div class="card info-card customers-card" style="background: #bbd3ff">
                        <div class="card-body">
                            <h5 class="card-title">Wali Kelas</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="user-class">-</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                         <div class="card-body">
                            <h5 class="card-title">Data Detail Siswa</h5>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped text-center" id="table-students">
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div><!-- End Vertically centered Modal-->
