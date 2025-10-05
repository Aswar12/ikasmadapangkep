@extends('layouts.dashboard')

@section('page-title', 'Manajemen Pembayaran')

@section('navigation')
    @include('admin.menu')
@endsection

@section('content')
<div class="dashboard-container space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Pembayaran</h1>
            <p class="text-gray-600 mt-2">Kelola pembayaran iuran alumni dan verifikasi</p>
        </div>
        <div class="mt-6 md:mt-0 flex space-x-4">
            <!-- Status Filter -->
            <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Sudah Diverifikasi</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            
            <!-- Year Filter -->
            <select id="yearFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Tahun</option>
                @for($year = 2020; $year <= date('Y') + 1; $year++)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
            
            <a href="{{ route('admin.reports.finance') }}" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-chart-line mr-2"></i>
                Laporan Keuangan
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pembayaran</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $statistics['total_payments'] }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-money-bill-wave text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $statistics['pending_payments'] }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg">
                    <i class="fas fa-clock text-2xl text-orange-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sudah Diverifikasi</p>
                    <p class="text-3xl font-bold text-green-600">{{ $statistics['verified_payments'] }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Nominal</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($statistics['total_amount']) }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-coins text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    @if($payments->where('status', 'pending')->count() > 0)
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Aksi Massal</h3>
            <div class="flex space-x-3">
                <button onclick="selectAll()" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    Pilih Semua
                </button>
                <button onclick="bulkApprove()" class="px-4 py-2 text-sm bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-check mr-1"></i>
                    Setujui Terpilih
                </button>
                <button onclick="bulkReject()" class="px-4 py-2 text-sm bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-times mr-1"></i>
                    Tolak Terpilih
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Payments Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Pembayaran</h3>
                <div class="flex items-center space-x-4">
                    <input type="text" id="searchPayments" placeholder="Cari pembayaran..." 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="{{ request('search') }}">
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAllCheckbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alumni</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Bayar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50" data-payment-id="{{ $payment->id }}">
                        <td class="px-6 py-4">
                            @if($payment->status === 'pending')
                                <input type="checkbox" class="payment-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                                       value="{{ $payment->id }}">
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium text-gray-900">{{ $payment->payment_code }}</p>
                                <p class="text-sm text-gray-600">{{ $payment->payment_method }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-sm font-medium text-blue-800">
                                            {{ substr($payment->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="font-medium text-gray-900">{{ $payment->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $payment->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $payment->year }}</td>
                        <td class="px-6 py-4">
                            <span class="text-lg font-semibold text-gray-900">Rp {{ number_format($payment->amount) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'verified' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800'
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu Verifikasi',
                                    'verified' => 'Sudah Diverifikasi',
                                    'rejected' => 'Ditolak'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$payment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$payment->status] ?? ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $payment->paid_at ? $payment->paid_at->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex space-x-2">
                                <button onclick="viewPayment({{ $payment->id }})" 
                                        class="text-blue-600 hover:text-blue-700" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                @if($payment->payment_proof)
                                    <button onclick="viewProof('{{ Storage::url($payment->payment_proof) }}')" 
                                            class="text-green-600 hover:text-green-700" title="Lihat Bukti">
                                        <i class="fas fa-image"></i>
                                    </button>
                                @endif
                                
                                @if($payment->status === 'pending')
                                    <button onclick="approvePayment({{ $payment->id }})" 
                                            class="text-green-600 hover:text-green-700" title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button onclick="rejectPayment({{ $payment->id }})" 
                                            class="text-red-600 hover:text-red-700" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-money-bill-wave text-4xl text-gray-300 mb-4"></i>
                                <p>Belum ada pembayaran</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($payments->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $payments->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Payment Detail Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Detail Pembayaran</h3>
                <button onclick="closeModal('paymentModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="paymentModalContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Proof Image Modal -->
<div id="proofModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Bukti Pembayaran</h3>
                <button onclick="closeModal('proofModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="text-center">
                <img id="proofImage" src="" alt="Bukti Pembayaran" class="max-w-full h-auto rounded-lg">
            </div>
        </div>
    </div>
</div>

<!-- Reject Reason Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Alasan Penolakan</h3>
                <button onclick="closeModal('rejectModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="rejectForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                    <textarea id="rejectionReason" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" 
                              placeholder="Masukkan alasan penolakan..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('rejectModal')" 
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        Tolak Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentRejectPaymentId = null;

// Filter Functions
document.getElementById('statusFilter').addEventListener('change', function() {
    updateFilters();
});

document.getElementById('yearFilter').addEventListener('change', function() {
    updateFilters();
});

document.getElementById('searchPayments').addEventListener('input', debounce(function() {
    updateFilters();
}, 300));

function updateFilters() {
    const status = document.getElementById('statusFilter').value;
    const year = document.getElementById('yearFilter').value;
    const search = document.getElementById('searchPayments').value;
    
    const url = new URL(window.location);
    
    if (status) url.searchParams.set('status', status);
    else url.searchParams.delete('status');
    
    if (year) url.searchParams.set('year', year);
    else url.searchParams.delete('year');
    
    if (search) url.searchParams.set('search', search);
    else url.searchParams.delete('search');
    
    window.location.href = url.href;
}

// Checkbox Functions
function selectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.payment-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

document.getElementById('selectAllCheckbox').addEventListener('change', selectAll);

// Payment Actions
function viewPayment(paymentId) {
    fetch(`/admin/payments/${paymentId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('paymentModalContent').innerHTML = data.html;
            document.getElementById('paymentModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat detail pembayaran');
        });
}

function viewProof(imageUrl) {
    document.getElementById('proofImage').src = imageUrl;
    document.getElementById('proofModal').classList.remove('hidden');
}

function approvePayment(paymentId) {
    if (confirm('Yakin ingin menyetujui pembayaran ini?')) {
        fetch(`/admin/payments/${paymentId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Gagal menyetujui pembayaran');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

function rejectPayment(paymentId) {
    currentRejectPaymentId = paymentId;
    document.getElementById('rejectModal').classList.remove('hidden');
}

document.getElementById('rejectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const reason = document.getElementById('rejectionReason').value;
    if (!reason.trim()) {
        alert('Alasan penolakan harus diisi');
        return;
    }
    
    fetch(`/admin/payments/${currentRejectPaymentId}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            rejection_reason: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Gagal menolak pembayaran');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
});

// Bulk Actions
function bulkApprove() {
    const selectedPayments = Array.from(document.querySelectorAll('.payment-checkbox:checked')).map(cb => cb.value);
    
    if (selectedPayments.length === 0) {
        alert('Pilih pembayaran yang ingin disetujui');
        return;
    }
    
    if (confirm(`Yakin ingin menyetujui ${selectedPayments.length} pembayaran?`)) {
        fetch('/admin/payments/bulk-approve', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                payment_ids: selectedPayments
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Gagal melakukan aksi massal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

function bulkReject() {
    const selectedPayments = Array.from(document.querySelectorAll('.payment-checkbox:checked')).map(cb => cb.value);
    
    if (selectedPayments.length === 0) {
        alert('Pilih pembayaran yang ingin ditolak');
        return;
    }
    
    const reason = prompt('Masukkan alasan penolakan:');
    if (!reason) return;
    
    if (confirm(`Yakin ingin menolak ${selectedPayments.length} pembayaran?`)) {
        fetch('/admin/payments/bulk-reject', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                payment_ids: selectedPayments,
                rejection_reason: reason
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Gagal melakukan aksi massal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

// Helper Functions
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    currentRejectPaymentId = null;
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

// Close modals when clicking outside
window.onclick = function(event) {
    const modals = ['paymentModal', 'proofModal', 'rejectModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            closeModal(modalId);
        }
    });
}
</script>
@endpush
@endsection