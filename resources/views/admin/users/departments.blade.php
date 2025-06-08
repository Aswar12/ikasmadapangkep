@extends('layouts.dashboard')

@section('page-title', 'Manajemen Departemen')

@section('navigation')
<!-- Sidebar Navigation -->
<ul class="space-y-3 tracking-wide">
    <!-- Dashboard -->
    <li>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100">
            <i class="fas fa-home text-lg w-6"></i>
            <span class="text-base font-medium">Dashboard</span>
        </a>
    </li>
    
    <!-- Manajemen Pengguna -->
    <li>
        <div class="relative">
            <button onclick="toggleDropdown('userMenu')" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100 w-full">
                <i class="fas fa-users text-lg w-6"></i>
                <span class="text-base font-medium">Manajemen Pengguna</span>
                <i class="fas fa-chevron-down ml-auto text-xs"></i>
            </button>
            <ul id="userMenu" class="pl-10 mt-2 space-y-3">
                <li><a href="{{ route('admin.users.index') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700 hover:bg-gray-100">Alumni</a></li>
                <li><a href="{{ route('admin.users.coordinators') }}" class="block rounded-lg px-5 py-2 text-sm text-gray-700 hover:bg-gray-100">Koordinator</a></li>
                <li><a href="{{ route('admin.users.departments') }}" class="block rounded-lg px-5 py-2 text-sm text-white bg-blue-600">Departemen</a></li>
            </ul>
        </div>
    </li>
    
    <!-- Departemen & Program Kerja -->
    <li>
        <div class="relative">
            <button onclick="toggleDropdown('deptMenu')" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100 w-full">
                <i class="fas fa-building text-lg w-6"></i>
                <span class="text-base font-medium">Departemen</span>
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
                <span class="text-base font-medium">Event & Lowongan</span>
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
                <span class="text-base font-medium">Keuangan</span>
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
            <span class="text-base font-medium">Gallery</span>
        </a>
    </li>
    
    <!-- Laporan & Analitik -->
    <li>
        <a href="{{ route('admin.reports.index') }}" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100">
            <i class="fas fa-chart-bar text-lg w-6"></i>
            <span class="text-base font-medium">Laporan & Analitik</span>
        </a>
    </li>
    
    <!-- Pengaturan -->
    <li>
        <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-4 rounded-xl px-5 py-3 text-gray-700 hover:bg-gray-100">
            <i class="fas fa-cog text-lg w-6"></i>
            <span class="text-base font-medium">Pengaturan</span>
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Departemen</h1>
            <p class="mt-2 text-sm text-gray-700">Kelola departemen dan koordinator departemen</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>
                Tambah Departemen
            </button>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('admin.users.departments') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-center sm:space-x-4">
                <!-- Search -->
                <div class="sm:flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700">Pencarian</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama departemen atau koordinator..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <!-- Search Button -->
                <div class="sm:self-end">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>
                </div>

                <!-- Reset Button -->
                @if(request('search'))
                <div class="sm:self-end">
                    <a href="{{ route('admin.users.departments') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-times mr-2"></i>
                        Reset
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Departments List -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Departemen
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Koordinator
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kontak Koordinator
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
                    @forelse($departments as $department)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-building text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $department->name }}</div>
                                    @if($department->description)
                                        <div class="text-sm text-gray-500">{{ Str::limit($department->description, 50) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($department->coordinator)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full" src="{{ $department->coordinator->profile_photo_url }}" alt="{{ $department->coordinator->name }}">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $department->coordinator->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $department->coordinator->email }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Belum ada koordinator
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($department->coordinator && $department->coordinator->whatsapp)
                                <div class="flex items-center">
                                    <i class="fab fa-whatsapp text-green-500 mr-1"></i>
                                    {{ $department->coordinator->whatsapp }}
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($department->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-pause-circle mr-1"></i>
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button onclick="openEditModal({{ $department->id }}, '{{ $department->name }}', '{{ $department->description }}', {{ $department->coordinator_id ?? 'null' }}, {{ $department->is_active ? 'true' : 'false' }})" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="openAssignModal({{ $department->id }}, '{{ $department->name }}', {{ $department->coordinator_id ?? 'null' }})" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-user-plus"></i>
                                </button>
                                <button onclick="deleteDepartment({{ $department->id }}, '{{ $department->name }}')" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-building text-4xl text-gray-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada departemen</h3>
                                <p class="text-gray-500 mb-4">Belum ada departemen yang ditemukan.</p>
                                <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Departemen Pertama
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($departments->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $departments->links() }}
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Departemen</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $departments->total() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Departemen Aktif</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ $departments->where('is_active', true)->count() }}
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
                        <i class="fas fa-user-tie text-2xl text-purple-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Memiliki Koordinator</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ $departments->whereNotNull('coordinator_id')->count() }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Department Modal -->
