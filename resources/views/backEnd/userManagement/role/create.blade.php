<div class="modal fade" id="modal-create-role" aria-modal="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Data Role</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body my-2">
                            <h5 class="card-title">Role List</h5>
                            <ul class="list-group" style="font-size: 13px;">
                                @foreach ($roles as $role)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $role->name }}
                                        <div>
                                            <a href="javascript:void(0)" style="cursor: pointer; margin-right: 5px;" onclick="editRole('{{ $role->id }}', '{{ $role->name }}', '{{json_encode($role->permissions->pluck('id'))}}')" class="badge bg-primary rounded-pill">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a href="javascript:void(0)" style="cursor: pointer;" onclick="deleteRole('{{ $role->id }}', '{{route('role.destroy', $role->id)}}')" class="badge bg-danger rounded-pill">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mx-2" id="title-role">Form Role Create</h5>
                    <a href="javascript:void(0)" style="cursor: pointer;" id="clearEditRole" title="Jika Di Klik Maka Tidak akan  mengedit data" onclick="clearEditRole()" class="badge bg-info rounded-pill hidden">
                        <i class="bi bi-arrow-clockwise"></i> Clear Edit
                    </a>
                </div>
                <div class="col-lg-12">
                    <form action="{{ route('role.store') }}" id="form-role" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="id_role">
                                        <label for="name" class="form-label">Name <span class="text-red">*</span></label>
                                        <input type="text" name="name" class="form-control @error('role_name') is-invalid @enderror" id="role_name" autocomplete="off" placeholder="Enter Role Name" value="{{ old('role_name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="permission_id" class="form-label">Permission <span class="text-red">*</span></label>
                                    <select class="form-select @error('permission_id') is-invalid @enderror"  name="permission_id[]" id="permission_id_create" data-selectModalCreateMultiplejs="true" multiple data-placeholder="Pilih Permission">
                                        <option value=""></option>
                                        @foreach ($permissions as $permission)
                                            <option value="{{$permission->id}}">{{$permission->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('permission_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
