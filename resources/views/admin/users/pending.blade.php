@extends('layouts.admin')

@section('page-title', 'Pengguna Pending')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Pengguna Pending</h1>
        <p class="text-gray-600 mt-2">Kelola pengguna yang menunggu persetujuan</p>
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

    <!-- Bulk Actions -->
    <div class="mb-4 flex items-center space-x-4">
        <select id="bulkAction" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Pilih Aksi Massal</option>
            <option value="approve">Setujui Terpilih</option>
            <option value="reject">Tolak Terpilih</option>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Angkatan</th>
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
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->angkatan ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button type="button" onclick="approveUser({{ $user->id }})" class="text-green-600 hover:text-green-900 mr-3">
                                <i class="fas fa-check-circle"></i> Setujui
                            </button>
                            <button type="button" onclick="rejectUser({{ $user->id }})" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-times-circle"></i> Tolak
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada pengguna yang menunggu persetujuan
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

<!-- Forms for individual actions -->
<form id="approveForm" method="POST" style="display: none;">
    @csrf
</form>

<form id="rejectForm" method="POST" style="display: none;">
    @csrf
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
        }

        if (!confirm(confirmMessage)) {
            return;
        }

        const form = document.getElementById('usersForm');
        form.action = formAction;
        form.submit();
    });

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
</script>
@endpush
@endsection
