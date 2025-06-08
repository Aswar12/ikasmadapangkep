@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Program Kerja</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.program-kerja.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Program Kerja
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
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama Program</th>
                                <th>Departemen</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>PIC</th>
                                <th>Status</th>
                                <th>Progress (%)</th>
                                <th style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($programKerja as $key => $proker)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $proker->name }}</td>
                                <td>{{ $proker->department->name ?? 'N/A' }}</td>
                                <td>{{ $proker->start_date ? $proker->start_date->format('d M Y') : 'N/A' }}</td>
                                <td>{{ $proker->end_date ? $proker->end_date->format('d M Y') : 'N/A' }}</td>
                                <td>{{ $proker->picUser->name ?? 'N/A' }}</td>
                                <td>{{ $proker->status ?? 'N/A' }}</td>
                                <td>{{ $proker->progress_percentage ?? 0 }}%</td>
                                <td>
                                    <a href="{{ route('admin.program-kerja.edit', $proker->id) }}" class="btn btn-info btn-xs" style="margin-right: 5px;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    {{-- <a href="{{ route('admin.program-kerja.show', $proker->id) }}" class="btn btn-success btn-xs" style="margin-right: 5px;">View</a> --}}
                                    <form action="{{ route('admin.program-kerja.destroy', $proker->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus Program Kerja ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada program kerja.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
