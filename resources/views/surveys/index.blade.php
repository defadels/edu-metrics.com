@extends('layouts.app')

@section('title', 'Daftar Survey')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-12 animate-fade-in-up">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">Survey Tersedia</h1>
        <p class="text-lg text-gray-600 dark:text-gray-400">Pilih survey yang ingin Anda isi</p>
    </div>

    @if($surveys->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($surveys as $index => $survey)
                <div class="card-modern group animate-fade-in-up" style="animation-delay: {{ $index * 0.1 }}s; opacity: 0;">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <span class="px-4 py-1.5 text-xs font-semibold rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 dark:from-indigo-900/30 dark:to-purple-900/30 dark:text-indigo-300">
                                {{ $survey->category->name }}
                            </span>
                            @if($survey->is_anonymous)
                                <span class="px-4 py-1.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                    Anonim
                                </span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ $survey->title }}
                        </h3>
                        @if($survey->description)
                            <p class="text-gray-600 dark:text-gray-400 mb-6 line-clamp-3 leading-relaxed">
                                {{ Str::limit($survey->description, 120) }}
                            </p>
                        @endif
                        <div class="space-y-3 mb-6 text-sm">
                            <div class="flex items-center justify-between text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Pertanyaan:</span>
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $survey->questions_count }}</span>
                            </div>
                            <div class="flex items-center justify-between text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>Responses:</span>
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $survey->responses_count }}</span>
                            </div>
                            <div class="flex items-center justify-between text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Berakhir:</span>
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $survey->end_date->format('d M Y') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('surveys.show', $survey) }}" 
                           class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Mulai Survey
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $surveys->links() }}
        </div>
    @else
        <div class="card-modern p-16 text-center animate-fade-in-up">
            <div class="inline-flex items-center justify-center w-32 h-32 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 mb-8">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Belum Ada Survey</h3>
            <p class="text-gray-500 dark:text-gray-400 text-lg mb-8">Belum ada survey yang tersedia saat ini.</p>
            <a href="{{ route('home') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    @endif
</div>
@endsection
