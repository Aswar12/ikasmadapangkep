<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            
            {{-- Debug CSRF Token --}}
            @if(config('app.debug'))
                <input type="hidden" name="_debug_csrf" value="{{ csrf_token() }}">
            @endif

            <div class="space-y-4">
                <div>
                    <x-label for="login" value="{{ __('Email/Username/WhatsApp') }}" />
                    <x-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus placeholder="Masukkan email, username, atau nomor WhatsApp" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('Kata Sandi') }}" />
                    <div class="relative">
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi" />
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 end-0 mt-1 px-3 flex items-center focus:outline-none text-gray-600 hover:text-gray-800">
                            <svg id="eye-icon" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-off-icon" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:text-blue-700" href="{{ route('password.request') }}">
                        {{ __('Lupa kata sandi?') }}
                    </a>
                @endif
            </div>

            {{-- Action Button --}}
            <div class="mt-6 flex flex-col items-center space-y-4">
                <x-button class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 justify-center px-8">
                    {{ __('Masuk') }}
                </x-button>

                <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Belum punya akun?') }} 
                    <span class="text-blue-600 hover:text-blue-700 font-medium">{{ __('Daftar di sini') }}</span>
                </a>
            </div>

            {{-- Footer with Attribution --}}
            <div class="mt-8 pt-4 border-t border-gray-200">
                <div class="flex flex-col items-center justify-center space-y-1">
                    <p class="text-sm text-gray-600">
                        © {{ date('Y') }} IKA SMADA Pangkep. All rights reserved.
                    </p>
                    <p class="text-xs text-gray-500">
                        Developed by Departemen Humas dan Jaringan
                    </p>
                </div>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeOffIcon = document.getElementById('eye-off-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeOffIcon.classList.add('hidden');
        }
    }
</script>
