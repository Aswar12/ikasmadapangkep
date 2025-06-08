@extends('layouts.app') {{-- Or layouts.coordinator if it exists --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Program Kerja Baru (Departemen Anda)</h3>
                </div>
                <form action="{{ route('coordinator.program-kerja.store') }}" method="POST">
                    @csrf
                    {{-- Department ID is handled by the controller, no input field needed here for it --}}
                    {{-- Hidden input could be used if preferred, but controller logic is cleaner:
                         <input type="hidden" name="department_id" value="{{ $departmentId }}"> --}}

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Program Kerja</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="pic_user_id">Penanggung Jawab (PIC)</label>
                            <select name="pic_user_id" id="pic_user_id" class="form-control @error('pic_user_id') is-invalid @enderror">
                                <option value="">-- Pilih PIC --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('pic_user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            @error('pic_user_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                                    @error('start_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Tanggal Selesai</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                                    @error('end_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi Program Kerja</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="budget">Anggaran (Rp)</label>
                                    <input type="number" name="budget" id="budget" class="form-control @error('budget') is-invalid @enderror" value="{{ old('budget') }}" step="0.01" min="0">
                                    @error('budget')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="progress_percentage">Persentase Progress (%)</label>
                                    <input type="number" name="progress_percentage" id="progress_percentage" class="form-control @error('progress_percentage') is-invalid @enderror" value="{{ old('progress_percentage', 0) }}" min="0" max="100">
                                    @error('progress_percentage')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="current_progress">Detail Progress Saat Ini</label>
                            <textarea name="current_progress" id="current_progress" class="form-control @error('current_progress') is-invalid @enderror" rows="3">{{ old('current_progress') }}</textarea>
                            @error('current_progress')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Program Kerja</button>
                        <a href="{{ route('coordinator.program-kerja.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
