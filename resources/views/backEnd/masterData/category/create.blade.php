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
