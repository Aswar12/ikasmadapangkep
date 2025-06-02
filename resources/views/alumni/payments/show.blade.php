@extends('layouts.alumni')

@section('page-title', 'Detail Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt"></i> Detail Pembayaran
                        </h5>
                        <span class="badge bg-{{ $payment->status_color }} fs-6">
                            @switch($payment->status)
                                @case('verified')
                                    <i class="fas fa-check-circle"></i> Terverifikasi
                                    @break
                                @case('waiting_verification')
                                    <i class="fas fa-clock"></i> Menunggu Verifikasi
                                    @break
                                @case('rejected')
                                    <i class="fas fa-times-circle"></i> Ditolak
                                    @break
                                @default
                                    <i class="fas fa-exclamation-circle"></i> Belum Bayar
                            @endswitch
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Payment Code -->
                    <div class="text-center mb-4">
                        <p class="text-muted mb-1">Kode Pembayaran</p>
                        <h3 class="font-monospace text-primary">{{ $payment->payment_code }}</h3>
                    </div>

                    <!-- Payment Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted">Tahun Iuran</td>
                                    <td class="fw-bold">{{ $payment->year }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Nominal</td>
                                    <td class="fw-bold">{{ $payment->formatted_amount }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Metode Pembayaran</td>
                                    <td class="fw-bold">{{ $payment->payment_method ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status</td>
                                    <td>{!! $payment->status_label !!}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted">Tanggal Dibuat</td>
                                    <td class="fw-bold">{{ $payment->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tanggal Bayar</td>
                                    <td class="fw-bold">{{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tanggal Verifikasi</td>
                                    <td class="fw-bold">{{ $payment->verified_at ? $payment->verified_at->format('d M Y H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Diverifikasi Oleh</td>
                                    <td class="fw-bold">{{ $payment->verifier ? $payment->verifier->name : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($payment->notes)
                    <div class="mb-4">
                        <h6 class="text-muted">Catatan</h6>
                        <div class="bg-light p-3 rounded">
                            {{ $payment->notes }}
                        </div>
                    </div>
                    @endif

                    <!-- Rejection Reason -->
                    @if($payment->status === 'rejected' && $payment->rejection_reason)
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">
                            <i class="fas fa-exclamation-triangle"></i> Alasan Penolakan
                        </h6>
                        <p class="mb-0">{{ $payment->rejection_reason }}</p>
                    </div>
                    @endif

                    <!-- Payment Proof -->
                    @if($payment->payment_proof)
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Bukti Pembayaran</h6>
                        <div class="border rounded p-3 text-center bg-light">
                            @php
                                $extension = pathinfo($payment->payment_proof, PATHINFO_EXTENSION);
                            @endphp
                            
                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                <img src="{{ Storage::url($payment->payment_proof) }}" 
                                     alt="Bukti Pembayaran" 
                                     class="img-fluid rounded"
                                     style="max-height: 400px;">
                            @else
                                <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                                <p class="mb-0">File PDF: {{ basename($payment->payment_proof) }}</p>
                            @endif
                            
                            <div class="mt-3">
                                <a href="{{ route('alumni.payments.download-proof', $payment) }}" 
                                   class="btn btn-sm btn-secondary">
                                    <i class="fas fa-download"></i> Download Bukti
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
<a href="{{ route('alumni.payments') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        
                        @if($payment->isEditable())
                        <a href="{{ route('alumni.payments.create', ['year' => $payment->year]) }}" 
                           class="btn btn-warning">
                            <i class="fas fa-redo"></i> Upload Ulang
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-history"></i> Riwayat Status</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @if($payment->verified_at && $payment->status === 'verified')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Pembayaran Diverifikasi</h6>
                                <p class="text-muted mb-0">
                                    {{ $payment->verified_at->format('d M Y H:i') }} 
                                    oleh {{ $payment->verifier ? $payment->verifier->name : 'System' }}
                                </p>
                            </div>
                        </div>
                        @endif
                        
                        @if($payment->verified_at && $payment->status === 'rejected')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Pembayaran Ditolak</h6>
                                <p class="text-muted mb-0">
                                    {{ $payment->verified_at->format('d M Y H:i') }} 
                                    oleh {{ $payment->verifier ? $payment->verifier->name : 'System' }}
                                </p>
                            </div>
                        </div>
                        @endif
                        
                        @if($payment->paid_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Bukti Pembayaran Diupload</h6>
                                <p class="text-muted mb-0">{{ $payment->paid_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <div class="timeline-item">
                            <div class="timeline-marker bg-secondary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Pembayaran Dibuat</h6>
                                <p class="text-muted mb-0">{{ $payment->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    
    .timeline-marker {
        position: absolute;
        left: -23px;
        top: 5px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
    }
    
    .timeline-content {
        padding-left: 10px;
    }
</style>
@endpush
@endsection
