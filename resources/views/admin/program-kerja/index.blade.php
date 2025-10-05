@extends('layouts.dashboard')

@section('page-title', 'Daftar Program Kerja')

@section('navigation')
    @include('admin.menu')
@endsection

@section('content')
<div class="dashboard-container space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Program Kerja</h1>
            <p class="text-gray-600 mt-2">Kelola dan monitor semua program kerja departemen</p>
        </div>
        <div class="mt-6 md:mt-0 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
            <!-- Filter Departemen -->
            <select id="departmentFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Departemen</option>
                @if(isset($departments))
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->nama }}
                        </option>
                    @endforeach
                @endif
            </select>
            
            <!-- Filter Status -->
            <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="planning" {{ request('status') == 'planning' ? 'selected' : '' }}>Planning</option>
                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="delayed" {{ request('status') == 'delayed' ? 'selected' : '' }}>Delayed</option>
            </select>
            
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('admin.program-kerja.dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-chart-bar mr-2"></i>
                    <span class="hidden sm:inline">Dashboard</span>
                    <span class="sm:hidden">Dashboard</span>
                </a>
                <a href="{{ route('admin.program-kerja.create') }}" class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-plus mr-3 text-lg"></i>
                    <span class="text-base">Tambah Program Kerja</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    @if(isset($statistics))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Program</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $statistics['total'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-tasks text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">In Progress</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $statistics['ongoing'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-cogs text-2xl text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Completed</p>
                    <p class="text-3xl font-bold text-green-600">{{ $statistics['completed'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rata-rata Progress</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($statistics['avg_progress'] ?? 0, 1) }}%</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-percentage text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Program Kerja Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Program Kerja</h3>
                <div class="flex items-center space-x-4">
                    <input type="text" id="searchPrograms" placeholder="Cari program kerja..." 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="{{ request('search') }}">
                </div>
            </div>
        </div>
        
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex">
                    <div class="py-1"><i class="fas fa-check-circle"></i></div>
                    <div class="ml-2">
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Program</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departemen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Mulai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PIC</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($programKerja as $key => $proker)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $key + 1 }}</td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium text-gray-900">{{ $proker->nama_program ?? $proker->name }}</p>
                                @if($proker->deskripsi)
                                    <p class="text-sm text-gray-600">{{ Str::limit($proker->deskripsi, 50) }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $proker->department->nama ?? $proker->department->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $proker->tanggal_mulai ? \Carbon\Carbon::parse($proker->tanggal_mulai)->format('d M Y') : ($proker->start_date ? $proker->start_date->format('d M Y') : 'N/A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @php
                                $deadline = $proker->deadline ?? $proker->end_date;
                                $isOverdue = $deadline && \Carbon\Carbon::parse($deadline)->isPast() && $proker->status !== 'completed';
                            @endphp
                            <span class="flex items-center">
                                {{ $deadline ? \Carbon\Carbon::parse($deadline)->format('d M Y') : 'N/A' }}
                                @if($isOverdue)
                                    <i class="fas fa-exclamation-triangle text-red-500 ml-2" title="Terlambat"></i>
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                        <span class="text-xs font-medium text-gray-700">
                                            {{ substr($proker->penanggungJawab->name ?? $proker->picUser->name ?? 'N/A', 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $proker->penanggungJawab->name ?? $proker->picUser->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'planning' => 'bg-gray-100 text-gray-800',
                                    'ongoing' => 'bg-yellow-100 text-yellow-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'delayed' => 'bg-red-100 text-red-800',
                                    'on_hold' => 'bg-orange-100 text-orange-800'
                                ];
                                $status = $proker->status ?? 'planning';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-3">
                                    @php
                                        $progress = $proker->progress_percentage ?? 0;
                                        $progressColor = $progress == 100 ? 'bg-green-500' : ($progress >= 50 ? 'bg-blue-500' : 'bg-yellow-500');
                                    @endphp
                                    <div class="{{ $progressColor }} h-2 rounded-full transition-all duration-500" 
                                         style="width: {{ $progress }}%"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $progress }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                                @if(method_exists($proker, 'getRouteKey'))
                                    <a href="{{ route('admin.program-kerja.show', $proker->getRouteKey()) }}"
                                       class="inline-flex items-center justify-center px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 hover:text-blue-700 font-medium rounded-lg transition-colors duration-200 text-sm"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye mr-2"></i>
                                        <span class="hidden sm:inline">Lihat</span>
                                    </a>
                                @endif
                                <a href="{{ route('admin.program-kerja.edit', $proker->id) }}"
                                   class="inline-flex items-center justify-center px-3 py-2 bg-green-50 hover:bg-green-100 text-green-600 hover:text-green-700 font-medium rounded-lg transition-colors duration-200 text-sm"
                                   title="Edit">
                                    <i class="fas fa-edit mr-2"></i>
                                    <span class="hidden sm:inline">Edit</span>
                                </a>
                                <form action="{{ route('admin.program-kerja.destroy', $proker->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 font-medium rounded-lg transition-colors duration-200 text-sm w-full sm:w-auto"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus program kerja ini?')"
                                            title="Hapus">
                                        <i class="fas fa-trash mr-2"></i>
                                        <span class="hidden sm:inline">Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-tasks text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium mb-2">Belum ada program kerja</p>
                                <p class="text-sm mb-4">Mulai dengan membuat program kerja pertama untuk departemen Anda</p>
                                <a href="{{ route('admin.program-kerja.create') }}"
                                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-plus mr-3"></i>
                                    <span>Tambah Program Kerja Pertama</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(method_exists($programKerja, 'hasPages') && $programKerja->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $programKerja->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Filter Functions
document.getElementById('departmentFilter').addEventListener('change', function() {
    updateFilters();
});

document.getElementById('statusFilter').addEventListener('change', function() {
    updateFilters();
});

document.getElementById('searchPrograms').addEventListener('input', debounce(function() {
    updateFilters();
}, 300));

function updateFilters() {
    const department = document.getElementById('departmentFilter').value;
    const status = document.getElementById('statusFilter').value;
    const search = document.getElementById('searchPrograms').value;
    
    const url = new URL(window.location);
    
    if (department) url.searchParams.set('department_id', department);
    else url.searchParams.delete('department_id');
    
    if (status) url.searchParams.set('status', status);
    else url.searchParams.delete('status');
    
    if (search) url.searchParams.set('search', search);
    else url.searchParams.delete('search');
    
    window.location.href = url.href;
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endpush
@endsection
