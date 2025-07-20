<div class="modal fade" id="modal-edit" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Interval Point</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST" id="form-edit" enctype="multipart/form-data">
            @csrf
            @method('PUT')
          	<div class="modal-body">
              	<div class="row">
                  	<div class="col-md-6">
                      <label for="name" class="form-label">Nama Sanksi  <span class="text-red">*</span></label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name_edit" autocomplete="off" placeholder="Nama Sanksi">
                    </div>
                    <div class="col-md-6">
                      <label for="type" class="form-label">Urgensi Pelanggaran <span class="text-red">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror"  name="type" id="type_edit" data-selectModalEditjs="true" data-placeholder="Pilih Urgensi Pelanggaran">
                            <option value="">-- Pilih Pelanggaran --</option>
                            <option value="Ringan">Ringan</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Berat">Berat</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-3">
                      <label for="from" class="form-label">Point Awal<span class="text-red">*</span></label>
                      <input type="text" name="from" class="form-control @error('from') is-invalid @enderror number-only" id="from_edit" placeholder="Point Awal">
                    </div>
                    <div class="col-md-6 mt-3">
                      <label for="to" class="form-label">Point Akhir<span class="text-red">*</span></label>
                      <input type="text" name="to" class="form-control @error('to') is-invalid @enderror number-only" id="to_edit" placeholder="Point Akhir">
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
