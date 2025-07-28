<div class="modal fade" id="modal-search-siswa" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cari Data Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <select class="form-select @error('jurusan') is-invalid @enderror" id="search_jurusan" data-selectModalSiswajs="true">
                        <option value="">Pilih Jurusan</option>
                        <option value="IPA">IPA</option>
                        <option value="IPS">IPS</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select class="form-select @error('kelas') is-invalid @enderror" id="search_kelas" data-selectModalSiswajs="true">
                        <option value="">Pilih Kelas</option>
                        @foreach ($classRooms as $classRoom)
                            <option value="{{ $classRoom }}">{{ $classRoom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="name" class="form-label">Nama Siswa / Nis Siswa</label>
                    <input type="text" class="form-control" placeholder="Masukakn Nama Siswa / Nis Siswa" id="search_siswa">
                </div>
            </div>
            <div class="row my-2">
                <div class="col-lg-12">
                    <button type="button" class="btn btn-primary w-100" id="btn-search-siswa"><i class="bi bi-search"></i> Cari Siswa</button>
                    <hr>
                    <div class="table-responsive d-none" id="tableWrapper">
                        <table class="table table-striped" id="table-siswa">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-siswa-body">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div><!-- End Vertically centered Modal-->
