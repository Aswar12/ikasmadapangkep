@extends('layouts.dashboard')

@section('page-title', $title ?? 'Admin')

@include('admin.menu')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[400px]">
    <div class="text-center">
        <i class="fas fa-hard-hat text-6xl text-gray-400 mb-4"></i>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $title ?? 'Halaman' }} Dalam Pengembangan</h2>
        <p class="text-gray-600 mb-6">Fitur ini sedang dalam tahap pengembangan dan akan segera tersedia.</p>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Dashboard
        </a>
    </div>
</div>

<!-- Mobile Bottom Navigation -->
<div class="fixed bottom-0 left-0 right-0 bg-white border-t md:hidden z-50">
    <div class="grid grid-cols-5 gap-1">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center py-2 text-gray-600">
            <i class="fas fa-home text-xl"></i>
            <span class="text-xs mt-1">Dashboard</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center py-2 text-gray-600">
            <i class="fas fa-users text-xl"></i>
            <span class="text-xs mt-1">Alumni</span>
        </a>
        <a href="{{ route('admin.program-kerja.index') }}" class="flex flex-col items-center py-2 text-gray-600">
            <i class="fas fa-tasks text-xl"></i>
            <span class="text-xs mt-1">Program</span>
        </a>
        <a href="{{ route('admin.finance.index') }}" class="flex flex-col items-center py-2 text-gray-600">
            <i class="fas fa-coins text-xl"></i>
            <span class="text-xs mt-1">Keuangan</span>
        </a>
        <a href="{{ route('admin.settings.index') }}" class="flex flex-col items-center py-2 text-gray-600">
            <i class="fas fa-cog text-xl"></i>
            <span class="text-xs mt-1">Settings</span>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle dropdown menu
    function toggleDropdown(menuId) {
        const menu = document.getElementById(menuId);
        const allMenus = document.querySelectorAll('[id$="Menu"]');
        
        allMenus.forEach(m => {
            if (m.id !== menuId) {
                m.classList.add('hidden');
            }
        });
        
        menu.classList.toggle('hidden');
    }
    
    // Add padding to bottom on mobile to account for bottom navigation
    if (window.innerWidth < 768) {
        document.querySelector('main').style.paddingBottom = '4rem';
    }
</script>
@endpush
