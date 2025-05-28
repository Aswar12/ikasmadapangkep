<!-- Welcome Section with Gradient Background -->
<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 rounded-2xl p-8 mb-8 text-white relative overflow-hidden shadow-2xl">
    <!-- Background Decorations -->
    <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-white opacity-10 rounded-full"></div>
    <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-48 h-48 bg-white opacity-10 rounded-full"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-white opacity-5 rounded-full"></div>
    
    <div class="relative z-10">
        <div class="flex flex-col lg:flex-row items-center justify-between">
            <div class="text-center lg:text-left mb-6 lg:mb-0">
                <h1 class="text-3xl md:text-4xl font-bold mb-3 animate-fade-in">
                    Selamat datang kembali, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="text-indigo-100 text-lg md:text-xl mb-6">
                    Senang melihat Anda kembali di portal alumni IKA SMADA Pangkep
                </p>
                
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl px-6 py-3 transform hover:scale-105 transition-transform">
                        <span class="text-sm opacity-80">Angkatan</span>
                        <p class="text-2xl font-bold">{{ Auth::user()->graduation_year }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl px-6 py-3 transform hover:scale-105 transition-transform">
                        <span class="text-sm opacity-80">Bergabung</span>
                        <p class="text-2xl font-bold">{{ Auth::user()->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Profile Image -->
            <div class="relative">
                <img src="{{ Auth::user()->profile_photo_url }}" 
                     alt="{{ Auth::user()->name }}" 
                     class="w-32 h-32 rounded-full border-4 border-white shadow-2xl">
                <div class="absolute -bottom-2 -right-2 bg-green-500 w-8 h-8 rounded-full border-4 border-white flex items-center justify-center">
                    <i class="fas fa-check text-white text-xs"></i>
                </div>
            </div>
        </div>
    </div>
</div>
