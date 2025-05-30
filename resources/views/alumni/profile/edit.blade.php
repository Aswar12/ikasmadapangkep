
@extends('layouts.alumni')

@section('page-title', 'Edit Profil')

@section('content')
<div class="container mx-auto py-8 px-4 font-poppins text-gray-800">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold text-blue-700 mb-6">Edit Profil</h2>
        
        <!-- FORM UPLOAD FOTO PROFILE TERPISAH -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-blue-700 mb-4">📷 Foto Profil</h3>
            <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                <!-- Current Photo Display -->
                <div class="flex-shrink-0 mb-4 md:mb-0">
                    <div class="relative w-24 h-24 mx-auto md:mx-0 rounded-full overflow-hidden border-4 border-blue-200 shadow-lg">
                        <img src="{{ Auth::user()->profile_photo_url }}" 
                             alt="{{ $user->name }}" 
                             id="current-profile-photo"
                             class="w-full h-full object-cover">
                    </div>
                </div>
                
                <!-- Photo Upload Form -->
                <div class="flex-1">
                    <form id="photoUploadForm" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="profile_photo_upload" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Foto Baru (Max: 2MB, Format: JPG, PNG, GIF)
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="file" 
                                       id="profile_photo_upload" 
                                       name="profile_photo" 
                                       accept="image/jpeg,image/png,image/jpg,image/gif"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                
                                <button type="button" 
                                        id="uploadPhotoBtn" 
                                        disabled
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors">
                                    <i class="fas fa-upload mr-1"></i>Upload
                                </button>
                                
                                <button type="button" 
                                        id="deletePhotoBtn" 
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                        
                        <!-- Photo Preview -->
                        <div id="photoPreview" class="hidden">
                            <img id="previewImage" class="w-20 h-20 object-cover rounded-full border-2 border-gray-300">
                            <p class="text-sm text-gray-600 mt-1">Preview foto baru</p>
                        </div>
                        
                        @error('profile_photo')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </form>
                </div>
            </div>
            
            <!-- Success/Error Messages for Photo -->
            <div id="photoSuccessMessage" class="hidden mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                <i class="fas fa-check-circle mr-2"></i><span></span>
            </div>
            <div id="photoErrorMessage" class="hidden mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                <i class="fas fa-exclamation-circle mr-2"></i><span></span>
            </div>
        </div>
        
        <!-- FORM EDIT PROFILE UTAMA (TANPA FOTO) -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-blue-700 mb-4">✏️ Informasi Profil</h3>
        <form action="{{ route('alumni.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-blue-700 mb-3">Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-600">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-600">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">WhatsApp</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->whatsapp) }}" placeholder="08xxxxxxxxxx"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <select id="gender" name="gender"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('gender') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('gender', $profile->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender', $profile->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-blue-700 mb-3">Informasi Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="birth_place" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                <input type="text" id="birth_place" name="birth_place" value="{{ old('birth_place', $profile->birth_place ?? '') }}"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('birth_place') border-red-500 @enderror">
                                @error('birth_place')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <div class="flex space-x-2 mt-1">
                            <select id="birth_date_day" name="birth_date_day" class="block w-1/3 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('birth_date_day') border-red-500 @enderror">
                                <option value="">Hari</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}" {{ old('birth_date_day', isset($profile->birth_date) ? \Carbon\Carbon::parse($profile->birth_date)->day : '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <select id="birth_date_month" name="birth_date_month" class="block w-1/3 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('birth_date_month') border-red-500 @enderror">
                                <option value="">Bulan</option>
                                @foreach ([
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ] as $num => $name)
                                    <option value="{{ $num }}" {{ old('birth_date_month', isset($profile->birth_date) ? \Carbon\Carbon::parse($profile->birth_date)->month : '') == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            <select id="birth_date_year" name="birth_date_year" class="block w-1/3 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('birth_date_year') border-red-500 @enderror">
                                <option value="">Tahun</option>
                                @php
                                    $currentYear = date('Y');
                                    $startYear = $currentYear - 100;
                                @endphp
                                @for ($year = $currentYear; $year >= $startYear; $year--)
                                    <option value="{{ $year }}" {{ old('birth_date_year', isset($profile->birth_date) ? \Carbon\Carbon::parse($profile->birth_date)->year : '') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        @error('birth_date_day')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @error('birth_date_month')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @error('birth_date_year')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea id="address" name="address" rows="3"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('address') border-red-500 @enderror">{{ old('address', $profile->address ?? '') }}</textarea>
                            @error('address')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-blue-700 mb-3">Informasi Akademik</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="national_student_number" class="block text-sm font-medium text-gray-700">NISN</label>
                                <input type="text" id="national_student_number" name="national_student_number" value="{{ old('national_student_number', $profile->national_student_number ?? '') }}"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('national_student_number') border-red-500 @enderror">
                                @error('national_student_number')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="entry_year" class="block text-sm font-medium text-gray-700">Tahun Masuk</label>
                                <input type="text" id="entry_year" name="entry_year" value="{{ old('entry_year', $profile->entry_year ?? '') }}" placeholder="2018"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('entry_year') border-red-500 @enderror">
                                @error('entry_year')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="graduation_year" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                                <input type="text" id="graduation_year" name="graduation_year" value="{{ old('graduation_year', $profile->graduation_year ?? '') }}" placeholder="2021"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('graduation_year') border-red-500 @enderror">
                                @error('graduation_year')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="diploma_number" class="block text-sm font-medium text-gray-700">Nomor Ijazah</label>
                                <input type="text" id="diploma_number" name="diploma_number" value="{{ old('diploma_number', $profile->diploma_number ?? '') }}"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('diploma_number') border-red-500 @enderror">
                                @error('diploma_number')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="certificate_number" class="block text-sm font-medium text-gray-700">Nomor SKHUN</label>
                                <input type="text" id="certificate_number" name="certificate_number" value="{{ old('certificate_number', $profile->certificate_number ?? '') }}"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('certificate_number') border-red-500 @enderror">
                                @error('certificate_number')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-blue-700 mb-3">Informasi Keluarga</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="father_name" class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                                <input type="text" id="father_name" name="father_name" value="{{ old('father_name', $profile->father_name ?? '') }}"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('father_name') border-red-500 @enderror">
                                @error('father_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="father_occupation" class="block text-sm font-medium text-gray-700">Pekerjaan Ayah</label>
                                <input type="text" id="father_occupation" name="father_occupation" value="{{ old('father_occupation', $profile->father_occupation ?? '') }}"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('father_occupation') border-red-500 @enderror">
                                @error('father_occupation')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="mother_name" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                                <input type="text" id="mother_name" name="mother_name" value="{{ old('mother_name', $profile->mother_name ?? '') }}"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('mother_name') border-red-500 @enderror">
                                @error('mother_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="mother_occupation" class="block text-sm font-medium text-gray-700">Pekerjaan Ibu</label>
                                <input type="text" id="mother_occupation" name="mother_occupation" value="{{ old('mother_occupation', $profile->mother_occupation ?? '') }}"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('mother_occupation') border-red-500 @enderror">
                                @error('mother_occupation')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('alumni.profile') }}" class="inline-block px-6 py-2 border border-red-600 rounded-md text-red-600 hover:bg-red-100 transition">Batal</a>
                        <button type="submit" class="inline-block px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-md hover:from-blue-700 hover:to-blue-900 transition">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Handle Profile Photo Upload (Separate Form)
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('profile_photo_upload');
    const uploadBtn = document.getElementById('uploadPhotoBtn');
    const deleteBtn = document.getElementById('deletePhotoBtn');
    const photoPreview = document.getElementById('photoPreview');
    const previewImage = document.getElementById('previewImage');
    const currentPhoto = document.getElementById('current-profile-photo');
    const successMsg = document.getElementById('photoSuccessMessage');
    const errorMsg = document.getElementById('photoErrorMessage');
    
    // Show/hide messages
    function showMessage(element, message, duration = 5000) {
        element.querySelector('span').textContent = message;
        element.classList.remove('hidden');
        setTimeout(() => {
            element.classList.add('hidden');
        }, duration);
    }
    
    function hideMessages() {
        successMsg.classList.add('hidden');
        errorMsg.classList.add('hidden');
    }
    
    // Handle file selection
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        hideMessages();
        
        if (file) {
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                showMessage(errorMsg, 'Format file tidak didukung. Gunakan format JPEG, PNG, JPG, atau GIF.');
                this.value = '';
                uploadBtn.disabled = true;
                photoPreview.classList.add('hidden');
                return;
            }
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showMessage(errorMsg, 'Ukuran file terlalu besar. Maksimal 2MB.');
                this.value = '';
                uploadBtn.disabled = true;
                photoPreview.classList.add('hidden');
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                photoPreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
            
            // Enable upload button
            uploadBtn.disabled = false;
        } else {
            // Disable upload button if no file
            uploadBtn.disabled = true;
            photoPreview.classList.add('hidden');
        }
    });
    
    // Handle photo upload
    uploadBtn.addEventListener('click', function(e) {
        e.preventDefault();
        hideMessages();
        
        if (!photoInput.files[0]) {
            showMessage(errorMsg, 'Pilih foto terlebih dahulu.');
            return;
        }
        
        // Create form data
        const formData = new FormData();
        const file = photoInput.files[0];
        
        // Debug log
        console.log('File to upload:', file);
        console.log('File name:', file.name);
        console.log('File size:', file.size);
        console.log('File type:', file.type);
        
        // Append file - pastikan file benar-benar ada
        if (file && file.size > 0) {
            formData.append('profile_photo', file, file.name);
        } else {
            showMessage(errorMsg, 'File tidak valid atau kosong.');
            this.innerHTML = originalText;
            this.disabled = false;
            return;
        }
        
        // Append CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('input[name="_token"]').value;
        formData.append('_token', csrfToken);
        
        // Debug FormData
        console.log('FormData created:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ':', value);
        }
        
        // Show loading state
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Mengupload...';
        this.disabled = true;
        
        // Send AJAX request to separate photo upload endpoint
        fetch('{{ route("alumni.profile.photo.update") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success message
                showMessage(successMsg, data.message || 'Foto profil berhasil diperbarui!');
                
                // Update current photo display
                if (data.photo_url) {
                    currentPhoto.src = data.photo_url;
                }
                
                // Reset form
                photoInput.value = '';
                photoPreview.classList.add('hidden');
                uploadBtn.disabled = true;
                
                // Reload page after 2 seconds to refresh all photo instances
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
                
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            let errorMessage = 'Terjadi kesalahan saat mengupload foto';
            if (error.message) {
                errorMessage += ': ' + error.message;
            } else if (error.errors && error.errors.profile_photo) {
                errorMessage += ': ' + error.errors.profile_photo[0];
            }
            
            showMessage(errorMsg, errorMessage);
        })
        .finally(() => {
            // Reset button state
            this.innerHTML = originalText;
            this.disabled = false;
        });
    });
    
    // Handle photo deletion
    deleteBtn.addEventListener('click', function(e) {
        e.preventDefault();
        hideMessages();
        
        if (!confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
            return;
        }
        
        // Show loading state
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Menghapus...';
        this.disabled = true;
        
        // Send DELETE request
        fetch('{{ route("alumni.profile.delete-photo") }}', {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showMessage(successMsg, data.message || 'Foto profil berhasil dihapus!');
                
                // Reload page to refresh photo
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
                
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage(errorMsg, 'Terjadi kesalahan saat menghapus foto.');
        })
        .finally(() => {
            // Reset button state
            this.innerHTML = originalText;
            this.disabled = false;
        });
    });
});
</script>
@endpush
