@props(['percentage' => 0, 'size' => 'md', 'color' => 'blue', 'showLabel' => true])

@php
$sizeClasses = [
    'sm' => 'h-1.5',
    'md' => 'h-2.5',
    'lg' => 'h-4'
];

$colorClasses = [
    'blue' => 'bg-blue-600',
    'green' => 'bg-green-600',
    'yellow' => 'bg-yellow-600',
    'red' => 'bg-red-600',
    'purple' => 'bg-purple-600',
    'indigo' => 'bg-indigo-600'
];

$textColorClasses = [
    'blue' => 'text-blue-600',
    'green' => 'text-green-600',
    'yellow' => 'text-yellow-600',
    'red' => 'text-red-600',
    'purple' => 'text-purple-600',
    'indigo' => 'text-indigo-600'
];

$sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
$colorClass = $colorClasses[$color] ?? $colorClasses['blue'];
$textColorClass = $textColorClasses[$color] ?? $textColorClasses['blue'];
$percentage = max(0, min(100, $percentage)); // Ensure percentage is between 0-100
@endphp

<div class="w-full">
    @if($showLabel)
    <div class="flex justify-between items-center mb-1">
        <span class="text-sm font-medium text-gray-700">Progress</span>
        <span class="text-sm font-medium {{ $textColorClass }}">{{ number_format($percentage, 1) }}%</span>
    </div>
    @endif
    
    <div class="w-full bg-gray-200 rounded-full {{ $sizeClass }}">
        <div class="{{ $colorClass }} {{ $sizeClass }} rounded-full transition-all duration-500 ease-out" 
             style="width: {{ $percentage }}%">
        </div>
    </div>
</div>