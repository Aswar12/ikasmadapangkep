@extends('layouts.admin')

@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="container mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Pengguna</h1>
            <p class="text-gray-600 mt-2">Kelola semua pengguna dalam sistem</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Pengguna
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filter and Search -->
    <div class="mb-6 flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" placeholder="Cari pengguna..." class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Peran</option>
            <option value="admin">Admin</option>
            <option value="sub_admin">Sub Admin</option>
            <option value="department_coordinator">Koordinator Departemen</option>
            <option value="alumni">Alumni</option>
        </select>
        <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Status</option>
            <option value="approved">Approved</option>
            <option value="pending">Pending</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>

    <!-- Bulk Actions -->
    <div class="mb-4 flex items-center space-x-4">
        <select id="bulkAction" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Pilih Aksi Massal</option>
            <option value="approve">Approve Terpilih</option>
            <option value="reject">Reject Terpilih</option>
            <option value="change_role">Ubah Peran Terpilih</option>
            <option value="send_email">Kirim Email Massal</option>
            <option value="delete">Hapus Pengguna Terpilih</option>
        </select>
        <button id="applyBulkAction" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-check-circle mr-2"></i>Terapkan
        </button>
    </div>

    <!-- Users Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <form id="usersForm" method="POST" action="">
            @csrf
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="userCheckbox rounded border-gray-300">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url ?? asset('images/default-avatar.png') }}" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    @if($user->angkatan)
                                        <div class="text-sm text-gray-500">Angkatan {{ $user->angkatan }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $roleColors = [
                                    'admin' => 'bg-purple-100 text-purple-800',
                                    'sub_admin' => 'bg-blue-100 text-blue-800',
                                    'department_coordinator' => 'bg-green-100 text-green-800',
                                    'alumni' => 'bg-gray-100 text-gray-800'
                                ];
                                $roleNames = [
                                    'admin' => 'Admin',
                                    'sub_admin' => 'Sub Admin',
                                    'department_coordinator' => 'Koordinator Dept',
                                    'alumni' => 'Alumni'
                                ];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $roleNames[$user->role] ?? $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'approved' => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'rejected' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$user->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($user->status ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->status === 'pending')
                                    <button type="button" onclick="approveUser({{ $user->id }})" class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" onclick="rejectUser({{ $user->id }})" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                                <button type="button" onclick="deleteUser({{ $user->id }})" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada pengguna ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
    </div>

    <!-- Pagination -->
    @if ($users->hasPages())
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Role Change Modal -->
<div id="roleModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Ubah Peran Pengguna</h3>
            <div class="mt-2 px-7 py-3">
                <select id="newRole" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Peran Baru</option>
                    <option value="admin">Admin</option>
                    <option value="sub_admin">Sub Admin</option>
                    <option value="department_coordinator">Koordinator Departemen</option>
                    <option value="alumni">Alumni</option>
                </select>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmRoleChange" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Ubah Peran
                </button>
                <button onclick="closeRoleModal()" class="mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Forms for individual actions -->
<form id="approveForm" method="POST" style="display: none;">
    @csrf
</form>

<form id="rejectForm" method="POST" style="display: none;">
    @csrf
</form>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    // Select all checkboxes
    document.getElementById('selectAll').addEventListener('change', function() {
        const checked = this.checked;
        document.querySelectorAll('.userCheckbox').forEach(cb => cb.checked = checked);
    });

    // Apply bulk action
    document.getElementById('applyBulkAction').addEventListener('click', function() {
        const action = document.getElementById('bulkAction').value;
        if (!action) {
            alert('Silakan pilih aksi massal terlebih dahulu.');
            return;
        }

        const selectedIds = Array.from(document.querySelectorAll('.userCheckbox:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) {
            alert('Silakan pilih minimal satu pengguna.');
            return;
        }

        if (action === 'change_role') {
            document.getElementById('roleModal').classList.remove('hidden');
            return;
        }

        let confirmMessage = '';
        let formAction = '';
        
        switch(action) {
            case 'approve':
                confirmMessage = 'Apakah Anda yakin ingin menyetujui pengguna terpilih?';
                formAction = '{{ route("admin.users.bulkApprove") }}';
                break;
            case 'reject':
                confirmMessage = 'Apakah Anda yakin ingin menolak pengguna terpilih?';
                formAction = '{{ route("admin.users.bulkReject") }}';
                break;
            case 'send_email':
                confirmMessage = 'Apakah Anda yakin ingin mengirim email massal ke pengguna terpilih?';
                formAction = '{{ route("admin.users.bulkSendEmail") }}';
                break;
            case 'delete':
                confirmMessage = 'Apakah Anda yakin ingin menghapus pengguna terpilih? Tindakan ini tidak dapat dibatalkan.';
                formAction = '{{ route("admin.users.bulkDelete") }}';
                break;
        }

        if (!confirm(confirmMessage)) {
            return;
        }

        const form = document.getElementById('usersForm');
        form.action = formAction;
        form.submit();
    });

    // Role change confirmation
    document.getElementById('confirmRoleChange').addEventListener('click', function() {
        const newRole = document.getElementById('newRole').value;
        if (!newRole) {
            alert('Silakan pilih peran baru.');
            return;
        }

        const form = document.getElementById('usersForm');
        form.action = '{{ route("admin.users.bulkChangeRole") }}';
        
        // Add new role input
        const roleInput = document.createElement('input');
        roleInput.type = 'hidden';
        roleInput.name = 'new_role';
        roleInput.value = newRole;
        form.appendChild(roleInput);
        
        form.submit();
    });

    function closeRoleModal() {
        document.getElementById('roleModal').classList.add('hidden');
    }

    // Approve individual user
    function approveUser(userId) {
        if (confirm('Apakah Anda yakin ingin menyetujui pengguna ini?')) {
            const form = document.getElementById('approveForm');
            form.action = `/admin/users/${userId}/approve`;
            form.submit();
        }
    }

    // Reject individual user
    function rejectUser(userId) {
        if (confirm('Apakah Anda yakin ingin menolak pengguna ini?')) {
            const form = document.getElementById('rejectForm');
            form.action = `/admin/users/${userId}/reject`;
            form.submit();
        }
    }

    // Delete individual user
    function deleteUser(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/users/${userId}`;
            form.submit();
        }
    }
</script>
@endpush
@endsection
