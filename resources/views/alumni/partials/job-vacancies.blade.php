<!-- Recent Job Vacancies -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
    <div class="bg-gradient-to-r from-purple-500 to-pink-600 text-white p-6 rounded-t-2xl flex justify-between items-center">
        <h5 class="text-xl font-bold flex items-center">
            <i class="fas fa-briefcase mr-2"></i>
            Lowongan Kerja Terbaru
        </h5>
        <a href="{{ route('alumni.jobs') }}" 
           class="bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
            Lihat Semua
        </a>
    </div>
    
    <div class="p-6">
        @if(isset($recent_jobs) && count($recent_jobs) > 0)
            <div class="space-y-4">
                @foreach($recent_jobs->take(3) as $job)
                <div class="group border border-gray-100 rounded-xl p-4 hover:shadow-md transition-all duration-300 hover:border-purple-200">
                    <div class="flex items-start space-x-4">
                        <!-- Company Logo -->
                        <div class="flex-shrink-0">
                            @if($job->company_logo)
                                <img src="{{ asset($job->company_logo) }}" 
                                     alt="{{ $job->company_name }}" 
                                     class="w-16 h-16 rounded-xl object-cover border border-gray-200 group-hover:border-purple-300 transition-all duration-300">
                            @else
                                <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-building text-2xl text-purple-600"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Job Details -->
                        <div class="flex-grow">
                            <h6 class="font-semibold text-gray-800 mb-1 group-hover:text-purple-600 transition-colors">
                                {{ $job->position }}
                            </h6>
                            <p class="text-sm text-gray-600 mb-2">
                                {{ $job->company_name }}
                            </p>
                            
                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-1 text-purple-500"></i>
                                    {{ $job->location }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-clock mr-1 text-purple-500"></i>
                                    {{ $job->job_type }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-money-bill-wave mr-1 text-purple-500"></i>
                                    {{ $job->salary_range ?? 'Negotiable' }}
                                </span>
                            </div>
                            
                            <!-- Tags -->
                            @if($job->tags)
                            <div class="flex flex-wrap gap-2 mt-3">
                                @foreach(explode(',', $job->tags) as $tag)
                                <span class="bg-purple-50 text-purple-600 px-2 py-1 rounded-md text-xs">
                                    {{ trim($tag) }}
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        
                        <!-- Action Button -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('alumni.jobs.show', $job->id) }}" 
                               class="bg-purple-50 hover:bg-purple-100 text-purple-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                                Detail
                                <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Deadline -->
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-calendar-times mr-1"></i>
                            Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('d F Y') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- View All Jobs -->
            <div class="mt-6 text-center">
                <a href="{{ route('alumni.jobs') }}" 
                   class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium text-sm">
                    Lihat Semua Lowongan
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-briefcase text-3xl text-gray-400"></i>
                </div>
                <h6 class="text-gray-800 font-semibold mb-2">Belum Ada Lowongan</h6>
                <p class="text-gray-500 text-sm mb-6">Tidak ada lowongan kerja yang tersedia saat ini.</p>
                
                <a href="{{ route('alumni.jobs.create') }}" 
                   class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium text-sm">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Posting Lowongan
                </a>
            </div>
        @endif
    </div>
</div>
