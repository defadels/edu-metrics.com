<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Login' }} - {{ config('app.name', 'Edu Metrics') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col lg:flex-row">
            <!-- Left Side - Branding -->
            <x-auth-branding />

            <!-- Right Side - Form -->
            <div class="flex-1 flex items-center justify-center relative overflow-hidden min-h-screen">
                <!-- Background Image -->
                <div class="absolute inset-0">
                    <img src="{{ asset('banner.jpg') }}" alt="STKIP Pasundan Cimahi" class="w-full h-full object-cover">
                </div>
                
                <!-- White Overlay for better form readability -->
                <div class="absolute inset-0 bg-white/70"></div>

                <!-- Form Container -->
                <div class="relative z-10 w-full max-w-md px-6 py-8">
                    <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-8 animate-fade-in-up">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

