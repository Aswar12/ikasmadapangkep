<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <a href="/" class="flex flex-col items-center group">
                <div class="relative w-40 h-40 overflow-hidden rounded-lg transform group-hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('images/LOGO IKA SMAD PANGKEP.png') }}" 
                         alt="Logo IKA SMADA PANGKEP" 
                         class="w-full h-full object-contain"
                         loading="eager">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-light/10 to-primary-dark/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
            </a>
        </x-slot>

        <x-validation-errors class="mb-4 text-red-600" />

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <!-- Header Text -->
            <div class="text-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Pendaftaran Alumni</h2>
                <p class="text-sm text-gray-600">Daftarkan diri Anda sebagai bagian dari keluarga besar IKA SMADA Pangkep</p>
            </div>

            <!-- Name Field -->
            <div class="space-y-2">
                <label for="name" class="auth-label">{{ __('Nama Lengkap') }} <span class="text-red-500">*</span></label>
                <div class="input-container">
                    <i class="fas fa-user input-icon"></i>
                    <input id="name" 
                           class="auth-input block w-full" 
                           type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           autofocus 
                           autocomplete="name"
                           placeholder="Masukkan nama lengkap sesuai ijazah" />
                </div>
                @error('name')
                    <p class="text-xs text-red-500 mt-1 ml-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username Field -->
            <div class="mt-4 space-y-2">
                <label for="username" class="auth-label">{{ __('Username') }} <span class="text-red-500">*</span></label>
                <div class="input-container">
                    <i class="fas fa-at input-icon"></i>
                    <input id="username" 
                           class="auth-input block w-full" 
                           type="text" 
                           name="username" 
                           value="{{ old('username') }}" 
                           required 
                           autocomplete="username"
                           placeholder="Minimal 5 karakter, hanya huruf, angka, dan underscore" />
                </div>
                @error('username')
                    <p class="text-xs text-red-500 mt-1 ml-2">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1 ml-2">Contoh: alumni123, smada_alumni</p>
            </div>

            <!-- Email Field -->
            <div class="mt-4 space-y-2">
                <label for="email" class="auth-label">{{ __('Email') }} <span class="text-red-500">*</span></label>
                <div class="input-container">
                    <i class="fas fa-envelope input-icon"></i>
                    <input id="email" 
                           class="auth-input block w-full" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email"
                           placeholder="alamat@email.com" />
                </div>
                @error('email')
                    <p class="text-xs text-red-500 mt-1 ml-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- WhatsApp Field -->
            <div class="mt-4 space-y-2">
                <label for="whatsapp" class="auth-label">{{ __('Nomor WhatsApp') }} <span class="text-red-500">*</span></label>
                <div class="input-container">
                    <i class="fab fa-whatsapp input-icon"></i>
                    <input id="whatsapp" 
                           class="auth-input block w-full" 
                           type="text" 
                           name="whatsapp" 
                           value="{{ old('whatsapp') }}" 
                           required 
                           autocomplete="tel"
                           placeholder="081234567890 atau +6281234567890" />
                </div>
                @error('whatsapp')
                    <p class="text-xs text-red-500 mt-1 ml-2">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1 ml-2">Format: 08xx, 628xx, atau +628xx</p>
            </div>

            <!-- Password Field -->
            <div class="mt-4 space-y-2">
                <label for="password" class="auth-label">{{ __('Password') }} <span class="text-red-500">*</span></label>
                <div class="input-container">
                    <i class="fas fa-lock input-icon"></i>
                    <input id="password" 
                           class="auth-input block w-full pr-12" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           placeholder="Minimal 8 karakter dengan kombinasi" />
                    <button type="button" 
                            onclick="togglePassword('password')"
                            class="toggle-password"
                            title="Tampilkan/Sembunyikan Password"
                            style="cursor: pointer;">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-red-500 mt-1 ml-2">{{ $message }}</p>
                @enderror
                
                <!-- Password Strength Indicator -->
                <div class="mt-2 ml-2">
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-red-500 transition-all duration-300" id="passwordStrength" style="width: 0%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Kekuatan: <span id="passwordStrengthText" class="font-medium">-</span>
                    </p>
                </div>
                <p class="text-xs text-gray-500 mt-1 ml-2">Harus mengandung huruf besar, kecil, angka, dan simbol</p>
            </div>

            <!-- Confirm Password Field -->
            <div class="mt-4 space-y-2">
                <label for="password-confirm" class="auth-label">{{ __('Konfirmasi Password') }} <span class="text-red-500">*</span></label>
                <div class="input-container">
                    <i class="fas fa-lock input-icon"></i>
                    <input id="password-confirm" 
                           class="auth-input block w-full pr-12" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           placeholder="Ulangi password yang sama" />
                    <button type="button" 
                            onclick="togglePassword('password-confirm')"
                            class="toggle-password"
                            title="Tampilkan/Sembunyikan Password"
                            style="cursor: pointer;">
                        <i class="fas fa-eye" id="togglePasswordConfirmIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="mt-6">
                <label class="flex items-start group cursor-pointer">
                    <input type="checkbox" name="terms" id="terms" required
                           class="mt-1 rounded border-gray-300 text-primary-color shadow-sm focus:ring-primary-light focus:ring-opacity-50 transition-all duration-200" />
                    <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-800 transition-colors duration-200">
                        Saya setuju dengan 
                        <a href="#" onclick="showTermsModal()" class="auth-link font-medium hover:underline">
                            Syarat dan Ketentuan
                        </a> 
                        serta 
                        <a href="#" onclick="showPrivacyModal()" class="auth-link font-medium hover:underline">
                            Kebijakan Privasi
                        </a> 
                        IKA SMADA Pangkep
                    </span>
                </label>
            </div>

            <div class="mt-8">
                <!-- Error Alert -->
                <div class="mb-4 hidden" id="errorAlert">
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700" id="errorMessage"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success Alert -->
                <div class="mb-4 hidden" id="successAlert">
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700" id="successMessage"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Register Button -->
                <button type="submit" 
                        class="auth-button w-full py-4 rounded-xl text-white font-semibold flex items-center justify-center text-lg shadow-lg"
                        id="registerButton">
                    <span id="registerButtonText">
                        <i class="fas fa-user-plus mr-3"></i>{{ __('Daftar Sebagai Alumni') }}
                    </span>
                    <span id="registerButtonLoading" class="hidden">
                        <svg class="animate-spin h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah terdaftar sebagai alumni? 
                        <a href="{{ route('login') }}" class="auth-link font-semibold hover:underline transition-all duration-200">
                            <i class="fas fa-sign-in-alt mr-1"></i>Masuk ke Sistem
                        </a>
                    </p>
                </div>
            </div>
        </form>
    </x-authentication-card>

    <!-- Terms Modal -->
    <div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-2xl w-full max-h-[80vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Syarat dan Ketentuan</h3>
                        <button onclick="hideTermsModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="prose text-sm text-gray-600 space-y-4">
                        <h4 class="font-medium text-gray-800">1. Penggunaan Layanan</h4>
                        <p>Dengan mendaftar dalam sistem informasi IKA SMADA Pangkep, Anda setuju untuk menggunakan layanan ini sesuai dengan peraturan yang berlaku dan tujuan organisasi.</p>
                        
                        <h4 class="font-medium text-gray-800">2. Keanggotaan</h4>
                        <p>Pendaftaran hanya diperuntukkan bagi alumni SMADA Pangkep yang sah. Data yang diberikan harus akurat dan dapat diverifikasi.</p>
                        
                        <h4 class="font-medium text-gray-800">3. Privasi Data</h4>
                        <p>Kami berkomitmen untuk melindungi data pribadi Anda sesuai dengan kebijakan privasi organisasi.</p>
                        
                        <h4 class="font-medium text-gray-800">4. Tanggung Jawab Pengguna</h4>
                        <p>Anda bertanggung jawab untuk menjaga kerahasiaan akun dan password Anda serta tidak menyalahgunakan sistem.</p>
                    </div>
                    <div class="mt-6 text-right">
                        <button onclick="hideTermsModal()" class="px-4 py-2 bg-primary-color text-white rounded-lg hover:bg-primary-light transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Modal -->
    <div id="privacyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-2xl w-full max-h-[80vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Kebijakan Privasi</h3>
                        <button onclick="hidePrivacyModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="prose text-sm text-gray-600 space-y-4">
                        <h4 class="font-medium text-gray-800">1. Pengumpulan Data</h4>
                        <p>Kami mengumpulkan data yang diperlukan untuk keperluan administrasi organisasi dan komunikasi antar alumni.</p>
                        
                        <h4 class="font-medium text-gray-800">2. Penggunaan Data</h4>
                        <p>Data Anda digunakan untuk keperluan internal organisasi, komunikasi kegiatan, dan pengembangan jaringan alumni.</p>
                        
                        <h4 class="font-medium text-gray-800">3. Keamanan Data</h4>
                        <p>Kami menerapkan langkah-langkah keamanan yang sesuai untuk melindungi data pribadi Anda dari akses yang tidak sah.</p>
                        
                        <h4 class="font-medium text-gray-800">4. Hak Pengguna</h4>
                        <p>Anda berhak untuk mengakses, mengubah, atau menghapus data pribadi Anda dengan menghubungi administrator sistem.</p>
                    </div>
                    <div class="mt-6 text-right">
                        <button onclick="hidePrivacyModal()" class="px-4 py-2 bg-primary-color text-white rounded-lg hover:bg-primary-light transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const iconId = fieldId === 'password' ? 'togglePasswordIcon' : 'togglePasswordConfirmIcon';
            const icon = document.getElementById(iconId);
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('passwordStrengthText');
            
            let strength = 0;
            let strengthLabel = '-';
            let color = 'bg-red-500';
            
            if (password.length >= 8) strength += 20;
            if (password.length >= 12) strength += 10;
            if (/[a-z]/.test(password)) strength += 20;
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[0-9]/.test(password)) strength += 15;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 15;
            
            if (strength <= 20) {
                strengthLabel = 'Sangat Lemah';
                color = 'bg-red-500';
            } else if (strength <= 40) {
                strengthLabel = 'Lemah';
                color = 'bg-orange-500';
            } else if (strength <= 60) {
                strengthLabel = 'Sedang';
                color = 'bg-yellow-500';
            } else if (strength <= 80) {
                strengthLabel = 'Kuat';
                color = 'bg-blue-500';
            } else {
                strengthLabel = 'Sangat Kuat';
                color = 'bg-green-500';
            }
            
            strengthBar.style.width = Math.min(strength, 100) + '%';
            strengthBar.className = `h-full transition-all duration-300 ${color}`;
            strengthText.textContent = strengthLabel;
        });

        // WhatsApp number formatter
        document.getElementById('whatsapp').addEventListener('input', function() {
            let value = this.value.replace(/[^0-9+]/g, '');
            this.value = value;
        });

        // Modal functions
        function showTermsModal() {
            document.getElementById('termsModal').classList.remove('hidden');
        }

        function hideTermsModal() {
            document.getElementById('termsModal').classList.add('hidden');
        }

        function showPrivacyModal() {
            document.getElementById('privacyModal').classList.remove('hidden');
        }

        function hidePrivacyModal() {
            document.getElementById('privacyModal').classList.add('hidden');
        }

        // Form submission handling
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = this;
            const registerButton = document.getElementById('registerButton');
            const registerButtonText = document.getElementById('registerButtonText');
            const registerButtonLoading = document.getElementById('registerButtonLoading');
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');
            const successAlert = document.getElementById('successAlert');
            const successMessage = document.getElementById('successMessage');
            
            // Hide any existing alerts
            errorAlert.classList.add('hidden');
            successAlert.classList.add('hidden');
            
            // Show loading state
            registerButton.disabled = true;
            registerButtonText.classList.add('hidden');
            registerButtonLoading.classList.remove('hidden');
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    // Show success message
                    successMessage.textContent = data.message || 'Pendaftaran berhasil! Selamat datang di IKA SMADA Pangkep';
                    successAlert.classList.remove('hidden');
                    
                    // Redirect after a short delay
                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 1500);
                } else {
                    // Show error message
                    let message = data.message || 'Pendaftaran gagal. Silakan coba lagi.';
                    
                    if (data.errors) {
                        const firstError = Object.values(data.errors)[0];
                        if (Array.isArray(firstError)) {
                            message = firstError[0];
                        }
                    }
                    
                    errorMessage.textContent = message;
                    errorAlert.classList.remove('hidden');
                    
                    // Reset button state
                    registerButton.disabled = false;
                    registerButtonText.classList.remove('hidden');
                    registerButtonLoading.classList.add('hidden');
                }
            } catch (error) {
                console.error('Error:', error);
                
                // Show generic error message
                errorMessage.textContent = 'Terjadi kesalahan sistem. Silakan coba lagi.';
                errorAlert.classList.remove('hidden');
                
                // Reset button state
                registerButton.disabled = false;
                registerButtonText.classList.remove('hidden');
                registerButtonLoading.classList.add('hidden');
            }
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id === 'termsModal') {
                hideTermsModal();
            }
            if (e.target.id === 'privacyModal') {
                hidePrivacyModal();
            }
        });
    </script>
</x-guest-layout>
