@extends('layouts.dashboard')

@section('navigation')
<ul class="space-y-1">
    <li>
        <a href="{{ route('alumni.dashboard') }}" class="flex items-center {{ request()->routeIs('alumni.dashboard') ? 'bg-blue-50 text-blue-900 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-xl py-3 px-4">
            <i class="fas fa-home w-6"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Profile -->
    <li>
        <a href="{{ route('profile.show') }}" class="flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
            <i class="fas fa-user w-6"></i>
            <span>Profile Saya</span>
        </a>
    </li>

    <!-- Events -->
    <li>
        <a href="{{ route('events.index') }}" class="flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
            <i class="fas fa-calendar-alt w-6"></i>
            <span>Event</span>
        </a>
    </li>

    <!-- Alumni Directory -->
    <li>
        <a href="#" class="flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
            <i class="fas fa-users w-6"></i>
            <span>Direktori Alumni</span>
        </a>
    </li>

    <!-- Gallery -->
    <li>
        <a href="{{ route('gallery.index') }}" class="flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
            <i class="fas fa-images w-6"></i>
            <span>Galeri</span>
        </a>
    </li>

    <!-- Finance -->
    <li>
        <a href="#" class="flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
            <i class="fas fa-wallet w-6"></i>
            <span>Keuangan</span>
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-lg p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold">Selamat Datang, {{ $user->name }}! 👋</h1>
                    <p class="text-blue-100">Tetap terhubung dengan komunitas alumni SMADA Pangkep</p>
                </div>
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" 
                     class="h-24 w-24 rounded-xl border-4 border-white/20 shadow-lg hidden md:block">
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Kelengkapan Profil</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 flex items-center">
                                    {{ $stats['profile_completion'] }}%
                                    <div class="ml-2 w-20 h-1.5 bg-gray-200 rounded-full">
                                        <div class="h-1.5 bg-blue-500 rounded-full" style="width: {{ $stats['profile_completion'] }}%"></div>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-{{ $stats['payment_status'] == 'sudah_lunas' ? 'green' : ($stats['payment_status'] == 'menunggu_verifikasi' ? 'yellow' : 'red') }}-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Iuran {{ date('Y') }}</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    @if($stats['payment_status'] == 'sudah_lunas')
                                        Lunas
                                    @elseif($stats['payment_status'] == 'menunggu_verifikasi')
                                        Verifikasi
                                    @else
                                        Belum Bayar
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Alumni Angkatan {{ $user->graduation_year }}</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_alumni_angkatan'] }} Orang</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Event Terdaftar</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_events_registered'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Completion Alert -->
        @if($stats['profile_completion'] < 100)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Profil Anda baru {{ $stats['profile_completion'] }}% lengkap. 
                        <a href="{{ route('profile.edit') }}" class="font-medium underline text-yellow-700 hover:text-yellow-600">
                            Lengkapi profil Anda
                        </a>
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Payment Alert -->
        @if($stats['payment_status'] == 'belum_bayar')
        <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl border border-red-200 p-6 mb-8">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 rounded-xl p-3">
                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-lg font-semibold text-gray-900">Iuran Belum Dibayar</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Iuran tahunan tahun {{ date('Y') }} Anda belum dibayar. 
                        <a href="{{ route('payments.index') }}" class="font-medium underline text-red-700 hover:text-red-600">
                            Bayar sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
        @endif            <!-- Quick Actions -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('events.index') }}" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:border-blue-500 hover:shadow-md transition-all group">
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-br from-blue-100 to-blue-50 p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar text-blue-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Event</span>
                    </div>
                </a>
                
                <a href="#" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:border-purple-500 hover:shadow-md transition-all group">
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-br from-purple-100 to-purple-50 p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-users text-purple-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Alumni</span>
                    </div>
                </a>
                
                <a href="#" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:border-green-500 hover:shadow-md transition-all group">
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-br from-green-100 to-green-50 p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-wallet text-green-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Iuran</span>
                    </div>
                </a>
                
                <a href="{{ route('gallery.index') }}" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:border-yellow-500 hover:shadow-md transition-all group">
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-br from-yellow-100 to-yellow-50 p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-images text-yellow-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Galeri</span>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Upcoming Events -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Event Mendatang</h2>
                                <p class="text-sm text-gray-500">Acara yang akan datang</p>
                            </div>
                            <a href="{{ route('events.index') }}" class="text-sm text-blue-600 hover:text-blue-700 hover:underline">Lihat Semua</a>
                        </div>
                        @if($upcomingEvents->count() > 0)
                        <div class="space-y-4">
                            @foreach($upcomingEvents as $event)
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0 w-12 text-center">
                                    <span class="block text-lg font-bold text-gray-900">{{ $event->event_date->format('d') }}</span>
                                    <span class="block text-xs font-medium text-gray-600">{{ $event->event_date->format('M') }}</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $event->event_title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $event->location }}</p>
                                    <div class="flex items-center mt-2 text-xs text-gray-500">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $event->event_date->format('H:i') }} WIB
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Tidak ada event mendatang.</p>
                    @endif
                </div>
            </div>

            <!-- Latest Job Vacancies -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Lowongan Kerja</h2>
                            <p class="text-sm text-gray-500">Peluang karir terbaru</p>
                        </div>
                        <a href="{{ route('jobs.index') }}" class="text-sm text-blue-600 hover:text-blue-700 hover:underline">Lihat Semua</a>
                    </div>
                    @if($latestJobs->count() > 0)
                        <div class="space-y-4">
                            @foreach($latestJobs as $job)
                            <div class="p-4 bg-white border border-gray-100 rounded-lg hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $job->position }}</h3>
                                        <div class="flex items-center mt-2 text-sm text-gray-600">
                                            <i class="fas fa-building mr-2"></i>
                                            {{ $job->company_name }}
                                        </div>
                                        <div class="flex items-center mt-1 text-sm text-gray-600">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            {{ $job->location }}
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                        {{ $job->application_deadline->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Tidak ada lowongan kerja saat ini.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Latest Gallery from My Year -->
        <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Gallery Angkatan {{ $user->graduation_year }}</h2>
                    <a href="{{ route('gallery.index') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat Semua</a>
                </div>
                @if($latestAlbums->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($latestAlbums as $album)
                        <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden">
                            @if($album->cover_image)
                                <img src="{{ Storage::url($album->cover_image) }}" alt="{{ $album->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-2 bg-black bg-opacity-50 text-white">
                                <p class="text-xs truncate">{{ $album->title }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Belum ada album untuk angkatan Anda.</p>
                @endif
            </div>
        </div>

        <!-- Latest Program Kerja Updates -->
        <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Update Program Kerja</h2>
                        <p class="text-sm text-gray-500">Progress kegiatan terkini</p>
                    </div>
                    <a href="{{ route('programs.index') }}" class="text-sm text-blue-600 hover:text-blue-700 hover:underline">Lihat Semua</a>
                </div>
                @if($latestPrograms->count() > 0)
                    <div class="space-y-6">
                        @foreach($latestPrograms as $program)
                        <div class="p-4 bg-white border border-gray-100 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $program->name }}</h3>
                                    <div class="flex items-center mt-2 text-sm text-gray-600">
                                        <i class="fas fa-sitemap mr-2"></i>
                                        {{ $program->department->name }}
                                    </div>
                                </div>
                                <span class="ml-4 px-3 py-1 text-xs font-medium rounded-full
                                    {{ $program->progress_percentage < 30 ? 'bg-red-100 text-red-800' : 
                                       ($program->progress_percentage < 70 ? 'bg-yellow-100 text-yellow-800' : 
                                        'bg-green-100 text-green-800') }}">
                                    {{ $program->progress_percentage }}% Selesai
                                </span>
                            </div>
                            <div class="relative pt-1">
                                <div class="flex mb-2 items-center justify-between">
                                    <div class="text-xs text-gray-500">Progress</div>
                                </div>
                                <div class="overflow-hidden h-2 text-xs flex rounded-full bg-gray-100">
                                    <div class="transition-all duration-500 ease-out 
                                        {{ $program->progress_percentage < 30 ? 'bg-red-500' : 
                                           ($program->progress_percentage < 70 ? 'bg-yellow-500' : 
                                            'bg-green-500') }}"
                                        style="width: {{ $program->progress_percentage }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Tidak ada update program kerja.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
