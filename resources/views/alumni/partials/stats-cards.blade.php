<!-- Stats Cards with Animation -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Alumni Card -->
    <div class="group hover-lift">
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 relative overflow-hidden transition-all duration-300 hover:shadow-xl">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-500 opacity-10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Alumni</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['total_alumni'] ?? 0) }}</p>
                    <p class="text-xs text-green-600 mt-2 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>+12% dari bulan lalu</span>
                    </p>
                </div>
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white p-4 rounded-2xl shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Status Card -->
    <div class="group hover-lift">
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 relative overflow-hidden transition-all duration-300 hover:shadow-xl">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-green-500 opacity-10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Status Iuran</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['payment_status'] ?? 'Belum' }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        Tahun {{ date('Y') }}
                    </p>
                </div>
                <div class="bg-gradient-to-br from-green-400 to-green-600 text-white p-4 rounded-2xl shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events Card -->
    <div class="group hover-lift">
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 relative overflow-hidden transition-all duration-300 hover:shadow-xl">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-yellow-500 opacity-10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Event Mendatang</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['upcoming_events'] ?? 0 }}</p>
                    <p class="text-xs text-yellow-600 mt-2">
                        <i class="fas fa-calendar mr-1"></i>
                        Bulan ini
                    </p>
                </div>
                <div class="bg-gradient-to-br from-yellow-400 to-orange-500 text-white p-4 rounded-2xl shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-calendar-check text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Vacancies Card -->
    <div class="group hover-lift">
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 relative overflow-hidden transition-all duration-300 hover:shadow-xl">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-purple-500 opacity-10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Lowongan Aktif</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['job_vacancies'] ?? 0 }}</p>
                    <p class="text-xs text-purple-600 mt-2">
                        <i class="fas fa-briefcase mr-1"></i>
                        Tersedia
                    </p>
                </div>
                <div class="bg-gradient-to-br from-purple-400 to-pink-500 text-white p-4 rounded-2xl shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-briefcase text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>
