<!-- Profile Completion Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 h-full hover:shadow-xl transition-all duration-300">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-t-2xl">
        <h5 class="text-xl font-bold flex items-center">
            <i class="fas fa-user-check mr-2"></i>
            Kelengkapan Profil
        </h5>
    </div>
    
    <div class="p-6">
        <!-- Progress Circle -->
        <div class="text-center mb-6">
            <div class="relative inline-block">
                <svg class="w-40 h-40 transform -rotate-90">
                    <circle cx="80" cy="80" r="70" stroke="#e5e7eb" stroke-width="12" fill="none"/>
                    <circle cx="80" cy="80" r="70" 
                            stroke="url(#gradient)" 
                            stroke-width="12" 
                            fill="none"
                            stroke-linecap="round"
                            stroke-dasharray="{{ 440 * ($profile_completion ?? 0) / 100 }} 440"/>
                    <defs>
                        <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#6366f1;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#a855f7;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center">
                        <p class="text-4xl font-bold text-gray-800">{{ $profile_completion ?? 0 }}%</p>
                        <p class="text-sm text-gray-500">Lengkap</p>
                    </div>
                </div>
            </div>
        </div>
        
        @if($profile_completion < 100)
        <!-- Progress Items -->
        <div class="space-y-3 mb-6">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span class="text-sm text-gray-700">Informasi Dasar</span>
                </div>
                <span class="text-xs text-green-600 font-semibold">Lengkap</span>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-times-circle text-red-500 mr-3"></i>
                    <span class="text-sm text-gray-700">Foto Profil</span>
                </div>
                <span class="text-xs text-red-600 font-semibold">Belum</span>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-times-circle text-red-500 mr-3"></i>
                    <span class="text-sm text-gray-700">Informasi Kontak</span>
                </div>
                <span class="text-xs text-red-600 font-semibold">Belum</span>
            </div>
        </div>
        
        <!-- Alert -->
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5 mr-3"></i>
                <div>
                    <p class="text-sm font-semibold text-amber-800">Profil Belum Lengkap</p>
                    <p class="text-xs text-amber-700 mt-1">
                        Lengkapi profil Anda untuk mendapatkan pengalaman terbaik dan terhubung dengan alumni lainnya.
                    </p>
                </div>
            </div>
        </div>
        @else
        <!-- Success Message -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <div>
                    <p class="text-sm font-semibold text-green-800">Profil Lengkap!</p>
                    <p class="text-xs text-green-700 mt-1">
                        Terima kasih telah melengkapi profil Anda.
                    </p>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Action Button -->
        <a href="{{ route('alumni.profile.edit') }}" 
           class="btn-primary w-full py-3 px-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center">
            <i class="fas fa-edit mr-2"></i>
            {{ $profile_completion < 100 ? 'Lengkapi Profil' : 'Edit Profil' }}
        </a>
    </div>
</div>
