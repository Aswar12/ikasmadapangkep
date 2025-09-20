@extends('layouts.dashboard')

@section('page-title', 'Daftar Departemen')

@section('navigation')
    @include('admin.menu')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Departemen</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.departments.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Departemen
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama Departemen</th>
                                <th>Deskripsi</th>
                                <th>Koordinator</th>
                                <th style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $key => $department)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->description }}</td>
                                <td>{{ $department->coordinator->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.departments.edit', $department->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus departemen ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
