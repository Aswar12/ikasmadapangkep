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

            <div class="space-y-4">
                <div>
                    <x-label for="login" value="{{ __('Email/Username/WhatsApp') }}" />
                    <x-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus placeholder="Masukkan email, username, atau nomor WhatsApp" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('Kata Sandi') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi" />
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
