@props([
    'type' => 'info',
    'dismissible' => false
])

@php
    $classes = match($type) {
        'success' => 'bg-green-50 text-green-800 border-green-200',
        'error' => 'bg-red-50 text-red-800 border-red-200',
        'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
        'info' => 'bg-blue-50 text-blue-800 border-blue-200',
        default => 'bg-gray-50 text-gray-800 border-gray-200'
    };

    $iconClasses = match($type) {
        'success' => 'text-green-500',
        'error' => 'text-red-500',
        'warning' => 'text-yellow-500',
        'info' => 'text-blue-500',
        default => 'text-gray-500'
    };

    $icon = match($type) {
        'success' => 'fa-check-circle',
        'error' => 'fa-exclamation-circle',
        'warning' => 'fa-exclamation-triangle',
        'info' => 'fa-info-circle',
        default => 'fa-info-circle'
    };
@endphp

<div {{ $attributes->merge(['class' => "rounded-lg border p-4 {$classes}"]) }} role="alert">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas {{ $icon }} {{ $iconClasses }}"></i>
        </div>
        <div class="ml-3">
            <div class="text-sm font-medium">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button type="button" 
                            class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2"
                            onclick="this.parentElement.parentElement.parentElement.remove()">
                        <span class="sr-only">Dismiss</span>
                        <i class="fas fa-times {{ $iconClasses }}"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
