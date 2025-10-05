@props(['status', 'size' => 'md'])

@php
$statusConfig = [
    // Program Status
    'planning' => ['color' => 'yellow', 'text' => 'Perencanaan', 'icon' => 'fas fa-clipboard'],
    'ongoing' => ['color' => 'blue', 'text' => 'Berjalan', 'icon' => 'fas fa-play'],
    'completed' => ['color' => 'green', 'text' => 'Selesai', 'icon' => 'fas fa-check'],
    'cancelled' => ['color' => 'red', 'text' => 'Dibatalkan', 'icon' => 'fas fa-times'],
    'delayed' => ['color' => 'orange', 'text' => 'Tertunda', 'icon' => 'fas fa-pause'],
    
    // User Status
    'active' => ['color' => 'green', 'text' => 'Aktif', 'icon' => 'fas fa-check-circle'],
    'inactive' => ['color' => 'red', 'text' => 'Tidak Aktif', 'icon' => 'fas fa-times-circle'],
    'pending' => ['color' => 'yellow', 'text' => 'Menunggu', 'icon' => 'fas fa-clock'],
    'approved' => ['color' => 'green', 'text' => 'Disetujui', 'icon' => 'fas fa-check-circle'],
    'rejected' => ['color' => 'red', 'text' => 'Ditolak', 'icon' => 'fas fa-times-circle'],
    
    // Payment Status
    'waiting_verification' => ['color' => 'yellow', 'text' => 'Menunggu Verifikasi', 'icon' => 'fas fa-clock'],
    'verified' => ['color' => 'green', 'text' => 'Terverifikasi', 'icon' => 'fas fa-check'],
    
    // Department Status
    'has_coordinator' => ['color' => 'green', 'text' => 'Ada Koordinator', 'icon' => 'fas fa-user-tie'],
    'no_coordinator' => ['color' => 'yellow', 'text' => 'Belum Ada Koordinator', 'icon' => 'fas fa-user-slash'],
];

$config = $statusConfig[strtolower($status)] ?? ['color' => 'gray', 'text' => ucfirst($status), 'icon' => 'fas fa-circle'];

$sizeClasses = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-0.5 text-xs',
    'lg' => 'px-3 py-1 text-sm'
];

$colorClasses = [
    'green' => 'bg-green-100 text-green-800',
    'blue' => 'bg-blue-100 text-blue-800',
    'yellow' => 'bg-yellow-100 text-yellow-800',
    'red' => 'bg-red-100 text-red-800',
    'orange' => 'bg-orange-100 text-orange-800',
    'purple' => 'bg-purple-100 text-purple-800',
    'indigo' => 'bg-indigo-100 text-indigo-800',
    'gray' => 'bg-gray-100 text-gray-800'
];

$sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
$colorClass = $colorClasses[$config['color']] ?? $colorClasses['gray'];
@endphp

<span class="inline-flex items-center {{ $sizeClass }} {{ $colorClass }} font-medium rounded-full" {{ $attributes }}>
    @if(isset($config['icon']))
        <i class="{{ $config['icon'] }} mr-1"></i>
    @endif
    {{ $config['text'] }}
</span>