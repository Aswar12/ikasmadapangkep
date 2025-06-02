@extends('layouts.alumni')

@section('page-title', 'Pembayaran Iuran')

@section('content')
<div class="container mx-auto px-4">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Iuran Tahunan</h1>
        <p class="text-gray-600">Kelola pembayaran iuran tahunan Anda sebesar Rp 50.000 per tahun</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            <p class="font-medium">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <p class="font-medium">Error!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Unpaid Years Alert -->
    @if(count($unpaidYears) > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Anda memiliki iuran yang belum dibayar untuk tahun: 
                        <strong>{{ implode(', ', $unpaidYears) }}</strong>
                    </p>
                    <div class="mt-2">
                        <a href="{{ route('alumni.payments.create') }}" class="text-sm font-medium text-yellow-700 hover:text-yellow-600">
                            Bayar Sekarang →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="mb-6 flex flex-wrap gap-4">
        <a href="{{ route('alumni.payments.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
            <i class="fas fa-plus mr-2"></i>
            Bayar Iuran
        </a>
    </div>

    <!-- Payments Table -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Riwayat Pembayaran</h2>
        </div>

        @if($payments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kode Pembayaran
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tahun
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Bayar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $payment->payment_code }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->year }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->formatted_amount }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $payment->status_badge_class }}">
                                        {{ $payment->status_text }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->paid_at ? $payment->paid_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('alumni.payments.show', $payment) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">
                                        Detail
                                    </a>
                                    @if($payment->status === 'rejected')
                                        <span class="mx-2 text-gray-300">|</span>
                                        <a href="{{ route('alumni.payments.create', ['year' => $payment->year]) }}" 
                                           class="text-yellow-600 hover:text-yellow-900">
                                            Upload Ulang
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $payments->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-receipt text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-500 mb-4">Belum ada riwayat pembayaran</p>
                <a href="{{ route('alumni.payments.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i>
                    Mulai Bayar Iuran
                </a>
            </div>
        @endif
    </div>

    <!-- Information Card -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">
            <i class="fas fa-info-circle mr-2"></i>
            Informasi Pembayaran
        </h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li>• Iuran tahunan sebesar <strong>Rp 50.000</strong> per tahun</li>
                <li>• Pembayaran dapat dilakukan melalui transfer bank atau tunai</li>
                <li>• Upload bukti pembayaran untuk proses verifikasi</li>
                <li>• Status pembayaran akan diverifikasi oleh admin dalam 1-2 hari kerja</li>
                <li>• Pembayaran yang telah diverifikasi akan otomatis tercatat dalam sistem</li>
                <li>• Nomor rekening Ikasmada Pangkep Bank BRI: <strong>0222 01692002561</strong></li>
            </ul>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom styles for pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .pagination a, .pagination span {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        text-decoration: none;
        transition: all 0.15s;
    }
    
    .pagination a {
        background-color: #f3f4f6;
        color: #374151;
    }
    
    .pagination a:hover {
        background-color: #e5e7eb;
    }
    
    .pagination .active span {
        background-color: #4f46e5;
        color: white;
    }
    
    .pagination .disabled {
        color: #9ca3af;
        cursor: not-allowed;
    }
</style>
@endpush