<div id="departmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Tambah Departemen</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="departmentForm" method="POST">
                @csrf
                <div id="methodField"></div>
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Departemen</label>
                    <input type="text" name="name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                </div>

                <div class="mb-4">
                    <label for="coordinator_id" class="block text-sm font-medium text-gray-700">Koordinator</label>
                    <select name="coordinator_id" id="coordinator_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Pilih Koordinator</option>
                        @foreach($availableCoordinators as $coordinator)
                            <option value="{{ $coordinator->id }}">{{ $coordinator->name }} ({{ $coordinator->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Aktif</span>
                    </label>
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assign Coordinator Modal -->
<div id="assignModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Assign Koordinator</h3>
                <button onclick="closeAssignModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="assignForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Departemen</label>
                    <p id="assignDepartmentName" class="mt-1 text-sm text-gray-900 font-semibold"></p>
                </div>

                <div class="mb-6">
                    <label for="assign_coordinator_id" class="block text-sm font-medium text-gray-700">Pilih Koordinator</label>
                    <select name="coordinator_id" id="assign_coordinator_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Pilih Koordinator</option>
                        @foreach($availableCoordinators as $coordinator)
                            <option value="{{ $coordinator->id }}">{{ $coordinator->name }} ({{ $coordinator->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeAssignModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">
                        Assign
                    </button>
                </div>
            </form>
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
        <a href="{{ route('admin.users.departments') }}" class="flex flex-col items-center py-2 text-blue-600">
            <i class="fas fa-building text-xl"></i>
            <span class="text-xs mt-1">Departemen</span>
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

    // Modal functions
    function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Tambah Departemen';
        document.getElementById('departmentForm').action = '{{ route("admin.departments.store") }}';
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('name').value = '';
        document.getElementById('description').value = '';
        document.getElementById('coordinator_id').value = '';
        document.getElementById('is_active').checked = true;
        document.getElementById('departmentModal').classList.remove('hidden');
    }

    function openEditModal(id, name, description, coordinatorId, isActive) {
        document.getElementById('modalTitle').textContent = 'Edit Departemen';
        document.getElementById('departmentForm').action = `/admin/departments/${id}`;
        document.getElementById('methodField').innerHTML = '@method("PUT")';
        document.getElementById('name').value = name;
        document.getElementById('description').value = description || '';
        document.getElementById('coordinator_id').value = coordinatorId || '';
        document.getElementById('is_active').checked = isActive;
        document.getElementById('departmentModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('departmentModal').classList.add('hidden');
    }

    function openAssignModal(departmentId, departmentName, currentCoordinatorId) {
        document.getElementById('assignDepartmentName').textContent = departmentName;
        document.getElementById('assignForm').action = `/admin/departments/${departmentId}/assign-coordinator`;
        document.getElementById('assign_coordinator_id').value = currentCoordinatorId || '';
        document.getElementById('assignModal').classList.remove('hidden');
    }

    function closeAssignModal() {
        document.getElementById('assignModal').classList.add('hidden');
    }

    function deleteDepartment(id, name) {
        if (confirm(`Apakah Anda yakin ingin menghapus departemen "${name}"?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/departments/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Close modals when clicking outside
    document.getElementById('departmentModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    document.getElementById('assignModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAssignModal();
        }
    });
</script>
@endpush
