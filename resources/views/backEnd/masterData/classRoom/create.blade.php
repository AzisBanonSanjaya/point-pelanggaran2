<div class="modal fade" id="modal-create" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('class-room.store')}}" method="POST" id="form-create" enctype="multipart/form-data">
          	<div class="modal-body">
              	@csrf
              	<div class="row">
                  	<div class="col-md-3">
                      	<label for="name" class="form-label">Nama Kelas <span class="text-red">*</span></label>
                     	<select class="form-select @error('name') is-invalid @enderror"  name="name" id="name" data-selectModalCreatejs="true" data-placeholder="Pilih Kelas">
                            <option value="" selected disabled>Pilih Wali Kelas</option>
                            <option value="Kelas X (10)">Kelas X (10)</option>
                            <option value="Kelas XI (11)">	Kelas XI (11)</option>
                            <option value="Kelas XII (12)">Kelas XII (12)</option>
                        </select>
						@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
                  	</div>
					<div class="col-md-3">
                      	<label for="code" class="form-label">Kode <span class="text-red">*</span></label>
                     	<select class="form-select @error('code') is-invalid @enderror"  name="code" id="code" data-selectModalCreatejs="true" data-placeholder="Pilih Kode">
                            <option value="" selected disabled>Pilih Kode</option>
							@foreach (range('A', 'Z') as $value)
                                <option value="{{$value}}">{{$value}}</option>
                            @endforeach
                        </select>
						@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
                  	</div>
					<div class="col-md-3">
                      	<label for="major" class="form-label">Jurusan <span class="text-red">*</span></label>
                     	<select class="form-select @error('major') is-invalid @enderror"  name="major" id="major" data-selectModalCreatejs="true" data-placeholder="Pilih Jurusan">
                            <option value="" selected disabled>Pilih Jurusan</option>
                            <option value="IPA">IPA</option>
                            <option value="IPS">IPS</option>
                        </select>
						@error('major')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
                  	</div>
					<div class="col-md-3">
						<label for="user_id" class="form-label">Wali Kelas <span class="text-red">*</span></label>
						<select class="form-select @error('user_id') is-invalid @enderror"  name="user_id" id="user_id" data-selectModalCreatejs="true" data-placeholder="Pilih Wali Kelas">
                            <option value="" selected disabled>Pilih Wali Kelas</option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
						@error('user_id')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
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
