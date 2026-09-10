@props(['title' => 'Login', 'isFixed' => false])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $isFixed ? 'h-full lg:overflow-hidden' : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'Edu Metrics') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased {{ $isFixed ? 'h-full lg:h-screen lg:overflow-hidden' : 'min-h-screen' }}">
    <div class="{{ $isFixed ? 'min-h-screen lg:min-h-0 lg:h-screen lg:overflow-hidden' : 'min-h-screen' }} flex flex-col lg:flex-row">
        <!-- Left Side - Branding -->
        <x-auth-branding />

        <!-- Right Side - Form -->
        <div class="flex-1 flex items-center justify-center relative {{ $isFixed ? 'overflow-hidden lg:h-screen lg:py-0' : 'overflow-y-auto lg:min-h-screen py-10 lg:py-8' }} py-8">
            <!-- Background Image -->
            <div class="absolute inset-0 pointer-events-none">
                <img src="{{ asset('banner.jpg') }}" alt="STKIP Pasundan Cimahi" class="w-full h-full object-cover">
            </div>

            <!-- White Overlay for better form readability -->
            <div class="absolute inset-0 bg-white/70 pointer-events-none"></div>

            <!-- Form Container -->
            <div class="relative z-10 w-full max-w-md px-4 sm:px-6 {{ $isFixed ? 'py-2 sm:py-4' : 'py-6' }}">
                <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl {{ $isFixed ? 'p-6 sm:p-7' : 'p-6 sm:p-8' }} animate-fade-in-up">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
