@extends('layouts.dashboard')

@section('page-title', 'Dashboard Program Kerja')

@section('navigation')
    @include('admin.menu')
@endsection

@section('content')
<div class="dashboard-container space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Program Kerja</h1>
            <p class="text-gray-600 mt-2">Monitoring dan tracking progress program kerja departemen</p>
        </div>
        <div class="mt-6 md:mt-0 flex space-x-4">
            <!-- Department Filter -->
            <select id="departmentFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Departemen</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->nama }}
                    </option>
                @endforeach
            </select>
            
            <a href="{{ route('admin.program-kerja.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tambah Program Kerja
            </a>
        </div>
    </div>

    <!-- Statistics Cards Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Program</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $statistics['total_program'] }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-tasks text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rata-rata Progress</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($statistics['avg_progress'], 1) }}%</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-percentage text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Budget</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($statistics['total_budget']) }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-money-bill-wave text-2xl text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Budget Terpakai</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ $statistics['total_budget'] > 0 ? number_format(($statistics['used_budget']/$statistics['total_budget'])*100, 1) : 0 }}%
                    </p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-chart-pie text-2xl text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Statistics Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Planning</p>
                    <p class="text-3xl font-bold">{{ $statistics['planning'] }}</p>
                </div>
                <i class="fas fa-clipboard-list text-2xl text-blue-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm">In Progress</p>
                    <p class="text-3xl font-bold">{{ $statistics['ongoing'] }}</p>
                </div>
                <i class="fas fa-cogs text-2xl text-yellow-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Completed</p>
                    <p class="text-3xl font-bold">{{ $statistics['completed'] }}</p>
                </div>
                <i class="fas fa-check-circle text-2xl text-green-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm">Delayed</p>
                    <p class="text-3xl font-bold">{{ $statistics['delayed'] }}</p>
                </div>
                <i class="fas fa-exclamation-triangle text-2xl text-red-200"></i>
            </div>
        </div>
    </div>

    <!-- Charts and Quick Actions Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Progress Distribution Chart -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Distribusi Progress Program Kerja</h3>
                <div class="flex space-x-2">
                    <button id="chartTypeDoughnut" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg">Doughnut</button>
                    <button id="chartTypeBar" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg">Bar</button>
                </div>
            </div>
            <div class="relative h-80">
                <canvas id="progressChart"></canvas>
            </div>
        </div>

        <!-- Quick Actions Panel -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>
            <div class="space-y-4">
                <a href="{{ route('admin.program-kerja.create') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                    <div class="p-2 bg-blue-500 text-white rounded-lg group-hover:bg-blue-600 transition-colors">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">Tambah Program Kerja</p>
                        <p class="text-sm text-gray-600">Buat program kerja baru</p>
                    </div>
                </a>

                <a href="{{ route('admin.program-kerja.index') }}" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                    <div class="p-2 bg-green-500 text-white rounded-lg group-hover:bg-green-600 transition-colors">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">Kelola Program</p>
                        <p class="text-sm text-gray-600">Update status & progress</p>
                    </div>
                </a>

                <a href="#" onclick="exportReport()" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                    <div class="p-2 bg-purple-500 text-white rounded-lg group-hover:bg-purple-600 transition-colors">
                        <i class="fas fa-download"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">Export Laporan</p>
                        <p class="text-sm text-gray-600">Download laporan PDF</p>
                    </div>
                </a>

                <a href="{{ route('admin.departments.dashboard') }}" class="flex items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors group">
                    <div class="p-2 bg-yellow-500 text-white rounded-lg group-hover:bg-yellow-600 transition-colors">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">Dashboard Departemen</p>
                        <p class="text-sm text-gray-600">Lihat overview departemen</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Program Kerja Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Program Kerja Terbaru</h3>
                <a href="{{ route('admin.program-kerja.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departemen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($programKerjaData as $program)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium text-gray-900">{{ Str::limit($program->nama_program, 40) }}</p>
                                <p class="text-sm text-gray-600">{{ $program->penanggungJawab->name ?? 'Belum ditentukan' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $program->department->nama }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full transition-all duration-500" 
                                         style="width: {{ $program->progress_percentage }}%"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $program->progress_percentage }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'planning' => 'bg-gray-100 text-gray-800',
                                    'ongoing' => 'bg-yellow-100 text-yellow-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'delayed' => 'bg-red-100 text-red-800',
                                    'cancelled' => 'bg-orange-100 text-orange-800'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$program->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($program->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $program->deadline ? $program->deadline->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.program-kerja.show', $program->id) }}" class="text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.program-kerja.edit', $program->id) }}" class="text-green-600 hover:text-green-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-tasks text-4xl text-gray-300 mb-4"></i>
                                <p>Belum ada program kerja</p>
                                <a href="{{ route('admin.program-kerja.create') }}" class="mt-2 text-blue-600 hover:text-blue-700">
                                    Tambah program kerja pertama →
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart Data
const chartData = @json($chartData);
let currentChart = null;

// Initialize Chart
function initChart(type = 'doughnut') {
    const ctx = document.getElementById('progressChart').getContext('2d');
    
    if (currentChart) {
        currentChart.destroy();
    }
    
    const config = {
        type: type,
        data: {
            labels: chartData.progress_distribution.map(item => item.range_progress),
            datasets: [{
                data: chartData.progress_distribution.map(item => item.count),
                backgroundColor: [
                    '#ef4444', // red - belum dimulai
                    '#f97316', // orange - 1-25%
                    '#eab308', // yellow - 26-50%
                    '#3b82f6', // blue - 51-75%
                    '#10b981', // green - 76-99%
                    '#059669'  // dark green - selesai
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: type === 'doughnut' ? 'bottom' : 'right'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return `${context.label}: ${context.parsed} (${percentage}%)`;
                        }
                    }
                }
            },
            ...(type === 'bar' && {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            })
        }
    };
    
    currentChart = new Chart(ctx, config);
}

// Initialize chart on page load
document.addEventListener('DOMContentLoaded', function() {
    initChart('doughnut');
    
    // Chart type switchers
    document.getElementById('chartTypeDoughnut').addEventListener('click', function() {
        initChart('doughnut');
        this.classList.add('bg-blue-100', 'text-blue-700');
        this.classList.remove('bg-gray-100', 'text-gray-700');
        document.getElementById('chartTypeBar').classList.add('bg-gray-100', 'text-gray-700');
        document.getElementById('chartTypeBar').classList.remove('bg-blue-100', 'text-blue-700');
    });
    
    document.getElementById('chartTypeBar').addEventListener('click', function() {
        initChart('bar');
        this.classList.add('bg-blue-100', 'text-blue-700');
        this.classList.remove('bg-gray-100', 'text-gray-700');
        document.getElementById('chartTypeDoughnut').classList.add('bg-gray-100', 'text-gray-700');
        document.getElementById('chartTypeDoughnut').classList.remove('bg-blue-100', 'text-blue-700');
    });
});

// Department Filter
document.getElementById('departmentFilter').addEventListener('change', function() {
    const departmentId = this.value;
    const currentUrl = new URL(window.location);
    
    if (departmentId) {
        currentUrl.searchParams.set('department_id', departmentId);
    } else {
        currentUrl.searchParams.delete('department_id');
    }
    
    window.location.href = currentUrl.href;
});

// Export Report Function
function exportReport() {
    const departmentId = document.getElementById('departmentFilter').value;
    let exportUrl = '{{ route("admin.reports.program-kerja") }}';
    
    if (departmentId) {
        exportUrl += `?department_id=${departmentId}`;
    }
    
    window.open(exportUrl, '_blank');
}
</script>
@endpush
@endsection