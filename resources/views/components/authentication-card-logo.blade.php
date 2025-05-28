<a href="/" class="flex flex-col items-center group">
    <div class="relative w-40 h-40 overflow-hidden rounded-lg shadow-xl transform group-hover:scale-105 transition-all duration-300">
        <!-- Logo Image -->
        <img src="{{ asset('images/LOGO IKA SMAD PANGKEP.png') }}" 
             alt="Logo IKA SMADA PANGKEP" 
             class="w-full h-full object-contain bg-white/95 p-2"
             loading="eager">
        
        <!-- Hover Effects -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#8E1920]/10 to-[#1A3A6A]/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="absolute inset-0 ring-2 ring-white/20 group-hover:ring-white/40 transition-all duration-300 rounded-lg"></div>
    </div>
    
    <!-- Organization Name -->
    <div class="mt-4 text-center">
        <h2 class="text-2xl font-bold text-white text-shadow">IKA SMADA</h2>
        <p class="text-sm font-medium text-white/80 text-shadow">PANGKAJENE DAN KEPULAUAN</p>
    </div>
</a>

<style>
    .text-shadow {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
</style>
