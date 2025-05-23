@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'h-12 px-4 py-3 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm transition duration-150 ease-in-out text-base placeholder-gray-400']) !!}>
