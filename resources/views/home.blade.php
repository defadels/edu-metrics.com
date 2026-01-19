@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="py-20 lg:py-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-8 animate-fade-in-up">
            <div class="space-y-4">
                <h1 class="text-5xl lg:text-7xl font-extrabold text-theme-primary tracking-tight">
                    Selamat Datang di <span class="text-theme-active">Edu Metrics</span>
                </h1>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Platform modern untuk evaluasi dan umpan balik instrumen kepuasan civitas akademika.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('surveys.index') }}" 
                   class="w-full sm:w-auto px-10 py-5 bg-theme-primary text-white rounded-2xl font-bold text-lg shadow-xl hover:bg-theme-primary/90 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                    <span>Mulai Isi Kuesioner</span>
                    <svg class="w-6 h-6 outline-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                @auth
                <a href="{{ route('profile.edit') }}" 
                   class="w-full sm:w-auto px-10 py-5 bg-white text-theme-primary border-2 border-theme-primary/10 rounded-2xl font-bold text-lg shadow-md hover:bg-theme-primary/5 transform hover:-translate-y-1 transition-all duration-300">
                    Lengkapi Data Diri
                </a>
                @endauth
            </div>
            
            @guest
            <div class="pt-8 text-gray-500 font-medium">
                Belum punya akun? <a href="{{ route('register') }}" class="text-theme-active hover:underline">Daftar sekarang</a>
            </div>
            @endguest
        </div>
    </div>
</div>
@endsection
