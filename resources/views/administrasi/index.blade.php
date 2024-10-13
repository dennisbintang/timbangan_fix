@extends('layouts.app')

@section('title', 'Daftar Administrasi')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Administrasi</h1>
    
    <!-- Form Pencarian -->
    <form action="{{ route('administrasi.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan No Order atau Nama Instansi" value="{{ request('search') }}" style="border-radius: 0.25rem;">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" style="border-radius: 0.25rem 0 0 0.25rem;">Cari</button>
                <a href="{{ route('administrasi.index') }}" class="btn btn-secondary" style="border-radius: 0 0.25rem 0.25rem 0;">Reset</a>
            </div>
        </div>
    </form>

    <a href="{{ route('administrasi.create') }}" class="btn btn-success mb-3">Tambah Data</a>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>No Order</th>
                <th>Nama Instansi</th>
                <th>Tanggal Kalibrasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($administrasis as $administrasi)
            <tr>
                <td>{{ $administrasi->id }}</td>
                <td>{{ $administrasi->no_order }}</td>
                <td>{{ $administrasi->nama_instansi }}</td>
                <td>{{ $administrasi->tanggal_kalibrasi }}</td>
                <td>
                    <a href="{{ route('administrasi.edit', $administrasi) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('administrasi.destroy', $administrasi) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $administrasis->links('vendor.pagination.bootstrap-4') }} <!-- Menggunakan Bootstrap 4 -->
    </div>
</div>

<style>
    .table {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .table thead th {
        background-color: #343a40;
        color: white;
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
</style>

<script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin menghapus data ini?');
    }
</script>
@endsection
