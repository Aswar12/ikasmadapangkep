<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl">
            <!-- Logo -->
            <div class="flex justify-center">
                <img src="{{ asset('images/LOGO IKA SMAD PANGKEP.png') }}" alt="Logo" class="h-24 w-auto">
            </div>

            <!-- Success Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
                <svg class="h-10 w-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <!-- Thank You Message -->
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Terima Kasih!') }}</h2>
                <p class="text-gray-600">
                    {{ __('Pendaftaran Anda di IKA SMADA Pangkep sedang menunggu persetujuan administrator.') }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    {{ __('Proses ini biasanya membutuhkan waktu 1-2 hari kerja.') }}
                </p>
            </div>

            <!-- Steps -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 space-y-4">
                <h3 class="text-lg font-semibold text-blue-800 flex items-center">
                    <span class="inline-block mr-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </span>
                    {{ __('Langkah Selanjutnya') }}
                </h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-200 flex items-center justify-center text-blue-600 font-semibold text-sm">1</div>
                        <p class="ml-3 text-sm text-gray-700">{{ __('Tim admin kami akan meninjau pendaftaran Anda') }}</p>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-200 flex items-center justify-center text-blue-600 font-semibold text-sm">2</div>
                        <p class="ml-3 text-sm text-gray-700">{{ __('Anda akan menerima notifikasi email setelah akun disetujui') }}</p>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-200 flex items-center justify-center text-blue-600 font-semibold text-sm">3</div>
                        <p class="ml-3 text-sm text-gray-700">{{ __('Setelah itu, Anda dapat login dan mengakses semua fitur platform') }}</p>
                    </div>
                </div>
            </div>

            <!-- Support Info -->
            <div class="text-center px-4 py-3 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">
                    {{ __('Jika Anda memiliki pertanyaan atau membutuhkan bantuan, silakan hubungi tim support kami di:') }}
                </p>
                <div class="mt-4 flex flex-col items-center space-y-3">
                    <a href="mailto:humas@ikasmadapangkep.org" class="group px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-blue-50 transition-colors duration-150 w-full max-w-xs">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-150">
                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 text-left">
                                <p class="text-xs text-gray-500">Email</p>
                                <p class="text-sm font-medium text-gray-900">humas@ikasmadapangkep.org</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="tel:+6281355524497" class="group px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-blue-50 transition-colors duration-150 w-full max-w-xs">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-150">
                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 text-left">
                                <p class="text-xs text-gray-500">WhatsApp</p>
                                <p class="text-sm font-medium text-gray-900">+62 813-5552-4497</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Logout Button -->
            <div class="flex justify-center pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="group text-sm text-gray-500 hover:text-gray-900 flex items-center px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-150">
                        <svg class="h-5 w-5 mr-2 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        {{ __('Keluar') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
