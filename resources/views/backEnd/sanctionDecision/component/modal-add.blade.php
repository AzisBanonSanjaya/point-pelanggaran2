<div class="modal fade" id="modal-add" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Jenis Pelangaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     
        <div class="modal-body">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="category_id" class="form-label">Pelanggaran <span class="text-red">*</span></label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" data-selectModalCreatejs="true" data-placeholder="Pilih Pelanggaran" onchange="changeCategory(this)">
                        <option value="">-- Pilih Pelanggaran --</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" data-point="{{ $category->point }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <span class="fw-bold" id="info-point" style="font-size: 13px;"></span>
                </div>
                <div class="col-md-6">
                    <label for="incident_date" class="form-label">Tanggal Kejadian Pelanggaran <span class="text-red">*</span></label>
                    <input type="date" class="form-control @error('incident_date') is-invalid @enderror number-only" id="incident_date">
                </div>
                <div class="col-lg-12 my-3">
                    <label for="incident_date" class="form-label">Keterangan Lainnya</label>
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
</div><!-- End Vertically centered Modal-->
