<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nama Lengkap -->
                <div>
                    <x-label for="name" value="{{ __('Nama Lengkap') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />
                </div>

                <!-- Username -->
                <div>
                    <x-label for="username" value="{{ __('Username') }}" />
                    <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" placeholder="Masukkan username unik" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Email -->
                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" 
                            class="block mt-1 w-full" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            placeholder="nama@email.com" />
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- WhatsApp -->
                <div>
                    <x-label for="phone" value="{{ __('WhatsApp') }}" />
                    <div class="mt-1 relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            +62
                        </span>
                        <x-input id="phone" 
                                class="block w-full pl-12" 
                                type="text" 
                                name="phone" 
                                :value="old('phone')" 
                                required 
                                placeholder="8123456789 (tanpa 0 di depan)" />
                    </div>
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Format: 8123456789 (tanpa 0 atau +62 di depan)</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Tahun Kelulusan -->
                <div>
                    <x-label for="graduation_year" value="{{ __('Tahun Kelulusan') }}" />
                    <x-input id="graduation_year" 
                            class="block mt-1 w-full" 
                            type="number" 
                            name="graduation_year" 
                            :value="old('graduation_year')" 
                            required 
                            min="1980" 
                            max="{{ date('Y') }}" 
                            placeholder="Contoh: 2010" />
                    @error('graduation_year')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Profesi Saat Ini -->
                <div>
                    <x-label for="current_job" value="{{ __('Profesi Saat Ini') }}" />
                    <x-input id="current_job" 
                            class="block mt-1 w-full" 
                            type="text" 
                            name="current_job" 
                            :value="old('current_job')" 
                            placeholder="Contoh: Guru, Dokter, Wiraswasta" />
                    @error('current_job')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Password -->
                <div>
                    <x-label for="password" value="{{ __('Kata Sandi') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 karakter" />
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <x-label for="password_confirmation" value="{{ __('Konfirmasi Kata Sandi') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            {{-- Information Alert --}}
            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Pastikan data yang Anda masukkan sesuai dengan data alumni yang valid. Setelah mendaftar, akun Anda akan diverifikasi oleh admin.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Action Buttons and Login Link --}}
            <div class="mt-6 flex flex-col items-center space-y-4">
                <x-button class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 justify-center px-8">
                    {{ __('Daftar Sekarang') }}
                </x-button>

                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Sudah punya akun?') }} 
                    <span class="text-blue-600 hover:text-blue-700 font-medium">{{ __('Masuk di sini') }}</span>
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

    @push('scripts')
    <script src="{{ asset('js/form-validation.js') }}"></script>
    @endpush
</x-guest-layout>
