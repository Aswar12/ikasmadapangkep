@props([
    'icon' => 'fas fa-inbox',
    'title' => 'Tidak Ada Data',
    'message' => 'Belum ada data yang tersedia saat ini.',
    'actionUrl' => null,
    'actionText' => null,
    'actionIcon' => 'fas fa-plus'
])

<div class="text-center py-12">
    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
        <i class="{{ $icon }} text-3xl text-gray-400"></i>
    </div>
    <h6 class="text-gray-800 font-semibold mb-2">{{ $title }}</h6>
    <p class="text-gray-500 text-sm mb-6">{{ $message }}</p>
    
    @if($actionUrl && $actionText)
    <a href="{{ $actionUrl }}" 
       class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium text-sm">
        <i class="{{ $actionIcon }} mr-2"></i>
        {{ $actionText }}
    </a>
    @endif
</div>
