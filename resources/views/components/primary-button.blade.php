<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'btn-modern bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:ring-indigo-500'
]) }}>
    {{ $slot }}
</button>
