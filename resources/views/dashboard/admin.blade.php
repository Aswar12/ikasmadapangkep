@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('navigation')
    @include('admin.menu')
@endsection

@section('content')
<div class="dashboard-container space-y-8">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h1>
                <p class="text-blue-100 text-lg">Pantau dan kelola sistem IKA SMADA PANGKEP dengan mudah</p>
            </div>
            <div class="mt-6 md:mt-0">
                <div class="flex items-center space-x-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ date('d M Y') }}</div>
                        <div class="text-blue-200 text-sm">Hari ini</div>
                    </div>
                    <div class="w-px h-12 bg-blue-400"></div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ date('H:i') }}</div>
                        <div class="text-blue-200 text-sm">Waktu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Widget -->
    @include('admin.widgets.quick-actions')

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Alumni -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium uppercase tracking-wide">Total Alumni</p>
                    <h3 class="text-3xl font-bold mt-2">{{ number_format($stats['total_alumni']) }}</h3>
                    <p class="text-emerald-200 text-xs mt-1">+12% dari bulan lalu</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Alumni Aktif -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Alumni Aktif</p>
                    <h3 class="text-3xl font-bold mt-2">{{ number_format($stats['alumni_aktif']) }}</h3>
                    <p class="text-blue-200 text-xs mt-1">85% tingkat aktivitas</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-user-check text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Approval -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium uppercase tracking-wide">Menunggu Approval</p>
                    <h3 class="text-3xl font-bold mt-2">{{ number_format($stats['pending_approvals']) }}</h3>
                    <p class="text-amber-200 text-xs mt-1">Perlu diperiksa</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Program Kerja Aktif -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium uppercase tracking-wide">Program Kerja Aktif</p>
                    <h3 class="text-3xl font-bold mt-2">{{ number_format($stats['program_kerja_aktif']) }}</h3>
                    <p class="text-purple-200 text-xs mt-1">Sedang berjalan</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-tasks text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Departemen -->
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium uppercase tracking-wide">Total Departemen</p>
                    <h3 class="text-3xl font-bold mt-2">{{ number_format($stats['total_departments']) }}</h3>
                    <p class="text-indigo-200 text-xs mt-1">Unit organisasi</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-building text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Event -->
        <div class="bg-gradient-to-br from-red-500 to-pink-500 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium uppercase tracking-wide">Total Event</p>
                    <h3 class="text-3xl font-bold mt-2">{{ number_format($stats['total_events']) }}</h3>
                    <p class="text-red-200 text-xs mt-1">Acara yang diselenggarakan</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Department Management Hub -->
    @include('admin.widgets.department-hub')

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Charts and Quick Actions -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Charts Section -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <!-- Alumni by Year Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Alumni Berdasarkan Tahun Kelulusan</h3>
                        <div class="bg-blue-50 rounded-full p-2">
                            <i class="fas fa-chart-bar text-blue-600"></i>
                        </div>
                    </div>
                    <div class="chart-container h-80">
                        <canvas id="alumniByYearChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Alumni by Job Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Alumni Berdasarkan Pekerjaan</h3>
                        <div class="bg-purple-50 rounded-full p-2">
                            <i class="fas fa-chart-pie text-purple-600"></i>
                        </div>
                    </div>
                    <div class="chart-container h-80">
                        <canvas id="alumniByJobChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Department Statistics -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Statistik Departemen</h3>
                    <a href="{{ route('admin.departments.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Lihat Semua
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="dashboard-table min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departemen</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Program</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Program Aktif</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($departmentStats as $dept)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 rounded-full p-2 mr-3">
                                            <i class="fas fa-building text-blue-600"></i>
                                        </div>
                                        <div class="font-medium text-gray-900">{{ $dept->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        {{ $dept->program_kerja_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        {{ $dept->active_programs_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('admin.departments.show', $dept->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-600 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Quick Actions</h3>
                    <div class="bg-gray-100 rounded-full p-2">
                        <i class="fas fa-bolt text-gray-600"></i>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.users.create') }}" class="group quick-action-card flex flex-col items-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg border border-blue-200">
                        <div class="bg-blue-500 rounded-full p-3 mb-3 group-hover:bg-blue-600 transition-colors duration-300">
                            <i class="fas fa-user-plus text-white text-xl"></i>
                        </div>
                        <span class="text-sm text-gray-700 font-semibold group-hover:text-blue-800 transition-colors duration-300">Tambah Alumni</span>
                    </a>
                    <a href="{{ route('admin.events.create') }}" class="group quick-action-card flex flex-col items-center p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg border border-green-200">
                        <div class="bg-green-500 rounded-full p-3 mb-3 group-hover:bg-green-600 transition-colors duration-300">
                            <i class="fas fa-calendar-plus text-white text-xl"></i>
                        </div>
                        <span class="text-sm text-gray-700 font-semibold group-hover:text-green-800 transition-colors duration-300">Buat Event</span>
                    </a>
                    <a href="{{ route('admin.program-kerja.create') }}" class="group quick-action-card flex flex-col items-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg border border-purple-200">
                        <div class="bg-purple-500 rounded-full p-3 mb-3 group-hover:bg-purple-600 transition-colors duration-300">
                            <i class="fas fa-clipboard-list text-white text-xl"></i>
                        </div>
                        <span class="text-sm text-gray-700 font-semibold group-hover:text-purple-800 transition-colors duration-300">Program Kerja</span>
                    </a>
                    <a href="{{ route('admin.departments.create') }}" class="group quick-action-card flex flex-col items-center p-6 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl hover:from-indigo-100 hover:to-indigo-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg border border-indigo-200">
                        <div class="bg-indigo-500 rounded-full p-3 mb-3 group-hover:bg-indigo-600 transition-colors duration-300">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                        <span class="text-sm text-gray-700 font-semibold group-hover:text-indigo-800 transition-colors duration-300">Tambah Departemen</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column - Pending Approvals and Recent Activity -->
        <div class="space-y-8">
            <!-- Pending Approvals -->
            @if($pendingApprovals->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Pending Approvals</h3>
                    <a href="{{ route('admin.users.pending') }}" class="inline-flex items-center px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Lihat Semua
                    </a>
                </div>
                <div class="space-y-4">
                    @foreach($pendingApprovals->take(5) as $pending)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg hover:from-gray-100 hover:to-gray-200 transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $pending->name }}</p>
                                <p class="text-xs text-gray-600">{{ $pending->email }}</p>
                                <p class="text-xs text-blue-600 font-medium">Angkatan {{ $pending->angkatan }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <form action="{{ route('admin.users.approve', $pending->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                                    <i class="fas fa-check mr-1"></i>
                                    Setuju
                                </button>
                            </form>
                            <form action="{{ route('admin.users.reject', $pending->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                                    <i class="fas fa-times mr-1"></i>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h3>
                    <div class="bg-green-50 rounded-full p-2">
                        <i class="fas fa-history text-green-600"></i>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user-plus text-white text-sm"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900">Alumni baru bergabung</p>
                            <p class="text-xs text-gray-500">2 jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar-plus text-white text-sm"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900">Event baru dibuat</p>
                            <p class="text-xs text-gray-500">5 jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-tasks text-white text-sm"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900">Program kerja disetujui</p>
                            <p class="text-xs text-gray-500">1 hari yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Status Sistem</h3>
                    <div class="bg-blue-50 rounded-full p-2">
                        <i class="fas fa-server text-blue-600"></i>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Database</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                            <i class="fas fa-circle text-green-500 mr-2"></i>
                            Online
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Storage</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                            <i class="fas fa-circle text-green-500 mr-2"></i>
                            OK
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Email Service</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                            <i class="fas fa-circle text-yellow-500 mr-2"></i>
                            Maintenance
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts for Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Alumni by Year Chart
const alumniByYearCtx = document.getElementById('alumniByYearChart').getContext('2d');
const alumniByYearData = @json($alumniByYear ?? collect());
const alumniByYearLabels = alumniByYearData.map(item => item.graduation_year);
const alumniByYearValues = alumniByYearData.map(item => item.total);

new Chart(alumniByYearCtx, {
    type: 'bar',
    data: {
        labels: alumniByYearLabels,
        datasets: [{
            label: 'Jumlah Alumni',
            data: alumniByYearValues,
            backgroundColor: 'rgba(59, 130, 246, 0.8)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
            hoverBackgroundColor: 'rgba(59, 130, 246, 0.9)',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#ffffff',
                bodyColor: '#ffffff',
                cornerRadius: 8,
                displayColors: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)',
                    borderDash: [5, 5]
                },
                ticks: {
                    color: '#6b7280',
                    font: {
                        size: 12,
                        weight: '500'
                    }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#6b7280',
                    font: {
                        size: 12,
                        weight: '500'
                    }
                }
            }
        },
        animation: {
            duration: 2000,
            easing: 'easeInOutQuart'
        }
    }
});

// Alumni by Job Chart
const alumniByJobCtx = document.getElementById('alumniByJobChart').getContext('2d');
const alumniByJobData = @json($alumniByJob ?? collect());
const alumniByJobLabels = alumniByJobData.map(item => item.current_job);
const alumniByJobValues = alumniByJobData.map(item => item.total);

new Chart(alumniByJobCtx, {
    type: 'doughnut',
    data: {
        labels: alumniByJobLabels,
        datasets: [{
            data: alumniByJobValues,
            backgroundColor: [
                'rgba(59, 130, 246, 0.9)',
                'rgba(16, 185, 129, 0.9)',
                'rgba(245, 158, 11, 0.9)',
                'rgba(139, 69, 19, 0.9)',
                'rgba(168, 85, 247, 0.9)',
                'rgba(239, 68, 68, 0.9)',
                'rgba(236, 72, 153, 0.9)',
                'rgba(14, 165, 233, 0.9)'
            ],
            borderWidth: 3,
            borderColor: '#ffffff',
            hoverBorderWidth: 4,
            hoverBorderColor: '#ffffff',
            hoverOffset: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                    font: {
                        size: 12,
                        weight: '500'
                    },
                    color: '#6b7280'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#ffffff',
                bodyColor: '#ffffff',
                cornerRadius: 8
            }
        },
        animation: {
            animateRotate: true,
            animateScale: true,
            duration: 2000,
            easing: 'easeInOutQuart'
        }
    }
});
</script>
@endsection
