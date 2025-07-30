<div class="modal fade" id="modal-edit" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Jenis Pelangaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST" id="form-edit" enctype="multipart/form-data">
        @csrf
        @method('PUT')
          	<div class="modal-body">
              	<div class="row">
                  	<div class="col-md-4">
                      <label for="name" class="form-label">Nama Pelanggaran  <span class="text-red">*</span></label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name_edit" placeholder="Nama Pelanggaran">
                    </div>
  
                    <div class="col-md-4">
                      <label for="type" class="form-label">Urgensi Pelanggaran <span class="text-red">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror"  name="type" id="type_edit" data-selectModalEditjs="true" data-placeholder="Pilih Urgensi Pelanggaran">
                            <option value="">-- Pilih Pelanggaran --</option>
                            
                        </select>
                    </div>

                    <div class="col-md-4">
                      <label for="point" class="form-label">Point Pelanggaran <span class="text-red">*</span></label>
                      <input type="text" name="point" class="form-control @error('point') is-invalid @enderror number-only" id="point_edit" placeholder="Point Pelanggaran">
                    </div>
					<div class="col-md-12 my-2">
						<hr>
						<h5>Rekomendasi Sanksi</h5>
						<div class="d-flex justify-content-end mb-2">
							<button type="button" class="btn btn-info mx-2 btn-add-rekomendasi-edit">
								<i class="bi bi-plus"></i> Tambah Rekomendasi
							</button>
							<button type="button" class="btn btn-danger btn-remove-rekomendasi-edit">
								<i class="bi bi-trash"></i> Hapus Rekomendasi
							</button>
						</div>

						<div id="rekomendasi-container-edit">
						</div>
						<input type="hidden" id="rekomendasi-count-edit" value="0">
					</div>
              	</div>
			</div>
          	<div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
          	</div>
      </form>

    </div>
  </div>
</div><!-- End Vertically centered Modal-->
