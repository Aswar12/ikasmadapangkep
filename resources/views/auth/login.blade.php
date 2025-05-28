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

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Login Field -->
            <div class="space-y-2">
                <label for="login" class="auth-label">{{ __('Email / Username / No. WhatsApp') }}</label>
                <div class="input-container">
                    <i class="fas fa-user input-icon"></i>
                    <input id="login" 
                           class="auth-input block w-full" 
                           type="text" 
                           name="login" 
                           value="{{ old('login') }}" 
                           required 
                           autofocus 
                           autocomplete="username"
                           placeholder="Masukkan email, username, atau nomor WhatsApp" />
                </div>
                <p class="text-xs text-gray-500 mt-1 ml-2">Contoh: user@email.com, username123, atau 081234567890</p>
            </div>

            <!-- Password Field -->
            <div class="mt-6 space-y-2">
                <label for="password" class="auth-label">{{ __('Password') }}</label>
                <div class="input-container">
                    <i class="fas fa-lock input-icon"></i>
                    <input id="password" 
                           class="auth-input block w-full pr-12" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="Masukkan password" />
                    <button type="button" 
                            onclick="togglePassword()"
                            class="toggle-password"
                            title="Tampilkan/Sembunyikan Password">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="mt-6 flex items-center justify-between">
                <label class="flex items-center group cursor-pointer">
                    <input type="checkbox" name="remember" id="remember" 
                           class="rounded border-gray-300 text-primary-color shadow-sm focus:ring-primary-light focus:ring-opacity-50 transition-all duration-200" />
                    <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-800 transition-colors duration-200">{{ __('Ingat Saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="auth-link text-sm hover:underline transition-all duration-200" href="{{ route('password.request') }}">
                        <i class="fas fa-key mr-1 text-xs"></i>{{ __('Lupa Password?') }}
                    </a>
                @endif
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

                <!-- Login Button -->
                <button type="submit" 
                        class="auth-button w-full py-4 rounded-xl text-white font-semibold flex items-center justify-center text-lg shadow-lg"
                        id="loginButton">
                    <span id="loginButtonText">
                        <i class="fas fa-sign-in-alt mr-3"></i>{{ __('Masuk ke Sistem') }}
                    </span>
                    <span id="loginButtonLoading" class="hidden">
                        <svg class="animate-spin h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                </button>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum terdaftar sebagai alumni? 
                        <a href="{{ route('register') }}" class="auth-link font-semibold hover:underline transition-all duration-200">
                            <i class="fas fa-user-plus mr-1"></i>Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>
        </form>
    </x-authentication-card>

    @push('scripts')
    <script>
        // Toggle password visibility
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Form submission handling with loading state
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = this;
            const loginButton = document.getElementById('loginButton');
            const loginButtonText = document.getElementById('loginButtonText');
            const loginButtonLoading = document.getElementById('loginButtonLoading');
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');
            const successAlert = document.getElementById('successAlert');
            const successMessage = document.getElementById('successMessage');
            
            // Hide any existing alerts
            errorAlert.classList.add('hidden');
            successAlert.classList.add('hidden');
            
            // Show loading state
            loginButton.disabled = true;
            loginButtonText.classList.add('hidden');
            loginButtonLoading.classList.remove('hidden');
            
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
                    successMessage.textContent = data.message || 'Login berhasil!';
                    successAlert.classList.remove('hidden');
                    
                    // Redirect after a short delay
                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 1000);
                } else {
                    // Show error message
                    let message = data.message || 'Login gagal. Silakan coba lagi.';
                    
                    if (data.errors) {
                        if (data.errors.login) {
                            message = data.errors.login[0];
                        } else if (data.errors.password) {
                            message = data.errors.password[0];
                        }
                    }
                    
                    errorMessage.textContent = message;
                    errorAlert.classList.remove('hidden');
                    
                    // Reset button state
                    loginButton.disabled = false;
                    loginButtonText.classList.remove('hidden');
                    loginButtonLoading.classList.add('hidden');
                }
            } catch (error) {
                // Show error message
                errorMessage.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                errorAlert.classList.remove('hidden');
                
                // Reset button state
                loginButton.disabled = false;
                loginButtonText.classList.remove('hidden');
                loginButtonLoading.classList.add('hidden');
            }
        });
    </script>
    @endpush
</x-guest-layout>
