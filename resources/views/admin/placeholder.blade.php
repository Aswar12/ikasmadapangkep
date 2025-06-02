@extends('layouts.dashboard')

@section('page-title', $title ?? 'Admin')

@section('navigation')
<!-- Sidebar Navigation -->
<ul class="space-y-2 tracking-wide">
    <!-- Dashboard -->
    <li>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <!-- Manajemen Pengguna -->
    <li>
        <div class="relative">
            <button onclick="toggleDropdown('userMenu')" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 w-full">
                <i class="fas fa-users"></i>
                <span>Manajemen Pengguna</span>
                <i class="fas fa-chevron-down ml-auto text-xs"></i>
            </button>
            <ul id="userMenu" class="hidden pl-8 mt-2 space-y-2">
                <li><a href="{{ route('admin.users.index') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Alumni</a></li>
                <li><a href="{{ route('admin.users.coordinators') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Koordinator</a></li>
                <li><a href="{{ route('admin.users.departments') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Departemen</a></li>
            </ul>
        </div>
    </li>
    
    <!-- Departemen & Program Kerja -->
    <li>
        <div class="relative">
            <button onclick="toggleDropdown('deptMenu')" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 w-full">
                <i class="fas fa-building"></i>
                <span>Departemen</span>
                <i class="fas fa-chevron-down ml-auto text-xs"></i>
            </button>
            <ul id="deptMenu" class="hidden pl-8 mt-2 space-y-2">
                <li><a href="{{ route('admin.departments.index') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Kelola Departemen</a></li>
                <li><a href="{{ route('admin.program-kerja.index') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Program Kerja</a></li>
            </ul>
        </div>
    </li>
    
    <!-- Event & Lowongan -->
    <li>
        <div class="relative">
            <button onclick="toggleDropdown('eventMenu')" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 w-full">
                <i class="fas fa-calendar-alt"></i>
                <span>Event & Lowongan</span>
                <i class="fas fa-chevron-down ml-auto text-xs"></i>
            </button>
            <ul id="eventMenu" class="hidden pl-8 mt-2 space-y-2">
                <li><a href="{{ route('admin.events.index') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Kelola Event</a></li>
                <li><a href="{{ route('admin.jobs.index') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Lowongan Kerja</a></li>
            </ul>
        </div>
    </li>
    
    <!-- Keuangan -->
    <li>
        <div class="relative">
            <button onclick="toggleDropdown('financeMenu')" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 w-full">
                <i class="fas fa-coins"></i>
                <span>Keuangan</span>
                <i class="fas fa-chevron-down ml-auto text-xs"></i>
            </button>
            <ul id="financeMenu" class="hidden pl-8 mt-2 space-y-2">
                <li><a href="{{ route('admin.finance.dues') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Iuran Alumni</a></li>
                <li><a href="{{ route('admin.finance.cashflow') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Arus Kas</a></li>
                <li><a href="{{ route('admin.finance.reports') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Laporan</a></li>
            </ul>
        </div>
    </li>
    
    <!-- Gallery -->
    <li>
        <a href="{{ route('admin.gallery.index') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-images"></i>
            <span>Gallery</span>
        </a>
    </li>
    
    <!-- Laporan & Analitik -->
    <li>
        <a href="{{ route('admin.reports.index') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan & Analitik</span>
        </a>
    </li>
    
    <!-- Pengaturan -->
    <li>
        <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
        </a>
    </li>
</ul>
@endsection

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
