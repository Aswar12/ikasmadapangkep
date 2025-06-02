@extends('layouts.alumni')

@section('page-title', 'Upload Bukti Pembayaran')

@section('content')
<div class="container mx-auto px-4 max-w-4xl">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('alumni.payments') }}" class="text-indigo-600 hover:text-indigo-900 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Pembayaran
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Upload Bukti Pembayaran</h1>
        <p class="text-gray-600 mt-2">Upload bukti pembayaran iuran tahunan sebesar Rp 50.000</p>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <p class="font-medium">Error!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <p class="font-medium">Terdapat kesalahan:</p>
            <ul class="list-disc list-inside mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <form action="{{ route('alumni.payments.store') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
            @csrf
            
            <div class="p-6 space-y-6">
                <!-- Year Selection -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <select name="year" id="year" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @if(isset($year))
                            <option value="{{ $year }}" selected>{{ $year }}</option>
                        @else
                            <option value="">-- Pilih Tahun --</option>
                            @php
                                $currentYear = date('Y');
                                $startYear = $currentYear - 4;
                            @endphp
                            @for($y = $currentYear; $y >= $startYear; $y--)
                                <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        @endif
                    </select>
                    @error('year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Amount Info -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Jumlah yang harus dibayar:</span>
                        <span class="text-2xl font-bold text-indigo-600">Rp 50.000</span>
                    </div>
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Metode Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="transfer" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                   {{ old('payment_method', 'transfer') == 'transfer' ? 'checked' : '' }}
                                   required>
                            <span class="ml-3">
                                <span class="block text-sm font-medium text-gray-900">Transfer Bank</span>
                                <span class="block text-xs text-gray-500">Pembayaran melalui transfer bank</span>
                            </span>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="cash" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                   {{ old('payment_method') == 'cash' ? 'checked' : '' }}
                                   required>
                            <span class="ml-3">
                                <span class="block text-sm font-medium text-gray-900">Tunai</span>
                                <span class="block text-xs text-gray-500">Pembayaran tunai langsung</span>
                            </span>
                        </label>
                    </div>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Proof Upload -->
                <div>
                    <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                        Bukti Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-3"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="payment_proof" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload file</span>
                                    <input id="payment_proof" name="payment_proof" type="file" 
                                           class="sr-only" accept="image/*,.pdf" required>
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                JPG, PNG atau PDF maksimal 2MB
                            </p>
                        </div>
                    </div>
                    <div id="file-preview" class="mt-2 hidden">
                        <div class="bg-gray-50 rounded-lg p-3 flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-file text-gray-400 mr-2"></i>
                                <span id="file-name" class="text-sm text-gray-700"></span>
                                <span id="file-size" class="text-xs text-gray-500 ml-2"></span>
                            </div>
                            <button type="button" id="remove-file" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @error('payment_proof')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan (Opsional)
                    </label>
                    <textarea name="notes" id="notes" rows="3" 
                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pay for next year option -->
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="pay_for_next_year" id="pay_for_next_year" value="1" class="form-checkbox text-indigo-600" {{ old('pay_for_next_year') ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Bayar untuk tahun berikutnya jika jumlah pembayaran lebih dari Rp 50.000</span>
                    </label>
                </div>

                <!-- Pay for friend option -->
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="pay_for_friend" id="pay_for_friend" value="1" class="form-checkbox text-indigo-600" {{ old('pay_for_friend') ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Bayar untuk teman</span>
                    </label>
                </div>

                <!-- Friend selection dropdown -->
                <div class="mt-2" id="friend_selection" style="display: none;">
                    <label for="friend_user_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih teman</label>
                    <select name="friend_user_id" id="friend_user_id" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Pilih Teman --</option>
                        @foreach($friends as $friend)
                            <option value="{{ $friend->id }}" {{ old('friend_user_id') == $friend->id ? 'selected' : '' }}>
                                {{ $friend->name }} ({{ $friend->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('friend_user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @push('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const payForFriendCheckbox = document.getElementById('pay_for_friend');
                        const friendSelection = document.getElementById('friend_selection');

                        function toggleFriendSelection() {
                            if (payForFriendCheckbox.checked) {
                                friendSelection.style.display = 'block';
                            } else {
                                friendSelection.style.display = 'none';
                                document.getElementById('friend_user_id').value = '';
                            }
                        }

                        payForFriendCheckbox.addEventListener('change', toggleFriendSelection);

                        // Initialize on page load
                        toggleFriendSelection();
                    });
                </script>
                @endpush

                <!-- Bank Account Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-blue-900 mb-3">
                        <i class="fas fa-university mr-2"></i>
                        Informasi Rekening
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            
                        <div>
                            <p class="text-blue-700 font-medium">Bank BRI</p>
                            <p class="text-blue-900 font-mono">0222 01692002561</p>
                            <p class="text-blue-600">a.n. IKA SMADA Pangkep</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                <button type="button" onclick="window.location.href='{{ route('alumni.payments') }}'"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Batal
                </button>
                <button type="submit" id="submitBtn"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-upload mr-2"></i>
                    Upload Bukti Pembayaran
                </button>
            </div>
        </form>
    </div>

    <!-- Instructions -->
    <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-yellow-900 mb-2">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Petunjuk Pembayaran
        </h3>
        <ol class="list-decimal list-inside space-y-2 text-sm text-yellow-800">
            <li>Transfer sejumlah <strong>Rp 50.000</strong> ke salah satu rekening di atas</li>
            <li>Simpan bukti transfer (screenshot atau foto struk ATM)</li>
            <li>Upload bukti transfer melalui form ini</li>
            <li>Tunggu verifikasi dari admin (1-2 hari kerja)</li>
            <li>Anda akan menerima notifikasi setelah pembayaran diverifikasi</li>
        </ol>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('payment_proof');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const removeFile = document.getElementById('remove-file');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('paymentForm');

    // File upload preview
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileName.textContent = file.name;
            fileSize.textContent = '(' + formatFileSize(file.size) + ')';
            filePreview.classList.remove('hidden');
        }
    });

    // Remove file
    removeFile.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.add('hidden');
    });

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Drag and drop
    const dropZone = document.querySelector('.border-dashed');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-indigo-600', 'bg-indigo-50');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-indigo-600', 'bg-indigo-50');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        
        const event = new Event('change', { bubbles: true });
        fileInput.dispatchEvent(event);
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengupload...';
    });
});
</script>
@endpush
