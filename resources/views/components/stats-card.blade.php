@props([
    'title' => '',
    'value' => '',
    'icon' => 'fas fa-chart-bar',
    'color' => 'blue',
    'change' => null,
    'changeType' => 'increase', // increase, decrease, neutral
    'size' => 'md'
])

@php
$colorClasses = [
    'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'icon' => 'text-blue-600'],
    'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-600', 'icon' => 'text-green-600'],
    'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600', 'icon' => 'text-yellow-600'],
    'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-600', 'icon' => 'text-red-600'],
    'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'icon' => 'text-purple-600'],
    'indigo' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'icon' => 'text-indigo-600'],
    'gray' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => 'text-gray-600']
];

$changeTypeClasses = [
    'increase' => ['text' => 'text-green-600', 'icon' => 'fas fa-arrow-up'],
    'decrease' => ['text' => 'text-red-600', 'icon' => 'fas fa-arrow-down'],
    'neutral' => ['text' => 'text-gray-600', 'icon' => 'fas fa-minus']
];

$sizeClasses = [
    'sm' => ['padding' => 'p-4', 'icon' => 'text-lg', 'value' => 'text-2xl', 'title' => 'text-xs'],
    'md' => ['padding' => 'p-6', 'icon' => 'text-xl', 'value' => 'text-3xl', 'title' => 'text-sm'],
    'lg' => ['padding' => 'p-8', 'icon' => 'text-2xl', 'value' => 'text-4xl', 'title' => 'text-base']
];

$colors = $colorClasses[$color] ?? $colorClasses['blue'];
$changeStyle = $changeTypeClasses[$changeType] ?? $changeTypeClasses['neutral'];
$sizes = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div class="bg-white rounded-xl shadow-lg border border-gray-100 {{ $sizes['padding'] }} hover:shadow-xl transition-all duration-300" {{ $attributes }}>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="{{ $sizes['title'] }} font-medium text-gray-600 mb-1">{{ $title }}</p>
            <p class="{{ $sizes['value'] }} font-bold {{ $colors['text'] }} mb-2">{{ $value }}</p>
            
            @if($change !== null)
            <div class="flex items-center {{ $sizes['title'] }} {{ $changeStyle['text'] }}">
                <i class="{{ $changeStyle['icon'] }} mr-1"></i>
                <span class="font-medium">{{ $change }}</span>
                <span class="text-gray-500 ml-1">dari periode sebelumnya</span>
            </div>
            @endif
        </div>
        
        <div class="{{ $colors['bg'] }} {{ $sizes['padding'] }} rounded-full">
            <i class="{{ $icon }} {{ $colors['icon'] }} {{ $sizes['icon'] }}"></i>
        </div>
    </div>
    
    @if($slot->isNotEmpty())
    <div class="mt-4 pt-4 border-t border-gray-100">
        {{ $slot }}
    </div>
    @endif
</div>