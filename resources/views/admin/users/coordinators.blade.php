@extends('layouts.dashboard')

@section('page-title', 'Manajemen Koordinator')

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
            <ul id="userMenu" class="pl-8 mt-2 space-y-2">
                <li><a href="{{ route('admin.users.index') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Alumni</a></li>
                <li><a href="{{ route('admin.users.coordinators') }}" class="block rounded-lg px-4 py-2 text-sm text-white bg-blue-600">Koordinator</a></li>
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
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Koordinator</h1>
            <p class="mt-2 text-sm text-gray-700">Kelola koordinator angkatan dan departemen</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>
                Tambah Koordinator
            </a>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('admin.users.coordinators') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-center sm:space-x-4">
                <!-- Filter by Type -->
                <div class="sm:w-1/4">
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe Koordinator</label>
                    <select name="type" id="type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Semua Tipe</option>
                        <option value="department" {{ request('type') === 'department' ? 'selected' : '' }}>Koordinator Departemen</option>
                        <option value="angkatan" {{ request('type') === 'angkatan' ? 'selected' : '' }}>Koordinator Angkatan</option>
                    </select>
                </div>

                <!-- Search -->
                <div class="sm:flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700">Pencarian</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau angkatan..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <!-- Filter Button -->
                <div class="sm:self-end">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-search mr-2"></i>
                        Filter
                    </button>
                </div>

                <!-- Reset Button -->
                @if(request('search') || request('type'))
                <div class="sm:self-end">
                    <a href="{{ route('admin.users.coordinators') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-times mr-2"></i>
                        Reset
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Coordinators List -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Koordinator
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipe
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Angkatan/Departemen
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kontak
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($coordinators as $coordinator)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ $coordinator->profile_photo_url }}" alt="{{ $coordinator->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $coordinator->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $coordinator->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($coordinator->role === 'department_coordinator')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-building mr-1"></i>
                                    Departemen
                                </span>
                            @elseif($coordinator->angkatan)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-graduation-cap mr-1"></i>
                                    Angkatan
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-user mr-1"></i>
                                    Alumni
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($coordinator->role === 'department_coordinator')
                                @php
                                    $departments = $coordinator->coordinatedDepartments;
                                @endphp
                                @if($departments->count() > 0)
                                    @foreach($departments as $dept)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1">{{ $dept->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400 italic">Belum ada departemen</span>
                                @endif
                            @elseif($coordinator->angkatan)
                                <span class="font-semibold">{{ $coordinator->angkatan }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($coordinator->whatsapp)
                                <div class="flex items-center">
                                    <i class="fab fa-whatsapp text-green-500 mr-1"></i>
                                    {{ $coordinator->whatsapp }}
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($coordinator->status === 'approved')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Aktif
                                </span>
                            @elseif($coordinator->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.edit', $coordinator) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', $coordinator) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus koordinator ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada koordinator</h3>
                                <p class="text-gray-500 mb-4">Belum ada koordinator yang ditemukan.</p>
                                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Koordinator Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($coordinators->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $coordinators->links() }}
        </div>
        @endif
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-building text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Koordinator Departemen</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ $coordinators->where('role', 'department_coordinator')->count() }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-graduation-cap text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Koordinator Angkatan</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ $coordinators->whereNotNull('angkatan')->where('role', '!=', 'department_coordinator')->count() }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users text-2xl text-purple-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Koordinator</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $coordinators->total() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
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
        <a href="{{ route('admin.users.coordinators') }}" class="flex flex-col items-center py-2 text-blue-600">
            <i class="fas fa-user-tie text-xl"></i>
            <span class="text-xs mt-1">Koordinator</span>
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
