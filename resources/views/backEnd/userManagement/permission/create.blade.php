<div class="modal fade" id="modal-create-permission" aria-modal="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create Permission</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body my-2">
                            <h5 class="card-title">Permission List</h5>
                            <ul class="list-group" style="font-size: 13px;">
                                @foreach ($permissions as $permission)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $permission->name }}
                                        <div>
                                            <a href="javascript:void(0)" style="cursor: pointer; margin-right: 5px;" onclick="editPermission('{{ $permission->id }}', '{{ $permission->name }}')" class="badge bg-primary rounded-pill">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a href="javascript:void(0)" style="cursor: pointer;" onclick="deletePermission('{{ $permission->id }}', '{{route('permission.destroy', $permission->id)}}')" class="badge bg-danger rounded-pill">
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
                    <h5 class="card-title mx-2" id="title-permission">Form Permission Create</h5>
                    <a href="javascript:void(0)" style="cursor: pointer;" id="clearEditPermission" title="Jika Di Klik Maka Tidak akan  mengedit data" onclick="clearEditPermission()" class="badge bg-info rounded-pill hidden">
                        <i class="bi bi-arrow-clockwise"></i> Clear Edit
                    </a>
                </div>
                <form action="{{ route('permission.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="permissionId">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name <span class="text-red">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="permission_name" autocomplate="off" placeholder="Enter Permission Name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
