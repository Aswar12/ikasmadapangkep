<!-- Quick Actions -->
<div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 mt-8">
    <div class="text-center mb-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Akses Cepat</h3>
        <p class="text-gray-600">Fitur dan layanan yang sering Anda gunakan</p>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Update Profile -->
        <a href="{{ route('alumni.profile.edit') }}" 
           class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-user-edit text-2xl"></i>
            </div>
            <h6 class="font-semibold text-gray-800 mb-1">Update Profil</h6>
            <p class="text-xs text-gray-500">Perbarui informasi Anda</p>
        </a>
        
        <!-- Pay Dues -->
        <a href="{{ route('alumni.payments.create') }}" 
           class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 text-white rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-money-check-alt text-2xl"></i>
            </div>
            <h6 class="font-semibold text-gray-800 mb-1">Bayar Iuran</h6>
            <p class="text-xs text-gray-500">Kontribusi tahunan</p>
        </a>
        
        <!-- View Gallery -->
        <a href="{{ route('alumni.gallery') }}" 
           class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 text-white rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-images text-2xl"></i>
            </div>
            <h6 class="font-semibold text-gray-800 mb-1">Lihat Gallery</h6>
            <p class="text-xs text-gray-500">Foto & kenangan</p>
        </a>
        
        <!-- Send Feedback -->
        <a href="{{ route('alumni.feedback.create') }}" 
           class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 text-white rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-comment-dots text-2xl"></i>
            </div>
            <h6 class="font-semibold text-gray-800 mb-1">Kirim Saran</h6>
            <p class="text-xs text-gray-500">Masukan Anda</p>
        </a>
        
        <!-- Alumni Directory -->
        <a href="{{ route('alumni.directory') }}" 
           class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-400 to-indigo-600 text-white rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-address-book text-2xl"></i>
            </div>
            <h6 class="font-semibold text-gray-800 mb-1">Direktori</h6>
            <p class="text-xs text-gray-500">Cari teman lama</p>
        </a>
        
        <!-- Events -->
        <a href="{{ route('alumni.events') }}" 
           class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 text-white rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-calendar-alt text-2xl"></i>
            </div>
            <h6 class="font-semibold text-gray-800 mb-1">Event</h6>
            <p class="text-xs text-gray-500">Acara & pertemuan</p>
        </a>
        
        <!-- Documents -->
        <a href="{{ route('alumni.documents') }}" 
           class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-red-400 to-red-600 text-white rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-file-alt text-2xl"></i>
            </div>
            <h6 class="font-semibold text-gray-800 mb-1">Dokumen</h6>
            <p class="text-xs text-gray-500">File & arsip</p>
        </a>
        
        <!-- Help -->
        <a href="{{ route('alumni.help') }}" 
           class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-600 text-white rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-question-circle text-2xl"></i>
            </div>
            <h6 class="font-semibold text-gray-800 mb-1">Bantuan</h6>
            <p class="text-xs text-gray-500">FAQ & support</p>
        </a>
    </div>
</div>
