<!-- Recent Events -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 h-full hover:shadow-xl transition-all duration-300">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-t-2xl flex justify-between items-center">
        <h5 class="text-xl font-bold flex items-center">
            <i class="fas fa-calendar-alt mr-2"></i>
            Event Mendatang
        </h5>
        <a href="{{ route('alumni.events') }}" 
           class="bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
            Lihat Semua
        </a>
    </div>
    
    <div class="p-6">
        @if(isset($upcoming_events) && count($upcoming_events) > 0)
            <div class="space-y-4">
                @foreach($upcoming_events->take(3) as $event)
                <div class="group border border-gray-100 rounded-xl p-4 hover:shadow-md transition-all duration-300 hover:border-indigo-200">
                    <div class="flex items-start space-x-4">
                        <!-- Event Date -->
                        <div class="flex-shrink-0">
                            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl p-3 text-center shadow-lg">
                                <p class="text-2xl font-bold">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</p>
                                <p class="text-xs uppercase">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</p>
                            </div>
                        </div>
                        
                        <!-- Event Details -->
                        <div class="flex-grow">
                            <h6 class="font-semibold text-gray-800 mb-1 group-hover:text-indigo-600 transition-colors">
                                {{ $event->event_name }}
                            </h6>
                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                                {{ $event->description }}
                            </p>
                            
                            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <i class="fas fa-clock mr-1 text-indigo-500"></i>
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('H:i') }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-1 text-indigo-500"></i>
                                    {{ $event->location }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-users mr-1 text-indigo-500"></i>
                                    {{ $event->attendees_count ?? 0 }} peserta
                                </span>
                            </div>
                        </div>
                        
                        <!-- Action Button -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('alumni.events.show', $event->id) }}" 
                               class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                                Detail
                                <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-calendar-times text-3xl text-gray-400"></i>
                </div>
                <h6 class="text-gray-800 font-semibold mb-2">Tidak Ada Event</h6>
                <p class="text-gray-500 text-sm">Tidak ada event mendatang saat ini.</p>
                <a href="{{ route('alumni.events') }}" 
                   class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium text-sm mt-4">
                    Lihat Event Sebelumnya
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @endif
    </div>
</div>
