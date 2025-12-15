@props(['disabled' => false, 'type' => 'text'])

<input 
    type="{{ $type }}"
    @disabled($disabled) 
    {{ $attributes->merge([
        'class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none transition-all duration-300'
    ]) }}
>
