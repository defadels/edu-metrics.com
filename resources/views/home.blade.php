@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section with Banner Background -->
<div class="relative text-white overflow-hidden min-h-[600px] flex items-center">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ asset('banner.jpg') }}" alt="STKIP Pasundan Cimahi" class="w-full h-full object-cover">
    </div>
    
    <!-- Dark Overlay for better text readability -->
    <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/50 to-black/60"></div>
    
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-24 w-full">
        <div class="text-center animate-fade-in-up">
            <h1 class="text-5xl lg:text-6xl font-bold mb-6 text-shadow-lg">
                Edu Metrics Survey System
            </h1>
            <p class="text-xl lg:text-2xl mb-10 text-white/90 max-w-2xl mx-auto">
                Modern platform for collecting feedback and evaluation through interactive surveys
            </p>
            <a href="{{ route('surveys.index') }}" 
               class="btn-modern bg-white text-indigo-600 hover:bg-gray-50 inline-flex items-center gap-2 group">
                <span>View Available Surveys</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Stats Section with Icons -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="metric-card bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 animate-fade-in-up animate-delay-100">
            <div class="flex items-center gap-4 mb-4">
                <div class="icon-container">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Surveys</h3>
                    <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['total_surveys'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="metric-card bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 animate-fade-in-up animate-delay-200">
            <div class="flex items-center gap-4 mb-4">
                <div class="icon-container bg-gradient-to-br from-green-500 to-emerald-600">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Active Surveys</h3>
                    <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['active_surveys'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="metric-card bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 animate-fade-in-up animate-delay-300">
            <div class="flex items-center gap-4 mb-4">
                <div class="icon-container bg-gradient-to-br from-purple-500 to-pink-600">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Categories</h3>
                    <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['categories'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Active Surveys Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="mb-12 animate-fade-in-up">
        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">Latest Surveys</h2>
        <p class="text-lg text-gray-600 dark:text-gray-400">Participate in ongoing surveys</p>
    </div>

    @if($activeSurveys->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($activeSurveys as $index => $survey)
                <div class="card-modern group animate-fade-in-up" style="animation-delay: {{ $index * 0.1 }}s; opacity: 0;">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <span class="px-4 py-1.5 text-xs font-semibold rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 dark:from-indigo-900/30 dark:to-purple-900/30 dark:text-indigo-300">
                                {{ $survey->category->name }}
                            </span>
                            @if($survey->is_anonymous)
                                <span class="px-4 py-1.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                    Anonymous
                                </span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ $survey->title }}
                        </h3>
                        @if($survey->description)
                            <p class="text-gray-600 dark:text-gray-400 mb-6 line-clamp-2 leading-relaxed">
                                {{ Str::limit($survey->description, 100) }}
                            </p>
                        @endif
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Ends: {{ $survey->end_date->format('d M Y') }}</span>
                        </div>
                        <a href="{{ route('surveys.show', $survey) }}" 
                           class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16 animate-fade-in-up">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-100 dark:bg-gray-800 mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-lg">No surveys available at the moment.</p>
        </div>
    @endif

    <div class="mt-12 text-center animate-fade-in-up animate-delay-300">
        <a href="{{ route('surveys.index') }}" 
           class="inline-flex items-center gap-2 px-8 py-4 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
            <span>View All Surveys</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>
</div>

<!-- Categories Section -->
@if($categories->count() > 0)
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center animate-fade-in-up">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">Survey Categories</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">Explore surveys by category</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories as $index => $category)
                    <div class="card-modern text-center p-6 animate-fade-in-up" style="animation-delay: {{ $index * 0.1 }}s; opacity: 0;">
                        <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                            {{ $category->surveys_count }}
                        </div>
                        <div class="text-gray-700 dark:text-gray-300 font-semibold">{{ $category->name }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
@endsection
