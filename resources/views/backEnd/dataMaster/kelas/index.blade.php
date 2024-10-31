@extends('backEnd.layouts.main')
@section('title', 'Daftar Kelas - ' . config('app.name'))

@section('content')
<div class="pagetitle">
    <h1>Data Kelas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item">Manajemen Kelas</li>
            <li class="breadcrumb-item active">Daftar Kelas</li>
        </ol>
    </nav>
</div>

<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-md-8">
                    <h5 class="text-white">Daftar Kelas</h5>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <a href="{{ route('kelas.create') }}" class="btn btn-outline-light">
                        <i class="bi bi-plus-circle-fill"></i> Tambah Kelas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="data-table-kelas">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Kelas</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kelas as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_kelas }}</td>
                                        <td>
                                            <a href="{{ route('kelas.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada data kelas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#data-table-kelas').DataTable();
    });
</script>
@endpush
