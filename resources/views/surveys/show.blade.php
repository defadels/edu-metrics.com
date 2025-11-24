@extends('layouts.app')

@section('title', $survey->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="card-modern animate-fade-in-up">
        <div class="p-8 lg:p-12">
            <!-- Survey Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 dark:from-indigo-900/30 dark:to-purple-900/30 dark:text-indigo-300">
                        {{ $survey->category->name }}
                    </span>
                    @if($survey->is_anonymous)
                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                            Survey Anonim
                        </span>
                    @endif
                </div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ $survey->title }}</h1>
                @if($survey->description)
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">{{ $survey->description }}</p>
                @endif
                <div class="grid grid-cols-2 gap-6 p-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Tanggal Mulai</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $survey->start_date->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Tanggal Berakhir</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $survey->end_date->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Jumlah Pertanyaan</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $survey->questions->count() }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Estimasi Waktu</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ ceil($survey->questions->count() * 0.5) }} menit</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warning if already responded -->
            @if($hasResponded)
                <div class="mb-8 p-4 bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-yellow-800 dark:text-yellow-200">
                            <strong>Perhatian:</strong> Anda sudah mengisi survey ini sebelumnya.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Questions Preview -->
            @if($survey->questions->count() > 0)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Daftar Pertanyaan</h2>
                    <div class="space-y-4">
                        @foreach($survey->questions->sortBy('order') as $index => $question)
                            <div class="border-2 border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:border-indigo-300 dark:hover:border-indigo-700 transition-colors">
                                <div class="flex items-start gap-4">
                                    <span class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-lg">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-1">
                                        <p class="text-gray-900 dark:text-white font-semibold mb-3 text-lg">{{ $question->question_text }}</p>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300">
                                                {{ $question->question_type }}
                                            </span>
                                            @if($question->is_required)
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                                    Wajib
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('surveys.index') }}" 
                   class="flex-1 text-center bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 px-6 py-4 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
                    Kembali
                </a>
                <a href="{{ route('surveys.start', $survey) }}" 
                   class="flex-1 text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Mulai Mengisi Survey
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
