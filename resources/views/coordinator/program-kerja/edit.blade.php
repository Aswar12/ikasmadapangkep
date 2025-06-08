@extends('layouts.app') {{-- Or layouts.coordinator if it exists --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning"> {{-- Card color for edit --}}
                <div class="card-header">
                    <h3 class="card-title">Edit Program Kerja: {{ $programKerja->name }}</h3>
                </div>
                <form action="{{ route('coordinator.program-kerja.update', $programKerja->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- Department is fixed to coordinator's department, not editable --}}

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Program Kerja</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $programKerja->name) }}" required>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="pic_user_id">Penanggung Jawab (PIC)</label>
                            <select name="pic_user_id" id="pic_user_id" class="form-control @error('pic_user_id') is-invalid @enderror">
                                <option value="">-- Pilih PIC --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('pic_user_id', $programKerja->pic_user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            @error('pic_user_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $programKerja->start_date ? $programKerja->start_date->format('Y-m-d') : '') }}" required>
                                    @error('start_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Tanggal Selesai</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $programKerja->end_date ? $programKerja->end_date->format('Y-m-d') : '') }}" required>
                                    @error('end_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi Program Kerja</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $programKerja->description) }}</textarea>
                            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="budget">Anggaran (Rp)</label>
                                    <input type="number" name="budget" id="budget" class="form-control @error('budget') is-invalid @enderror" value="{{ old('budget', $programKerja->budget) }}" step="0.01" min="0">
                                    @error('budget')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ old('status', $programKerja->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="progress_percentage">Persentase Progress (%)</label>
                                    <input type="number" name="progress_percentage" id="progress_percentage" class="form-control @error('progress_percentage') is-invalid @enderror" value="{{ old('progress_percentage', $programKerja->progress_percentage) }}" min="0" max="100">
                                    @error('progress_percentage')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="current_progress">Detail Progress Saat Ini</label>
                            <textarea name="current_progress" id="current_progress" class="form-control @error('current_progress') is-invalid @enderror" rows="3">{{ old('current_progress', $programKerja->current_progress) }}</textarea>
                            @error('current_progress')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        <a href="{{ route('coordinator.program-kerja.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>

            {{-- Card for Adding Progress Update --}}
            <div class="card card-info mt-4">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pembaruan Progres</h3>
                </div>
                <form action="{{ route('coordinator.program-kerja.storeUpdate', $programKerja->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="update_date">Tanggal Pembaruan</label>
                            <input type="date" name="update_date" id="update_date" class="form-control @error('update_date') is-invalid @enderror" value="{{ old('update_date', date('Y-m-d')) }}" required>
                            @error('update_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="progress_percentage_update">Persentase Progres Baru (Opsional)</label>
                            <input type="number" name="progress_percentage_update" id="progress_percentage_update" class="form-control @error('progress_percentage_update') is-invalid @enderror" value="{{ old('progress_percentage_update') }}" min="0" max="100" placeholder="Kosongkan jika hanya deskripsi">
                            <small class="form-text text-muted">Jika diisi, akan memperbarui persentase progres utama program kerja.</small>
                            @error('progress_percentage_update')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="description_update">Deskripsi Pembaruan</label>
                            <textarea name="description_update" id="description_update" class="form-control @error('description_update') is-invalid @enderror" rows="3" required>{{ old('description_update') }}</textarea>
                            @error('description_update')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Simpan Pembaruan</button>
                    </div>
                </form>
            </div>
            {{-- End Card for Adding Progress Update --}}

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script to retain scroll position or show errors
    // This will trigger if any error exists in the default bag, which is fine for now.
    @if ($errors->any())
        // More specific check could be to see if old('description_update') exists,
        // implying the second form was submitted.
        @if (old('description_update') || old('update_date') || old('progress_percentage_update'))
        window.onload = function() {
            var updateForm = document.getElementById('description_update');
            if (updateForm) {
                updateForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // Or focus an input: document.getElementById('update_date').focus();
            }
        };
        @endif
    @endif
</script>
@endpush
