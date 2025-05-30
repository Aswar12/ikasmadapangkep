@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Selamat datang kembali, {{ $user->name }}! 👋</h1>
    <p class="mb-6">Senang melihat Anda kembali di portal alumni IKA SMADA Pangkep</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-lg font-semibold mb-2">Angkatan</h2>
            <p>{{ $user->angkatan ?? 'Belum diisi' }}</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-lg font-semibold mb-2">Bergabung</h2>
            <p>{{ $user->created_at->diffForHumans() }}</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-lg font-semibold mb-2">Total Alumni</h2>
            <p>{{ $stats['total_alumni_angkatan'] ?? 0 }}</p>
            <p class="text-green-600 text-sm">+12% dari bulan lalu</p>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-lg font-semibold mb-2">Status Iuran</h2>
            <p class="text-red-600 font-semibold">{{ $paymentStatus ? str_replace('_', ' ', $paymentStatus->status) : 'belum bayar' }}</p>
            <p>Tahun {{ date('Y') }}</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-lg font-semibold mb-2">Event Mendatang</h2>
            <p>{{ $upcomingEvents->count() ?? 0 }}</p>
        </div>
    </div>
</div>
@endsection
