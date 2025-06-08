@extends('layouts.app') {{-- Assuming a generic app layout; adjust if a specific coordinator layout exists, e.g., layouts.coordinator --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Program Kerja Departemen Anda</h3>
                    <div class="card-tools">
                        <a href="{{ route('coordinator.program-kerja.create') }}" class="btn btn-primary btn-sm">
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
                                <th>Waktu Pelaksanaan</th>
                                <th>PIC</th>
                                <th>Status</th>
                                <th>Progress (%)</th>
                                <th style="width: 120px">Aksi</th> {{-- Actions might be different for coordinators --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($programKerja as $key => $proker)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $proker->name }}</td>
                                <td>
                                    Mulai: {{ $proker->start_date ? $proker->start_date->format('d M Y') : 'N/A' }}<br>
                                    Selesai: {{ $proker->end_date ? $proker->end_date->format('d M Y') : 'N/A' }}
                                </td>
                                <td>{{ $proker->picUser->name ?? 'N/A' }}</td>
                                <td>{{ $proker->status ?? 'N/A' }}</td>
                                <td>{{ $proker->progress_percentage ?? 0 }}%</td>
                                <td>
                                    <a href="{{ route('coordinator.program-kerja.edit', $proker->id) }}" class="btn btn-info btn-xs" style="margin-right: 5px;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('coordinator.program-kerja.destroy', $proker->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus Program Kerja ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                    {{-- Future: View Details button --}}
                                    {{-- <a href="{{ route('coordinator.program-kerja.show', $proker->id) }}" class="btn btn-success btn-xs">Detail</a> --}}
                                    {{-- Future: Add Update button
                                    <a href="{{ route('coordinator.program-kerja.updates.create', $proker->id) }}" class="btn btn-primary btn-xs">Update Progress</a> --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada program kerja untuk departemen Anda.</td>
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
