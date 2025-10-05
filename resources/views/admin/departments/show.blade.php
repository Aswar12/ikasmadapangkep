@extends('layouts.dashboard')

@section('page-title', 'Detail Departemen - ' . $department->name)

@section('navigation')
    @include('admin.menu')
@endsection

@section('content')
<div class="dashboard-container space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <div class="flex items-center space-x-4 mb-2">
                <a href="{{ route('admin.departments.dashboard') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-800">{{ $department->name }}</h1>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    {{ $department->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $department->is_active ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>
            @if($department->description)
                <p class="text-gray-600 mt-2">{{ $department->description }}</p>
            @endif
        </div>
        <div class="mt-6 md:mt-0 flex space-x-4">
            <a href="{{ route('admin.departments.edit', $department) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Edit Departemen
            </a>
        </div>
    </div>

    <!-- Department Info & Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Department Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Departemen</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Koordinator</label>
                        @if($department->coordinator)
                            <div class="flex items-center mt-2">
                                <img src="{{ $department->coordinator->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($department->coordinator->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                     alt="{{ $department->coordinator->name }}" 
                                     class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $department->coordinator->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $department->coordinator->email }}</div>
                                </div>
                            </div>
                            <button onclick="removeCoordinator({{ $department->id }})" 
                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                <i class="fas fa-times mr-1"></i>Hapus Koordinator
                            </button>
                        @else
                            <div class="mt-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    Belum Ada Koordinator
                                </span>
                                <button onclick="showAssignCoordinatorModal()" 
                                        class="block mt-2 text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-plus mr-1"></i>Tugaskan Koordinator
                                </button>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Status</label>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $department->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $department->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Dibuat</label>
                        <div class="mt-2 text-sm text-gray-900">
                            {{ $department->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Terakhir Diupdate</label>
                        <div class="mt-2 text-sm text-gray-900">
                            {{ $department->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Program</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_programs'] }}</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-tasks text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Program Aktif</p>
                            <p class="text-3xl font-bold text-green-600">{{ $stats['active_programs'] }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-play text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Program Selesai</p>
                            <p class="text-3xl font-bold text-indigo-600">{{ $stats['completed_programs'] }}</p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <i class="fas fa-check text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Anggaran</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_budget'], 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <i class="fas fa-money-bill text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Realisasi</p>
                            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['total_realization'], 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-chart-line text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Utilisasi Anggaran</p>
                            <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['budget_utilization'], 1) }}%</p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: {{ min($stats['budget_utilization'], 100) }}%"></div>
                            </div>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <i class="fas fa-percentage text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    @if($programsByStatus->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Program Status Chart -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Status Program</h3>
            <canvas id="statusChart" height="300"></canvas>
        </div>

        <!-- Monthly Budget Chart -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Alokasi Anggaran Bulanan</h3>
            <canvas id="monthlyBudgetChart" height="300"></canvas>
        </div>
    </div>
    @endif

    <!-- Programs List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Program Kerja</h3>
                <p class="text-gray-600 text-sm mt-1">Daftar semua program kerja departemen ini</p>
            </div>
            <a href="{{ route('admin.program-kerja.create') }}?department_id={{ $department->id }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tambah Program
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Program
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Periode
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Anggaran
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Progress
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($department->programKerja as $program)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $program->name }}</div>
                                @if($program->description)
                                    <div class="text-sm text-gray-500">{{ Str::limit($program->description, 50) }}</div>
                                @endif
                                @if($program->location)
                                    <div class="text-xs text-gray-400 mt-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $program->location }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $program->start_date->format('d M Y') }}
                            </div>
                            @if($program->end_date)
                                <div class="text-sm text-gray-500">
                                    s/d {{ $program->end_date->format('d M Y') }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                Rp {{ number_format($program->budget, 0, ',', '.') }}
                            </div>
                            @if($program->realization > 0)
                                <div class="text-sm text-gray-500">
                                    Real: Rp {{ number_format($program->realization, 0, ',', '.') }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $program->status == 'ongoing' ? 'bg-blue-100 text-blue-800' : 
                                   ($program->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($program->status == 'planning' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($program->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $program->progress }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600">{{ $program->progress }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.program-kerja.show', $program) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.program-kerja.edit', $program) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-tasks text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-500 text-lg">Belum ada program kerja</p>
                                <p class="text-gray-400 text-sm mb-4">Departemen ini belum memiliki program kerja</p>
                                <a href="{{ route('admin.program-kerja.create') }}?department_id={{ $department->id }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Program Pertama
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

<!-- Assign Coordinator Modal -->
<div id="assignCoordinatorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tugaskan Koordinator</h3>
            <form id="assignCoordinatorForm" method="POST" action="{{ route('admin.departments.assign-coordinator', $department) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="coordinator_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Koordinator
                    </label>
                    <select name="coordinator_id" id="coordinator_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih koordinator...</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideAssignCoordinatorModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Tugaskan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($programsByStatus->count() > 0)
    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = @json($programsByStatus);
    
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData).map(status => status.charAt(0).toUpperCase() + status.slice(1)),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',   // blue for ongoing
                    'rgba(16, 185, 129, 0.8)',   // green for completed
                    'rgba(245, 158, 11, 0.8)',   // yellow for planning
                    'rgba(239, 68, 68, 0.8)',    // red for cancelled
                    'rgba(156, 163, 175, 0.8)'   // gray for others
                ],
                borderColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)',
                    'rgb(239, 68, 68)',
                    'rgb(156, 163, 175)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Monthly Budget Chart
    const monthlyCtx = document.getElementById('monthlyBudgetChart').getContext('2d');
    const monthlyData = @json($monthlyBudget);
    
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: Object.keys(monthlyData),
            datasets: [{
                label: 'Anggaran',
                data: Object.values(monthlyData).map(d => d.budget),
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.1
            }, {
                label: 'Realisasi',
                data: Object.values(monthlyData).map(d => d.realization),
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
    @endif
});

function showAssignCoordinatorModal() {
    // Load available coordinators
    fetch('{{ route("admin.departments.available-coordinators") }}')
        .then(response => response.json())
        .then(coordinators => {
            const select = document.getElementById('coordinator_id');
            select.innerHTML = '<option value="">Pilih koordinator...</option>';
            coordinators.forEach(coordinator => {
                select.innerHTML += `<option value="${coordinator.id}">${coordinator.name} (${coordinator.email})</option>`;
            });
        });
    
    document.getElementById('assignCoordinatorModal').classList.remove('hidden');
}

function hideAssignCoordinatorModal() {
    document.getElementById('assignCoordinatorModal').classList.add('hidden');
}

function removeCoordinator(departmentId) {
    if (confirm('Apakah Anda yakin ingin menghapus koordinator dari departemen ini?')) {
        fetch(`{{ route('admin.departments.remove-coordinator', '') }}/${departmentId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                _method: 'DELETE'
            })
        }).then(() => {
            location.reload();
        });
    }
}
</script>
@endpush
@endsection