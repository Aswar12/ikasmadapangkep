@extends('layouts.dashboard')

@section('page-title', 'Dashboard Admin')

@section('navigation')
<!-- Sidebar Navigation -->
<ul class="space-y-3 tracking-wide">
    <!-- Dashboard -->
    <li>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-white bg-gradient-to-r from-blue-600 to-blue-400">
            <i class="fas fa-home text-lg w-6"></i>
            <span class="text-base font-semibold truncate max-w-[120px]">Dashboard</span>
        </a>
    </li>
    
    <!-- Manajemen Pengguna -->
    <li>
        <div class="relative">
            <button onclick="toggleDropdown('userMenu')" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100 w-full">
                <i class="fas fa-users text-lg w-6"></i>
                <span class="text-base font-semibold truncate max-w-[120px]">Pengguna</span>
                <i class="fas fa-chevron-down ml-auto text-xs"></i>
            </button>
            <ul id="userMenu" class="hidden pl-10 mt-2 space-y-3">
                <li><a href="{{ route('admin.users.index') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700 hover:bg-gray-100">Alumni</a></li>
                <li><a href="{{ route('admin.users.coordinators') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700 hover:bg-gray-100">Koordinator</a></li>
                <li><a href="{{ route('admin.users.departments') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700">Departemen</a></li>
            </ul>
        </div>
    </li>
    
    <!-- Departemen & Program Kerja -->
    <li>
        <div class="relative">
            <button onclick="toggleDropdown('deptMenu')" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100 w-full">
                <i class="fas fa-building text-lg w-6"></i>
                <span class="text-base font-semibold truncate max-w-[120px]">Departemen</span>
                <i class="fas fa-chevron-down ml-auto text-xs"></i>
            </button>
            <ul id="deptMenu" class="hidden pl-10 mt-2 space-y-3">
                <li><a href="{{ route('admin.departments.index') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelola Departemen</a></li>
                <li><a href="{{ route('admin.program-kerja.index') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700 hover:bg-gray-100">Program Kerja</a></li>
            </ul>
        </div>
    </li>
    
    <!-- Event & Lowongan -->
    <li>
        <div class="relative">
            <button onclick="toggleDropdown('eventMenu')" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100 w-full">
                <i class="fas fa-calendar-alt text-lg w-6"></i>
                <span class="text-base font-semibold truncate max-w-[120px]">Event & Lowongan</span>
                <i class="fas fa-chevron-down ml-auto text-xs"></i>
            </button>
            <ul id="eventMenu" class="hidden pl-10 mt-2 space-y-3">
                <li><a href="{{ route('admin.events.index') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelola Event</a></li>
                <li><a href="{{ route('admin.jobs.index') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700 hover:bg-gray-100">Lowongan Kerja</a></li>
            </ul>
        </div>
    </li>
    
    <!-- Keuangan -->
    <li>
        <div class="relative">
            <button onclick="toggleDropdown('financeMenu')" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100 w-full">
                <i class="fas fa-coins text-lg w-6"></i>
                <span class="text-base font-semibold truncate max-w-[120px]">Keuangan</span>
                <i class="fas fa-chevron-down ml-auto text-xs"></i>
            </button>
            <ul id="financeMenu" class="hidden pl-10 mt-2 space-y-3">
                <li><a href="{{ route('admin.finance.dues') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700 hover:bg-gray-100">Iuran Alumni</a></li>
                <li><a href="{{ route('admin.finance.cashflow') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700 hover:bg-gray-100">Arus Kas</a></li>
                <li><a href="{{ route('admin.finance.reports') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700 hover:bg-gray-100">Laporan</a></li>
            </ul>
        </div>
    </li>
    
    <!-- Gallery -->
    <li>
        <a href="{{ route('admin.gallery.index') }}" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100">
            <i class="fas fa-images text-lg w-6"></i>
            <span class="text-base font-semibold truncate max-w-[120px]">Gallery</span>
        </a>
    </li>
    
    <!-- Laporan & Analitik -->
    <li>
        <a href="{{ route('admin.reports.index') }}" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100">
            <i class="fas fa-chart-bar text-lg w-6"></i>
            <span class="text-base font-semibold truncate max-w-[120px]">Laporan & Analitik</span>
        </a>
    </li>
    
    <!-- Pengaturan -->
    <li>
        <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100">
            <i class="fas fa-cog text-lg w-6"></i>
            <span class="text-base font-semibold truncate max-w-[120px]">Pengaturan</span>
        </a>
    </li>
</ul>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
    <!-- Total Alumni -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-semibold">Total Alumni</p>
                <h3 class="text-3xl font-bold mt-1">{{ number_format($stats['total_alumni']) }}</h3>
            </div>
            <div class="bg-white/20 rounded-full w-12 h-12 flex items-center justify-center p-2 transition duration-300 hover:bg-white/30">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Alumni Aktif -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-semibold">Alumni Aktif</p>
                <h3 class="text-3xl font-bold mt-1">{{ number_format($stats['alumni_aktif']) }}</h3>
            </div>
            <div class="bg-white/20 rounded-full w-12 h-12 flex items-center justify-center p-2 transition duration-300 hover:bg-white/30">
                <i class="fas fa-user-check text-xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Pending Approval -->
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-semibold">Pending Approval</p>
                <h3 class="text-3xl font-bold mt-1">{{ number_format($stats['alumni_pending']) }}</h3>
            </div>
            <div class="bg-white/20 rounded-full w-12 h-12 flex items-center justify-center p-2 transition duration-300 hover:bg-white/30">
                <i class="fas fa-clock text-xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Program Kerja Aktif -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-semibold">Program Kerja Aktif</p>
                <h3 class="text-3xl font-bold mt-1">{{ number_format($stats['program_kerja_aktif']) }}</h3>
            </div>
            <div class="bg-white/20 rounded-full w-12 h-12 flex items-center justify-center p-2 transition duration-300 hover:bg-white/30">
                <i class="fas fa-tasks text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Departemen -->
    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl p-6 text-white shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-indigo-100 text-sm font-semibold">Total Departemen</p>
                <h3 class="text-3xl font-bold mt-1">{{ number_format($stats['total_departments']) }}</h3>
            </div>
            <div class="bg-white/20 rounded-full w-12 h-12 flex items-center justify-center p-2 transition duration-300 hover:bg-white/30">
                <i class="fas fa-building text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Event -->
    <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl p-6 text-white shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-sm font-semibold">Total Event</p>
                <h3 class="text-3xl font-bold mt-1">{{ number_format($stats['total_events']) }}</h3>
            </div>
            <div class="bg-white/20 rounded-full w-12 h-12 flex items-center justify-center p-2 transition duration-300 hover:bg-white/30">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Pending Approvals -->
@if($pendingApprovals->count() > 0)
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Pending Approvals</h2>
        <a href="{{ route('admin.users.pending') }}" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Semua</a>
    </div>
    <div class="space-y-3">
        @foreach($pendingApprovals->take(5) as $pending)
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-gray-600"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">{{ $pending->name }}</p>
                    <p class="text-sm text-gray-500">{{ $pending->email }} • Angkatan {{ $pending->angkatan }}</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <form action="{{ route('admin.users.approve', $pending->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700">
                        <i class="fas fa-check mr-1"></i> Approve
                    </button>
                </form>
                <form action="{{ route('admin.users.reject', $pending->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                        <i class="fas fa-times mr-1"></i> Reject
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Alumni by Year Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Alumni Berdasarkan Tahun Kelulusan</h2>
<canvas id="alumniByYearChart" class="w-full" style="height: 300px; max-height: 300px;"></canvas>
    </div>
    
    <!-- Alumni by Job Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Alumni Berdasarkan Pekerjaan</h2>
<canvas id="alumniByJobChart" class="w-full" style="height: 300px; max-height: 300px;"></canvas>
    </div>
</div>

<!-- Department Statistics -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistik Departemen</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Departemen</th>
                    <th class="text-center py-3 px-4 text-sm font-medium text-gray-700">Total Program</th>
                    <th class="text-center py-3 px-4 text-sm font-medium text-gray-700">Program Aktif</th>
                    <th class="text-center py-3 px-4 text-sm font-medium text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departmentStats as $dept)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">
                        <p class="font-medium text-gray-900">{{ $dept->name }}</p>
                    </td>
                    <td class="text-center py-3 px-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $dept->program_kerja_count }}
                        </span>
                    </td>
                    <td class="text-center py-3 px-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $dept->active_programs_count }}
                        </span>
                    </td>
                    <td class="text-center py-3 px-4">
                        <a href="{{ route('admin.departments.show', $dept->id) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-user-plus text-2xl text-blue-600 mb-2"></i>
            <span class="text-sm text-gray-700">Tambah Alumni</span>
        </a>
        <a href="{{ route('admin.events.create') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-calendar-plus text-2xl text-green-600 mb-2"></i>
            <span class="text-sm text-gray-700">Buat Event</span>
        </a>
        <a href="{{ route('admin.program-kerja.create') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-clipboard-list text-2xl text-purple-600 mb-2"></i>
            <span class="text-sm text-gray-700">Program Kerja</span>
        </a>
        <a href="{{ route('admin.reports.export') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
            <i class="fas fa-download text-2xl text-yellow-600 mb-2"></i>
            <span class="text-sm text-gray-700">Export Data</span>
        </a>
    </div>
</div>

<!-- Mobile Bottom Navigation -->
<div class="fixed bottom-0 left-0 right-0 bg-white border-t md:hidden z-50">
    <div class="grid grid-cols-5 gap-1">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center py-2 text-blue-600">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    // Alumni by Year Chart
    const alumniByYearCtx = document.getElementById('alumniByYearChart').getContext('2d');
    new Chart(alumniByYearCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($alumniByYear->pluck('graduation_year')) !!},
            datasets: [{
                label: 'Jumlah Alumni',
                data: {!! json_encode($alumniByYear->pluck('total')) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Alumni by Job Chart
    const alumniByJobCtx = document.getElementById('alumniByJobChart').getContext('2d');
    new Chart(alumniByJobCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($alumniByJob->pluck('current_job')) !!},
            datasets: [{
                data: {!! json_encode($alumniByJob->pluck('total')) !!},
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });

    // Add padding to bottom on mobile to account for bottom navigation
    if (window.innerWidth < 768) {
        document.querySelector('main').style.paddingBottom = '4rem';
    }
</script>
@endpush
