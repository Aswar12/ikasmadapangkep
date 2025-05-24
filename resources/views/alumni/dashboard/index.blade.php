@extends('layouts.alumni')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Summary Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center space-x-4 mb-6">
            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-16 w-16 rounded-full">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</h3>
                <p class="text-sm text-gray-500">Angkatan {{ Auth::user()->graduation_year }}</p>
            </div>
        </div>
        
        <div class="space-y-3">
            <div class="flex items-center text-gray-600">
                <i class="fas fa-envelope w-5"></i>
                <span class="ml-2">{{ Auth::user()->email }}</span>
            </div>
            <div class="flex items-center text-gray-600">
                <i class="fas fa-phone w-5"></i>
                <span class="ml-2">{{ Auth::user()->phone ?? '-' }}</span>
            </div>
            <div class="flex items-center text-gray-600">
                <i class="fas fa-briefcase w-5"></i>
                <span class="ml-2">{{ Auth::user()->current_job ?? 'Belum diisi' }}</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Update Profile
            </a>
        </div>
    </div>

    <!-- Membership Status Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-id-card text-blue-500 mr-2"></i>
            Status Keanggotaan
        </h3>

        @php
            $status = Auth::user()->approved ? 'Terverifikasi' : 'Menunggu Verifikasi';
            $statusColor = Auth::user()->approved ? 'green' : 'yellow';
        @endphp

        <div class="mb-6">
            <div class="flex items-center mb-4">
                <div class="flex-1">
                    <p class="text-gray-600">Status:</p>
                    <p class="font-semibold">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                            <i class="fas {{ Auth::user()->approved ? 'fa-check' : 'fa-clock' }} mr-1"></i>
                            {{ $status }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <p class="text-gray-600 mb-2">Member ID:</p>
                <p class="font-mono text-lg font-semibold text-gray-800">{{ Auth::user()->member_id ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Payment Status Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-receipt text-blue-500 mr-2"></i>
            Status Pembayaran
        </h3>

        @php
            $paymentStatus = 'Belum Bayar'; // Replace with actual payment status logic
            $statusClass = 'bg-red-100 text-red-800'; // Default to unpaid style
        @endphp

        <div class="mb-6">
            <div class="flex items-center mb-4">
                <div class="flex-1">
                    <p class="text-gray-600">Iuran Tahunan:</p>
                    <p class="font-semibold">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $statusClass }}">
                            {{ $paymentStatus }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <p class="text-gray-600 mb-2">Jumlah Tagihan:</p>
                <p class="font-semibold text-lg text-gray-800">Rp 50.000</p>
                <p class="text-sm text-gray-500">Periode: 2025</p>
            </div>
        </div>

        <a href="#" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
            <i class="fas fa-upload mr-2"></i>
            Upload Bukti Pembayaran
        </a>
    </div>
</div>

<!-- Quick Links Section -->
<div class="mt-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="#" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:border-blue-500 transition-colors">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-calendar text-blue-600"></i>
                </div>
                <span class="font-medium text-gray-700">Event Mendatang</span>
            </div>
        </a>

        <a href="#" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:border-blue-500 transition-colors">
            <div class="flex items-center space-x-3">
                <div class="bg-purple-100 p-3 rounded-lg">
                    <i class="fas fa-users text-purple-600"></i>
                </div>
                <span class="font-medium text-gray-700">Cari Alumni</span>
            </div>
        </a>

        <a href="#" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:border-blue-500 transition-colors">
            <div class="flex items-center space-x-3">
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-chart-line text-green-600"></i>
                </div>
                <span class="font-medium text-gray-700">Laporan Keuangan</span>
            </div>
        </a>

        <a href="#" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:border-blue-500 transition-colors">
            <div class="flex items-center space-x-3">
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <i class="fas fa-images text-yellow-600"></i>
                </div>
                <span class="font-medium text-gray-700">Galeri Foto</span>
            </div>
        </a>
    </div>
</div>
@endsection
