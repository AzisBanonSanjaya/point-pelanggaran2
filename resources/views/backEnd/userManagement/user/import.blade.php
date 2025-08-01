<div class="modal fade" id="modal-import" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Import User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('user.import')}}" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <label for="file" class="form-label">File <span class="text-red">*</span></label>
                        <input type="file" class="form-control  @error('file') is-invalid @enderror" name="file" id="file" autocomplete="off" accept=".xlsx,.xls">
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <a href="{{route('user.export')}}"><i class="bi bi-download me-2"></i>Download Template Import</a>
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
