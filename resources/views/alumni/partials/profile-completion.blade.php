<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
    <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-user-check text-green-500 mr-2"></i>
        Profil Lengkap
    </h5>
    <div class="text-center">
        <div class="text-4xl font-bold text-green-600 mb-2">
            {{ $profileCompletion ?? 0 }}%
        </div>
        <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="bg-green-500 h-4 rounded-full" style="width: {{ $profileCompletion ?? 0 }}%;"></div>
        </div>
        <p class="text-sm text-gray-600 mt-2">Lengkapi profil Anda untuk mendapatkan manfaat penuh dari platform ini.</p>
    </div>
</div>
