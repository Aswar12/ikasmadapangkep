@extends('layouts.alumni')

@section('page-title', 'Edit Profil')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('alumni.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <div class="mb-3">
                                    <div class="position-relative mx-auto" style="width: 150px; height: 150px;">
                                        @if(isset($profile) && $profile->profile_photo)
                                            <img id="preview-photo" src="{{ asset('storage/' . $profile->profile_photo) }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="img-fluid rounded-circle" 
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        @else
                                            <div id="photo-placeholder" class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                                                <i class="fas fa-user fa-4x text-primary"></i>
                                            </div>
                                            <img id="preview-photo" src="" alt="" class="img-fluid rounded-circle d-none" style="width: 150px; height: 150px; object-fit: cover;">
                                        @endif
                                        
                                        <div class="position-absolute bottom-0 end-0">
                                            <label for="profile_photo" class="btn btn-sm btn-primary rounded-circle">
                                                <i class="fas fa-camera"></i>
                                            </label>
                                            <input type="file" id="profile_photo" name="profile_photo" class="d-none" accept="image/*">
                                        </div>
                                    </div>
                                    
                                    <div class="small text-muted mt-2">Klik ikon kamera untuk mengubah foto</div>
                                </div>
                            </div>
                            
                            <div class="col-md-9">
                                <h6 class="text-primary mb-3">Informasi Dasar</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">WhatsApp</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->whatsapp) }}" placeholder="08xxxxxxxxxx">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('gender', $profile->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('gender', $profile->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h6 class="text-primary mb-3">Informasi Pribadi</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="birth_place" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" name="birth_place" value="{{ old('birth_place', $profile->birth_place ?? '') }}">
                                @error('birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date', $profile->birth_date ?? '') }}">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-12">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $profile->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <h6 class="text-primary mb-3">Informasi Akademik</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="national_student_number" class="form-label">NISN</label>
                                <input type="text" class="form-control @error('national_student_number') is-invalid @enderror" id="national_student_number" name="national_student_number" value="{{ old('national_student_number', $profile->national_student_number ?? '') }}">
                                @error('national_student_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label for="entry_year" class="form-label">Tahun Masuk</label>
                                <input type="text" class="form-control @error('entry_year') is-invalid @enderror" id="entry_year" name="entry_year" value="{{ old('entry_year', $profile->entry_year ?? '') }}" placeholder="2018">
                                @error('entry_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label for="graduation_year" class="form-label">Tahun Lulus</label>
                                <input type="text" class="form-control @error('graduation_year') is-invalid @enderror" id="graduation_year" name="graduation_year" value="{{ old('graduation_year', $profile->graduation_year ?? '') }}" placeholder="2021">
                                @error('graduation_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="diploma_number" class="form-label">Nomor Ijazah</label>
                                <input type="text" class="form-control @error('diploma_number') is-invalid @enderror" id="diploma_number" name="diploma_number" value="{{ old('diploma_number', $profile->diploma_number ?? '') }}">
                                @error('diploma_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="certificate_number" class="form-label">Nomor SKHUN</label>
                                <input type="text" class="form-control @error('certificate_number') is-invalid @enderror" id="certificate_number" name="certificate_number" value="{{ old('certificate_number', $profile->certificate_number ?? '') }}">
                                @error('certificate_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <h6 class="text-primary mb-3">Informasi Keluarga</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="father_name" class="form-label">Nama Ayah</label>
                                <input type="text" class="form-control @error('father_name') is-invalid @enderror" id="father_name" name="father_name" value="{{ old('father_name', $profile->father_name ?? '') }}">
                                @error('father_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="father_occupation" class="form-label">Pekerjaan Ayah</label>
                                <input type="text" class="form-control @error('father_occupation') is-invalid @enderror" id="father_occupation" name="father_occupation" value="{{ old('father_occupation', $profile->father_occupation ?? '') }}">
                                @error('father_occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="mother_name" class="form-label">Nama Ibu</label>
                                <input type="text" class="form-control @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" value="{{ old('mother_name', $profile->mother_name ?? '') }}">
                                @error('mother_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="mother_occupation" class="form-label">Pekerjaan Ibu</label>
                                <input type="text" class="form-control @error('mother_occupation') is-invalid @enderror" id="mother_occupation" name="mother_occupation" value="{{ old('mother_occupation', $profile->mother_occupation ?? '') }}">
                                @error('mother_occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('alumni.profile') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-photo').src = e.target.result;
                document.getElementById('preview-photo').classList.remove('d-none');
                
                if (document.getElementById('photo-placeholder')) {
                    document.getElementById('photo-placeholder').classList.add('d-none');
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush