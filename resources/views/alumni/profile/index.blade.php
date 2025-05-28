@extends('layouts.alumni')

@section('page-title', 'Profil Saya')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Profil Saya</h5>
                    <a href="{{ route('alumni.profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Profil
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="text-center">
                                @if(isset($profile) && $profile->profile_photo)
                                    <img src="{{ asset('storage/' . $profile->profile_photo) }}" alt="{{ $user->name }}" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px;">
                                        <i class="fas fa-user fa-4x text-primary"></i>
                                    </div>
                                @endif
                                <h5 class="mb-1">{{ $user->name }}</h5>
                                <p class="text-muted">Alumni Angkatan {{ $profile->graduation_year ?? '-' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <h6 class="text-primary mb-3">Informasi Pribadi</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="small text-muted">Nama Lengkap</div>
                                    <div>{{ $user->name }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Email</div>
                                    <div>{{ $user->email }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Nomor WhatsApp</div>
                                    <div>{{ $user->whatsapp_formatted ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Jenis Kelamin</div>
                                    <div>{{ $profile->gender ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Tempat Lahir</div>
                                    <div>{{ $profile->birth_place ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Tanggal Lahir</div>
                                    <div>{{ $profile->birth_date ? date('d M Y', strtotime($profile->birth_date)) : '-' }}</div>
                                </div>
                                <div class="col-md-12">
                                    <div class="small text-muted">Alamat</div>
                                    <div>{{ $profile->address ?? '-' }}</div>
                                </div>
                            </div>
                            
                            <h6 class="text-primary mb-3">Informasi Akademik</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="small text-muted">NISN</div>
                                    <div>{{ $profile->national_student_number ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Tahun Masuk</div>
                                    <div>{{ $profile->entry_year ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Tahun Lulus</div>
                                    <div>{{ $profile->graduation_year ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Nomor Ijazah</div>
                                    <div>{{ $profile->diploma_number ?? '-' }}</div>
                                </div>
                            </div>
                            
                            <h6 class="text-primary mb-3">Informasi Keluarga</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="small text-muted">Nama Ayah</div>
                                    <div>{{ $profile->father_name ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Pekerjaan Ayah</div>
                                    <div>{{ $profile->father_occupation ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Nama Ibu</div>
                                    <div>{{ $profile->mother_name ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Pekerjaan Ibu</div>
                                    <div>{{ $profile->mother_occupation ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection