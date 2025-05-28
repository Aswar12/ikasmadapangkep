@props([
    'message' => 'Memuat data...'
])

<div class="flex flex-col items-center justify-center py-12">
    <div class="spinner mb-4"></div>
    <p class="text-gray-500 text-sm">{{ $message }}</p>
</div>

@push('styles')
<style>
.spinner {
    width: 40px;
    height: 40px;
    border: 3px solid #f3f4f6;
    border-top-color: #6366f1;
    border-radius: 50%;
    animation: spinner 0.8s linear infinite;
}

@keyframes spinner {
    to {
        transform: rotate(360deg);
    }
}
</style>
@endpush
