@extends('layouts.alumni')

@section('page-title', $title ?? 'Halaman Sementara')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-tools fa-4x text-primary mb-4"></i>
                    <h2 class="mb-3">Halaman Sedang Dikembangkan</h2>
                    <p class="text-muted">Halaman {{ $title ?? '' }} sedang dalam pengembangan dan akan segera tersedia.</p>
                    <a href="{{ route('alumni.dashboard') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-home me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection