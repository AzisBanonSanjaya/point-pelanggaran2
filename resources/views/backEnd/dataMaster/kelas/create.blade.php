<div class="modal fade" id="modal-create" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('kelas.store')}}" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
              @csrf
              <div class="row">
                  <div class="col-md-12">
                      <label for="name" class="form-label">Name <span class="text-red">*</span></label>
                      <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" autocomplete="off" placeholder="Enter Your Name">
                      @error('name')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
                  {{-- <div class="col-md-4">
                      <label for="email" class="form-label">Email <span class="text-red">*</span></label>
                      <input type="email" class="form-control  @error('email') is-invalid @enderror"  name="email" id="email" autocomplete="off" placeholder="Enter Your Email">
                      @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-md-4">
                      <label for="password" class="form-label">Password <span class="text-red">*</span></label>
                      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" autocomplete="off" placeholder="Enter Your Password">
                      @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div> --}}
              {{-- </div>
              <div class="row mt-3">
                  <div class="col-md-6">
                      <label for="image" class="form-label">Photo Profile</label>
                      <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" accept="image/*">
                      @error('image')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-md-6">
                      <label for="role_id" class="form-label">Role <span class="text-red">*</span></label>
                      <select class="form-select @error('role_id') is-invalid @enderror"  name="role_id[]" id="role_id" data-selectModalCreatejs="true" data-placeholder="Pilih Role">
                          <option value="" selected disabled>Pilih Role</option>
                          @foreach ($roles as $role)
                              <option value="{{$role->id}}">{{$role->name}}</option>
                          @endforeach
                      </select>
                      @error('role_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
              </div> --}}
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
      </form>

    </div>
  </div>
</div><!-- End Vertically centered Modal-->
