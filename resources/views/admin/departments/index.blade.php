@extends('layouts.dashboard')

@section('page-title', 'Manajemen Departemen')

@section('navigation')
    @include('admin.menu')
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 p-3 rounded-xl">
                        <i class="fas fa-building text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Manajemen Departemen</h1>
                        <p class="text-gray-600 mt-1">Kelola departemen dan koordinator organisasi IKA SMADA Pangkep</p>
                    </div>
                </div>
                <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.departments.dashboard') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Dashboard
                    </a>
                    @if(auth()->user()->canAccessAllDepartments())
                    <a href="{{ route('admin.departments.create') }}" 
                       class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Departemen
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
                <div class="flex items-center">
                    <div class="bg-green-100 p-2 rounded-full mr-3">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-green-800 font-medium">Berhasil!</p>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
                <div class="flex items-center">
                    <div class="bg-red-100 p-2 rounded-full mr-3">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-red-800 font-medium">Error!</p>
                        <p class="text-red-700 text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics Summary Card -->
        @if($departments->count() > 0)
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Ringkasan Departemen</h3>
                <div class="bg-blue-100 p-2 rounded-lg">
                    <i class="fas fa-chart-bar text-blue-600"></i>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <div class="text-2xl font-bold text-blue-600 mb-1">{{ $departments->count() }}</div>
                    <div class="text-sm text-gray-600">Total Departemen</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <div class="text-2xl font-bold text-green-600 mb-1">{{ $departments->where('is_active', true)->count() }}</div>
                    <div class="text-sm text-gray-600">Departemen Aktif</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <div class="text-2xl font-bold text-purple-600 mb-1">{{ $departments->where('coordinator_id', '!=', null)->count() }}</div>
                    <div class="text-sm text-gray-600">Dengan Koordinator</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                    <div class="text-2xl font-bold text-indigo-600 mb-1">{{ $departments->sum(function($dept) { return $dept->programKerja->count(); }) }}</div>
                    <div class="text-sm text-gray-600">Total Program</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Departments Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($departments as $department)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 overflow-hidden group">
                <!-- Department Header -->
                <div class="p-6 pb-4">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-br from-blue-100 to-blue-200 p-3 rounded-xl group-hover:from-blue-200 group-hover:to-blue-300 transition-all duration-300">
                                <i class="fas fa-building text-blue-600 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $department->name }}</h3>
                                <x-status-badge :status="$department->is_active ? 'active' : 'inactive'" size="sm" />
                            </div>
                        </div>
                    </div>

                    <!-- Department Description -->
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                        {{ $department->description ?? 'Tidak ada deskripsi departemen.' }}
                    </p>
                </div>

                <!-- Coordinator Section -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            @if($department->coordinator)
                                <img src="{{ $department->coordinator->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($department->coordinator->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                     alt="{{ $department->coordinator->name }}" 
                                     class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                                <div>
                                    <p class="text-xs text-gray-500">Koordinator</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $department->coordinator->name }}</p>
                                </div>
                            @else
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Koordinator</p>
                                    <p class="text-sm text-gray-400 italic">Belum ditentukan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Department Stats -->
                <div class="px-6 py-4 bg-white">
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="bg-blue-50 rounded-lg p-3">
                            <div class="text-lg font-bold text-blue-600">{{ $department->programKerja->where('status', 'ongoing')->count() }}</div>
                            <div class="text-xs text-blue-700">Aktif</div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-3">
                            <div class="text-lg font-bold text-green-600">{{ $department->programKerja->where('status', 'completed')->count() }}</div>
                            <div class="text-xs text-green-700">Selesai</div>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-3">
                            <div class="text-lg font-bold text-purple-600">{{ $department->programKerja->count() }}</div>
                            <div class="text-xs text-purple-700">Total</div>
                        </div>
                    </div>
                    
                    @if($department->programKerja->count() > 0)
                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Total Anggaran:</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($department->programKerja->sum('budget'), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @else
                        <div class="mt-4 p-3 bg-yellow-50 rounded-lg text-center">
                            <p class="text-xs text-yellow-700">Belum ada program kerja</p>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex space-x-2">
                    <a href="{{ route('admin.departments.show', $department->id) }}"
                       class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-white hover:bg-gray-100 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-all duration-200">
                        <i class="fas fa-eye mr-2"></i>
                        Detail
                    </a>
                    @if(auth()->user()->canManageDepartment($department->id))
                    <a href="{{ route('admin.departments.edit', $department->id) }}"
                       class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    @endif
                    @if(auth()->user()->canAccessAllDepartments())
                    <button onclick="deleteDepartment({{ $department->id }}, '{{ $department->name }}')"
                            class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-trash"></i>
                    </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-16 text-center">
                    <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-building text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Belum ada departemen</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Mulai kelola organisasi IKA dengan menambahkan departemen pertama untuk menjalankan program kerja.</p>
                    @if(auth()->user()->canAccessAllDepartments())
                    <a href="{{ route('admin.departments.create') }}" 
                       class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Departemen Pertama
                    </a>
                    @else
                    <p class="text-gray-500 text-sm">Hubungi administrator untuk menambahkan departemen.</p>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
        <div class="mt-3 text-center">
            <div class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus departemen <span id="departmentName" class="font-semibold"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-center space-x-3">
                <button onclick="hideDeleteModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                    Batal
                </button>
                <form id="deleteForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                        Hapus Departemen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
@endsection
