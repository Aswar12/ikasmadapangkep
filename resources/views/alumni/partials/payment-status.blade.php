<!-- Payment Status -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
    <div class="bg-gradient-to-r from-green-500 to-teal-600 text-white p-6 rounded-t-2xl">
        <h5 class="text-xl font-bold flex items-center">
            <i class="fas fa-money-check-alt mr-2"></i>
            Status Pembayaran Iuran
        </h5>
    </div>
    
    <div class="p-6">
        @if(isset($payment_info))
            <!-- Payment Info -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h6 class="font-semibold text-gray-800 mb-1">Iuran Tahun {{ date('Y') }}</h6>
                        <p class="text-gray-600">Kontribusi tahunan alumni</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-gray-800">Rp 50.000</p>
                        <p class="text-sm text-gray-500">per tahun</p>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div class="flex items-center justify-center py-3">
                    @if($payment_info->status == 'sudah_lunas')
                        <div class="bg-green-100 text-green-800 px-6 py-3 rounded-full flex items-center space-x-2">
                            <i class="fas fa-check-circle text-lg"></i>
                            <span class="font-semibold">Lunas</span>
                        </div>
                    @elseif($payment_info->status == 'menunggu_verifikasi')
                        <div class="bg-yellow-100 text-yellow-800 px-6 py-3 rounded-full flex items-center space-x-2">
                            <i class="fas fa-clock text-lg"></i>
                            <span class="font-semibold">Menunggu Verifikasi</span>
                        </div>
                    @else
                        <div class="bg-red-100 text-red-800 px-6 py-3 rounded-full flex items-center space-x-2">
                            <i class="fas fa-times-circle text-lg"></i>
                            <span class="font-semibold">Belum Bayar</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Payment History -->
            @if($payment_info->status == 'sudah_lunas')
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mt-0.5 mr-3"></i>
                        <div class="flex-grow">
                            <p class="text-sm font-semibold text-green-800">Pembayaran Berhasil</p>
                            <p class="text-xs text-green-700 mt-1">
                                Terima kasih telah melakukan pembayaran iuran tahunan.
                            </p>
                            <p class="text-xs text-green-600 mt-2">
                                Dibayar pada: {{ $payment_info->paid_at ? \Carbon\Carbon::parse($payment_info->paid_at)->format('d F Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Download Receipt Button -->
                <a href="{{ route('alumni.payments.receipt', $payment_info->id) }}" 
                   class="w-full py-3 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-download mr-2"></i>
                    Download Bukti Pembayaran
                </a>
            @else
                <!-- Payment Methods -->
                <div class="space-y-3 mb-6">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran:</p>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-university text-blue-600 mr-3"></i>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">Transfer Bank</p>
                                    <p class="text-xs text-gray-600">BCA: 1234567890</p>
                                </div>
                            </div>
                            <i class="fas fa-check-circle text-blue-600"></i>
                        </div>
                    </div>
                    
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-qrcode text-purple-600 mr-3"></i>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">QRIS</p>
                                    <p class="text-xs text-gray-600">Scan QR Code</p>
                                </div>
                            </div>
                            <i class="fas fa-check-circle text-purple-600"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Action Button -->
                <a href="{{ route('alumni.payments.create') }}" 
                   class="w-full py-3 px-4 bg-gradient-to-r from-green-500 to-teal-600 text-white rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    Bayar Sekarang
                </a>
            @endif
        @else
            <!-- No Payment Info -->
            <div class="text-center py-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-wallet text-3xl text-gray-400"></i>
                </div>
                <h6 class="text-gray-800 font-semibold mb-2">Belum Ada Data Pembayaran</h6>
                <p class="text-gray-500 text-sm mb-6">Mulai kontribusi Anda untuk kemajuan IKA SMADA</p>
                
                <a href="{{ route('alumni.payments.create') }}" 
                   class="inline-flex items-center py-3 px-6 bg-gradient-to-r from-green-500 to-teal-600 text-white rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    Bayar Iuran
                </a>
            </div>
        @endif
    </div>
</div>
