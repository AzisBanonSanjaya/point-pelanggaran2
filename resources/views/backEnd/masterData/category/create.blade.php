<div class="modal fade" id="modal-create" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Jenis Pelangaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('category.store')}}" method="POST" id="form-create" enctype="multipart/form-data">
          	<div class="modal-body">
              	@csrf
              	<div class="row">
					<div class="col-md-4">
						<label for="name" class="form-label">Nama Pelanggaran  <span class="text-red">*</span></label>
						<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama Pelanggaran">
					</div>

					<div class="col-md-4">
						<label for="type" class="form-label">Urgensi Pelanggaran <span class="text-red">*</span></label>
						<select class="form-select @error('type') is-invalid @enderror"  name="type" id="type" data-selectModalCreatejs="true" data-placeholder="Pilih Urgensi Pelanggaran">
							<option value="">-- Pilih Pelanggaran --</option>
							<option value="Ringan">Ringan</option>
							<option value="Sedang">Sedang</option>
							<option value="Berat">Berat</option>
						</select>
					</div>
					<div class="col-md-4">
						<label for="point" class="form-label">Point Pelanggaran <span class="text-red">*</span></label>
						<input type="text" name="point" class="form-control @error('point') is-invalid @enderror number-only" id="point" placeholder="Point Pelanggaran">
					</div>
					 <div class="col-md-12 my-2">
						<hr>
                        <h5>Rekomendasi Sanksi</h5>
                        <div class="d-flex justify-content-end mb-2">
                            <button type="button" class="btn btn-info mx-2 btn-add-rekomendasi-create">
                                <i class="bi bi-plus"></i> Tambah Rekomendasi
                            </button>
                             <button type="button" class="btn btn-danger btn-remove-rekomendasi-create" disabled>
                                <i class="bi bi-trash"></i> Hapus Rekomendasi
                            </button>
                        </div>
                        <div id="rekomendasi-container-create">
                            <div class="rekomendasi-item-create mb-2">
                                <label for="rekomendasi1" class="form-label">Rekomendasi Sanksi 1 <span class="text-danger">*</span></label>
                                <input type="text" name="rekomendasi[]" class="form-control" id="rekomendasi1" placeholder="Rekomendasi Sanksi" required>
                            </div>
                        </div>
                        <input type="hidden" id="rekomendasi-count-create" value="1">
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
