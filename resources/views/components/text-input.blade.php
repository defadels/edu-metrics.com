@props(['disabled' => false, 'type' => 'text'])

<input 
    type="{{ $type }}"
    @disabled($disabled) 
    {{ $attributes->merge([
        'class' => 'w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:outline-none transition-all duration-300'
    ]) }}
>
