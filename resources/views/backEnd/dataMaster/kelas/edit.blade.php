@extends('admin._include.master')

@section('content')
  <div class="header bg-primary pb-6">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
            <h6 class="h2 text-white d-inline-block mb-0">Edit Kelas</h6>
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="#"><i class="ni ni-books"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Kelas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Kelas</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Edit Kelas</h3>
            </div>
            <div class="col-4 text-right">
              <a href="/admin/kelas" class="btn btn-sm btn-primary">Kembali</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body"> 
            <div class="pl-lg-4">
              <form action="{{ route('updateKelas', $kelas->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">                
                  <div class="col-lg-12">
                    <div class="form-group">
                        <label class="form-control-label" for="input-username">Kelas</label>
                        <select name="nama_kelas" class="form-control">
                          <option value="">Pilih Kelas</option>
                          <option value="10" {{ $kelas->nama_kelas == '10' ? 'selected' : '' }}>10</option>
                          <option value="11" {{ $kelas->nama_kelas == '11' ? 'selected' : '' }}>11</option>
                          <option value="12" {{ $kelas->nama_kelas == '12' ? 'selected' : '' }}>12</option>
                        </select>              
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary float-right">Simpan Perubahan</button>
              </form>    
            </div>
        </div>
      </div>
    </div>
  </div>

@endsection
