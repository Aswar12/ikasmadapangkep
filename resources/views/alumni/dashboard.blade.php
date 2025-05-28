@extends('layouts.alumni')

@section('page-title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/alumni/dashboard.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <!-- Welcome Section -->
    @include('alumni.partials.welcome-section')

    <!-- Stats Cards -->
    @include('alumni.partials.stats-cards')

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Left Column - Profile Completion -->
        <div class="lg:col-span-1">
            @include('alumni.partials.profile-completion')
        </div>

        <!-- Right Column - Recent Events -->
        <div class="lg:col-span-2">
            @include('alumni.partials.recent-events')
        </div>
    </div>

    <!-- Second Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Payment Status -->
        <div>
            @include('alumni.partials.payment-status')
        </div>

        <!-- Job Vacancies -->
        <div>
            @include('alumni.partials.job-vacancies')
        </div>
    </div>

    <!-- Quick Actions -->
    @include('alumni.partials.quick-actions')

    <!-- Additional Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- News & Announcements -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
            <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-newspaper text-indigo-500 mr-2"></i>
                Berita Terbaru
            </h5>
            <div class="space-y-3">
                <div class="pb-3 border-b border-gray-100">
                    <h6 class="text-sm font-semibold text-gray-700 mb-1">Reuni Akbar 2025</h6>
                    <p class="text-xs text-gray-500">Persiapan reuni akbar telah dimulai...</p>
                    <span class="text-xs text-indigo-600">2 hari yang lalu</span>
                </div>
                <div class="pb-3 border-b border-gray-100">
                    <h6 class="text-sm font-semibold text-gray-700 mb-1">Program Beasiswa</h6>
                    <p class="text-xs text-gray-500">IKA SMADA membuka program beasiswa...</p>
                    <span class="text-xs text-indigo-600">5 hari yang lalu</span>
                </div>
            </div>
            <a href="{{ route('alumni.news') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium mt-4 inline-flex items-center">
                Lihat semua berita
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>

        <!-- Birthday Reminders -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
            <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-birthday-cake text-pink-500 mr-2"></i>
                Ulang Tahun Bulan Ini
            </h5>
            <div class="space-y-3">
                @if(isset($birthdays) && count($birthdays) > 0)
                    @foreach($birthdays->take(3) as $birthday)
                    <div class="flex items-center space-x-3">
                        <img src="{{ $birthday->profile_photo_url }}" alt="{{ $birthday->name }}" 
                             class="w-10 h-10 rounded-full border-2 border-pink-200">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">{{ $birthday->name }}</p>
                            <p class="text-xs text-gray-500">{{ $birthday->birth_date->format('d F') }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada ulang tahun bulan ini</p>
                @endif
            </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
            <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-share-alt text-blue-500 mr-2"></i>
                Ikuti Kami
            </h5>
            <div class="space-y-3">
                <a href="#" class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fab fa-facebook text-blue-600 text-xl"></i>
                    <span class="text-sm font-medium text-gray-700">Facebook</span>
                </a>
                <a href="#" class="flex items-center space-x-3 p-3 bg-pink-50 rounded-lg hover:bg-pink-100 transition-colors">
                    <i class="fab fa-instagram text-pink-600 text-xl"></i>
                    <span class="text-sm font-medium text-gray-700">Instagram</span>
                </a>
                <a href="#" class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                    <span class="text-sm font-medium text-gray-700">WhatsApp Group</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Add any dashboard-specific JavaScript here
    document.addEventListener('DOMContentLoaded', function() {
        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.hover-lift').forEach(el => {
            observer.observe(el);
        });

        // Initialize tooltips
        const tooltips = document.querySelectorAll('[data-tooltip]');
        tooltips.forEach(tooltip => {
            // Tooltip functionality is handled by CSS
        });

        // Counter animation for stats
        const animateValue = (element, start, end, duration) => {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                element.innerHTML = Math.floor(progress * (end - start) + start).toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        };

        // Animate stat numbers
        const statNumbers = document.querySelectorAll('.stat-number');
        statNumbers.forEach(stat => {
            const value = parseInt(stat.getAttribute('data-value'));
            if (value) {
                animateValue(stat, 0, value, 1000);
            }
        });
    });
</script>
@endpush
