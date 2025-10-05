@extends('layouts.dashboard')

@section('page-title', 'Dashboard Departemen')

@section('navigation')
    @include('admin.menu')
@endsection

@section('content')
<div class="dashboard-container space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Departemen</h1>
            <p class="text-gray-600 mt-2">Overview dan statistik departemen organisasi</p>
        </div>
        <div class="mt-6 md:mt-0 flex space-x-4">
            <a href="{{ route('admin.departments.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-list mr-2"></i>
                Lihat Semua Departemen
            </a>
            @if(auth()->user()->canAccessAllDepartments())
            <a href="{{ route('admin.departments.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tambah Departemen
            </a>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stats-card 
            title="Total Departemen"
            :value="$stats['total_departments']"
            icon="fas fa-building"
            color="blue"
        />

        <x-stats-card 
            title="Departemen Aktif"
            :value="$stats['active_departments']"
            icon="fas fa-check-circle"
            color="green"
        />

        <x-stats-card 
            title="Ada Koordinator"
            :value="$stats['departments_with_coordinator']"
            icon="fas fa-user-tie"
            color="indigo"
        />

        <x-stats-card 
            title="Belum Ada Koordinator"
            :value="$stats['departments_without_coordinator']"
            icon="fas fa-user-slash"
            color="red"
        />
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Program Distribution Chart -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Program per Departemen</h3>
            <div class="relative h-80 w-full">
                <canvas id="programDistributionChart" style="max-height: 300px; max-width: 100%;"></canvas>
            </div>
        </div>

        <!-- Budget Analysis Chart -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Analisis Anggaran Departemen</h3>
            <div class="relative h-80 w-full">
                <canvas id="budgetAnalysisChart" style="max-height: 300px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <!-- Department Performance Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Performa Departemen</h3>
            <p class="text-gray-600 text-sm mt-1">Ringkasan program kerja dan anggaran per departemen</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Departemen
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Koordinator
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Program
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Program Aktif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Program Selesai
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Anggaran
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tingkat Penyelesaian
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($departmentPrograms as $department)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-building text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $department->name }}</div>
                                    <div class="text-sm text-gray-500">
                                        <x-status-badge :status="$department->is_active ? 'active' : 'inactive'" />
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($department->coordinator)
                                <div class="text-sm text-gray-900">{{ $department->coordinator->name }}</div>
                                <div class="text-sm text-gray-500">{{ $department->coordinator->email }}</div>
                            @else
                                <x-status-badge status="no_coordinator" />
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="font-semibold">{{ $department->total_programs }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $department->active_programs }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $department->completed_programs }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @php
                                $totalBudget = $budgetAnalysis->where('id', $department->id)->first()->total_budget ?? 0;
                            @endphp
                            <span class="font-semibold">Rp {{ number_format($totalBudget, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $completionRate = $department->total_programs > 0 
                                    ? ($department->completed_programs / $department->total_programs) * 100 
                                    : 0;
                            @endphp
                            <div class="flex items-center">
                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                    <div class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: {{ $completionRate }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600">{{ number_format($completionRate, 1) }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.departments.show', $department) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('admin.departments.edit', $department) }}" 
                               class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-building text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-500 text-lg">Belum ada departemen</p>
                                <p class="text-gray-400 text-sm">Mulai dengan menambahkan departemen pertama</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Program Kerja Terbaru</h3>
            <p class="text-gray-600 text-sm mt-1">5 program kerja yang baru ditambahkan</p>
        </div>
        
        <div class="p-6">
            @forelse($recentPrograms as $program)
            <div class="flex items-center justify-between py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-tasks text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $program->name }}</div>
                        <div class="text-sm text-gray-500">
                            {{ $program->department->name }} • 
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                {{ $program->status == 'ongoing' ? 'bg-blue-100 text-blue-800' : 
                                   ($program->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($program->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-medium text-gray-900">Rp {{ number_format($program->budget, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-500">{{ $program->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <i class="fas fa-tasks text-gray-400 text-3xl mb-4"></i>
                <p class="text-gray-500">Belum ada program kerja yang ditambahkan</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ensure Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js not loaded');
        return;
    }

    // Program Distribution Chart
    const programCtx = document.getElementById('programDistributionChart');
    if (!programCtx) {
        console.error('Program chart canvas not found');
        return;
    }

    const programData = {!! json_encode($departmentPrograms->map(function($dept) {
        return [
            'name' => $dept->name,
            'total' => $dept->total_programs ?? 0,
            'active' => $dept->active_programs ?? 0,
            'completed' => $dept->completed_programs ?? 0
        ];
    })) !!};

    new Chart(programCtx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: programData.map(d => d.name),
            datasets: [{
                label: 'Total Program',
                data: programData.map(d => d.total),
                backgroundColor: 'rgba(59, 130, 246, 0.6)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }, {
                label: 'Program Aktif',
                data: programData.map(d => d.active),
                backgroundColor: 'rgba(16, 185, 129, 0.6)',
                borderColor: 'rgb(16, 185, 129)',
                borderWidth: 1
            }, {
                label: 'Program Selesai',
                data: programData.map(d => d.completed),
                backgroundColor: 'rgba(139, 92, 246, 0.6)',
                borderColor: 'rgb(139, 92, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });

    // Budget Analysis Chart
    const budgetCtx = document.getElementById('budgetAnalysisChart');
    if (!budgetCtx) {
        console.error('Budget chart canvas not found');
        return;
    }

    const budgetData = {!! json_encode($budgetAnalysis->map(function($dept) {
        return [
            'name' => $dept->name,
            'budget' => $dept->total_budget ?? 0,
            'realization' => $dept->total_realization ?? 0
        ];
    })) !!};

    new Chart(budgetCtx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: budgetData.map(d => d.name),
            datasets: [{
                label: 'Anggaran (Rp)',
                data: budgetData.map(d => d.budget),
                backgroundColor: 'rgba(239, 68, 68, 0.6)',
                borderColor: 'rgb(239, 68, 68)',
                borderWidth: 1
            }, {
                label: 'Realisasi (Rp)',
                data: budgetData.map(d => d.realization),
                backgroundColor: 'rgba(34, 197, 94, 0.6)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection