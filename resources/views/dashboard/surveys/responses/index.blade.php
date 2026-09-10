@extends('layouts.dashboard')

@section('title', 'Survey Responses')
@section('page-title', 'Survey Responses')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4 animate-fade-in-up">
    <div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Responses for: {{ $survey->title }}</h3>
        <p class="text-gray-600 dark:text-gray-400 mt-1">View list of respondents and aggregates for this survey</p>
    </div>
    <div class="flex flex-wrap items-center gap-2.5">
        <a href="{{ route('dashboard.surveys.responses.export.excel', $survey) }}" 
           class="btn-modern bg-emerald-600 hover:bg-emerald-700 text-white inline-flex items-center gap-2 shadow-sm text-sm"
           title="Export ke Format Excel (.xls)">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Export Excel</span>
        </a>

        <a href="{{ route('dashboard.surveys.responses.export.pdf', $survey) }}" 
           class="btn-modern bg-red-600 hover:bg-red-700 text-white inline-flex items-center gap-2 shadow-sm text-sm"
           title="Export ke Format PDF (.pdf)">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            <span>Export PDF</span>
        </a>

        <a href="{{ route('dashboard.surveys.show', $survey) }}" 
           class="btn-modern bg-gray-600 hover:bg-gray-700 text-white inline-flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to Survey</span>
        </a>
    </div>
</div>

<!-- STATS OVERVIEW CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in-up animate-delay-100">
    <!-- Card 1: Total Responses -->
    <div class="metric-card bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border-t-4 border-emerald-600 flex items-center justify-between">
        <div>
            <span class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block">Total Responden</span>
            <span class="text-4xl font-extrabold text-gray-900 dark:text-white block mt-2">{{ $totalResponses }}</span>
            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold mt-1 inline-flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Respon Selesai
            </span>
        </div>
        <div class="p-4 bg-emerald-50 dark:bg-emerald-950/30 rounded-2xl text-emerald-600 dark:text-emerald-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>

    <!-- Card 2: Active Period -->
    <div class="metric-card bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border-t-4 border-indigo-600 flex items-center justify-between">
        <div>
            <span class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block">Rentang Waktu</span>
            <div class="mt-2">
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200 block">Mulai: {{ $survey->start_date ? $survey->start_date->format('d M Y') : '-' }}</span>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200 block">Selesai: {{ $survey->end_date ? $survey->end_date->format('d M Y') : '-' }}</span>
            </div>
            @if($survey->is_active && (!$survey->end_date || $survey->end_date->isFuture()))
                <span class="px-2 py-0.5 mt-1 inline-block text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-950/30 dark:text-green-400 rounded-full">
                    Active
                </span>
            @else
                <span class="px-2 py-0.5 mt-1 inline-block text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-950/30 dark:text-red-400 rounded-full">
                    Ended
                </span>
            @endif
        </div>
        <div class="p-4 bg-indigo-50 dark:bg-indigo-950/30 rounded-2xl text-indigo-600 dark:text-indigo-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    </div>

    <!-- Card 3: Satisfaction / Category -->
    @php
        $likertTotal = 0;
        $likertCount = 0;
        foreach ($questionStats as $qId => $stats) {
            if ($stats['question']->question_type === 'likert') {
                foreach ($stats['options'] as $opt) {
                    $likertTotal += $opt['value'] * $opt['count'];
                    $likertCount += $opt['count'];
                }
            }
        }
        $avgLikert = $likertCount > 0 ? round($likertTotal / $likertCount, 2) : 0;
        
        $avgLabel = '-';
        $avgColor = 'text-gray-500';
        if ($avgLikert >= 4.5) {
            $avgLabel = 'Sangat Baik';
            $avgColor = 'text-green-600 dark:text-green-400';
        } elseif ($avgLikert >= 3.5) {
            $avgLabel = 'Baik';
            $avgColor = 'text-emerald-500 dark:text-emerald-400';
        } elseif ($avgLikert >= 2.5) {
            $avgLabel = 'Netral';
            $avgColor = 'text-amber-500 dark:text-amber-400';
        } elseif ($avgLikert >= 1.5) {
            $avgLabel = 'Buruk';
            $avgColor = 'text-orange-500 dark:text-orange-400';
        } elseif ($avgLikert > 0) {
            $avgLabel = 'Sangat Buruk';
            $avgColor = 'text-red-600 dark:text-red-400';
        }
    @endphp

    @if($likertCount > 0)
    <div class="metric-card bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border-t-4 border-amber-500 flex items-center justify-between">
        <div>
            <span class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block">Indeks Kepuasan</span>
            <span class="text-4xl font-extrabold text-gray-900 dark:text-white block mt-2">{{ $avgLikert }}<span class="text-sm font-normal text-gray-500 dark:text-gray-400">/5.0</span></span>
            <span class="text-xs font-bold mt-1 inline-flex items-center gap-1 {{ $avgColor }}">
                ★ {{ $avgLabel }}
            </span>
        </div>
        <div class="p-4 bg-amber-50 dark:bg-amber-950/30 rounded-2xl text-amber-500 dark:text-amber-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.373-1.81.588-1.81h4.906a1 1 0 00.95-.69l1.519-4.674z" />
            </svg>
        </div>
    </div>
    @else
    <div class="metric-card bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border-t-4 border-amber-500 flex items-center justify-between">
        <div>
            <span class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block">Kategori Respon</span>
            <span class="text-2xl font-extrabold text-gray-900 dark:text-white block mt-2 truncate max-w-[200px]">{{ $survey->category->name ?? 'General' }}</span>
            <span class="text-xs text-amber-500 font-semibold mt-1 inline-flex items-center gap-1">
                Kategori Survei
            </span>
        </div>
        <div class="p-4 bg-amber-50 dark:bg-amber-950/30 rounded-2xl text-amber-500 dark:text-amber-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
    </div>
    @endif
</div>

<!-- LIKERT OVERALL SENTIMENT DIAGRAM (IF LIKERT EXISTS) -->
@if($totalResponses > 0 && $totalLikertAnswers > 0)
<div class="card-modern p-6 mb-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 animate-fade-in-up animate-delay-200">
    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
        </svg>
        Bagan Distribusi Kepuasan Keseluruhan (Likert Scale)
    </h4>
    <div class="flex flex-col md:flex-row items-center justify-around gap-8">
        <!-- Chart.js Doughnut -->
        <div class="relative w-48 h-48 flex-shrink-0">
            <canvas id="overallLikertChart"></canvas>
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                <span class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $avgLikert }}</span>
                <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Skor Rata-rata</span>
            </div>
        </div>
        
        <!-- Legend & Details -->
        <div class="flex-1 w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @php
                $likertColors = [
                    5 => ['dot' => 'bg-green-500', 'bg' => 'bg-green-50 dark:bg-green-950/20', 'text' => 'text-green-700 dark:text-green-300'],
                    4 => ['dot' => 'bg-emerald-400', 'bg' => 'bg-emerald-50 dark:bg-emerald-950/20', 'text' => 'text-emerald-700 dark:text-emerald-300'],
                    3 => ['dot' => 'bg-amber-400', 'bg' => 'bg-amber-50 dark:bg-amber-950/20', 'text' => 'text-amber-700 dark:text-amber-300'],
                    2 => ['dot' => 'bg-orange-500', 'bg' => 'bg-orange-50 dark:bg-orange-950/20', 'text' => 'text-orange-700 dark:text-orange-300'],
                    1 => ['dot' => 'bg-red-500', 'bg' => 'bg-red-50 dark:bg-red-950/20', 'text' => 'text-red-700 dark:text-red-300'],
                ];
            @endphp
            @foreach($overallLikertDistribution as $val => $data)
                @php 
                    $styling = $likertColors[$val] ?? ['dot' => 'bg-gray-500', 'bg' => 'bg-gray-50', 'text' => 'text-gray-700'];
                @endphp
                <div class="p-3.5 rounded-xl border border-gray-100 dark:border-gray-700/60 {{ $styling['bg'] }} flex flex-col justify-between">
                    <div class="flex items-center gap-1.5 mb-2">
                        <span class="w-3 h-3 rounded-full {{ $styling['dot'] }} flex-shrink-0 animate-pulse-slow"></span>
                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300 truncate">{{ $data['label'] }}</span>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold text-gray-900 dark:text-white block">{{ $data['percentage'] }}%</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">{{ $data['count'] }} respon</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- TAB SWITCHER -->
<div class="flex border-b border-gray-200 dark:border-gray-700 mb-6 bg-white dark:bg-gray-800 rounded-xl p-1.5 gap-1.5 shadow-sm animate-fade-in-up animate-delay-200">
    <button onclick="switchTab('analysis-tab', 'respondents-tab')" id="analysis-tab-btn" 
            class="flex-1 py-3 px-4 rounded-lg font-bold text-sm transition-all duration-200 bg-emerald-600 text-white shadow-md">
        📊 Analisis & Diagram
    </button>
    <button onclick="switchTab('respondents-tab', 'analysis-tab')" id="respondents-tab-btn" 
            class="flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all duration-200 text-gray-600 hover:text-gray-900 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50">
        👥 Daftar Responden
    </button>
</div>

<!-- TAB CONTENT 1: OVERVIEW & ANALYSIS -->
<div id="analysis-tab" class="space-y-6 animate-fade-in-up animate-delay-300">
    @if($totalResponses == 0)
        <div class="card-modern p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No responses analyzed yet</h3>
            <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">Once completed survey responses are submitted, they will be beautifully aggregated as interactive charts and percentages here.</p>
        </div>
    @else
        @foreach($questionStats as $qId => $stats)
            <div class="card-modern p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/60 transition-transform duration-300 hover:scale-[1.005]">
                <!-- Question Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 dark:border-gray-700/50 pb-4 mb-5">
                    <div>
                        <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest block mb-1">Pertanyaan {{ $loop->iteration }}</span>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white leading-snug">{{ $stats['question']->question_text }}</h4>
                    </div>
                    <div class="flex flex-wrap items-center gap-1.5">
                        <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full uppercase tracking-wider bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                            {{ $stats['question']->question_type === 'likert' ? 'Skala Likert' : ($stats['question']->question_type === 'multiple_choice' ? 'Pilihan Ganda' : 'Isian Singkat') }}
                        </span>
                        <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full uppercase tracking-wider {{ $stats['question']->is_required ? 'bg-red-50 text-red-700 dark:bg-red-950/20 dark:text-red-400' : 'bg-gray-50 text-gray-500 dark:bg-gray-800' }}">
                            {{ $stats['question']->is_required ? 'Wajib' : 'Opsional' }}
                        </span>
                        <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-950/20 dark:text-emerald-400">
                            {{ $stats['total_answers'] }} tanggapan
                        </span>
                    </div>
                </div>

                <!-- Answer Content based on Question Type -->
                @if($stats['question']->question_type === 'likert' || $stats['question']->question_type === 'multiple_choice')
                    <div class="space-y-4">
                        @foreach($stats['options'] as $index => $opt)
                            @php
                                // Assign distinct gradients for multiple choice, and color code Likert scale
                                if($stats['question']->question_type === 'likert') {
                                    $likertGradients = [
                                        5 => 'from-green-400 to-green-600',
                                        4 => 'from-emerald-400 to-emerald-500',
                                        3 => 'from-yellow-400 to-amber-400',
                                        2 => 'from-orange-400 to-orange-500',
                                        1 => 'from-red-500 to-red-600',
                                    ];
                                    $gradient = $likertGradients[$opt['value']] ?? 'from-indigo-400 to-indigo-600';
                                } else {
                                    $mcGradients = [
                                        0 => 'from-indigo-500 to-blue-600',
                                        1 => 'from-purple-500 to-pink-500',
                                        2 => 'from-teal-400 to-emerald-500',
                                        3 => 'from-amber-400 to-orange-500',
                                        4 => 'from-cyan-400 to-blue-500'
                                    ];
                                    $gradient = $mcGradients[$index % count($mcGradients)];
                                }
                            @endphp
                            <div class="group">
                                <div class="flex items-center justify-between text-sm font-semibold mb-1">
                                    <span class="text-gray-800 dark:text-gray-200 group-hover:text-emerald-600 transition-colors">{{ $opt['label'] }}</span>
                                    <span class="text-gray-900 dark:text-white">{{ $opt['percentage'] }}% <span class="text-xs font-normal text-gray-500 dark:text-gray-400">({{ $opt['count'] }} respon)</span></span>
                                </div>
                                <div class="w-full h-3.5 bg-gray-100 dark:bg-gray-700/60 rounded-full overflow-hidden shadow-inner">
                                    <div class="h-full bg-gradient-to-r {{ $gradient }} rounded-full transition-all duration-1000 ease-out" 
                                         style="width: {{ $opt['percentage'] }}%;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif($stats['question']->question_type === 'text')
                    @if(empty($stats['text_responses']))
                        <div class="text-sm text-gray-500 dark:text-gray-400 italic py-4">Belum ada jawaban teks untuk pertanyaan ini.</div>
                    @else
                        <!-- Text Answers List with Scroll & Read More Collapse -->
                        <div class="relative">
                            <div id="text-feed-{{ $qId }}" class="space-y-3.5 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($stats['text_responses'] as $resp)
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700/40 border border-gray-100 dark:border-gray-700/50 rounded-2xl relative shadow-sm hover:shadow transition-shadow">
                                        <div class="text-gray-800 dark:text-gray-200 text-sm leading-relaxed italic mb-2.5">
                                            "{{ $resp['text'] }}"
                                        </div>
                                        <div class="flex justify-between items-center text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $resp['respondent'] }}
                                            </span>
                                            <span>
                                                {{ $resp['date'] }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if(count($stats['text_responses']) > 5)
                                <div class="text-center mt-3">
                                    <button onclick="toggleTextCollapse('{{ $qId }}')" id="text-toggle-btn-{{ $qId }}" 
                                            class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 inline-flex items-center gap-1 focus:outline-none">
                                        <span>Lihat Semua Tanggapan ({{ count($stats['text_responses']) }})</span>
                                        <svg class="w-4 h-4 transition-transform duration-200" id="text-toggle-svg-{{ $qId }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    @endif
</div>

<!-- TAB CONTENT 2: INDIVIDUAL RESPONSES TABLE -->
<div id="respondents-tab" class="hidden animate-fade-in-up">
    <div class="card-modern overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-modern">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Respondent</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Completed At</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($responses as $index => $response)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-500">
                                {{ $responses->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $survey->is_anonymous ? 'Anonymous Respondent' : ($response->user->name ?? $response->respondent_name ?? 'Unknown') }}
                                </div>
                                @if(!$survey->is_anonymous && isset($response->user))
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $response->user->email }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $response->user_id ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $response->user_id ? 'Registered User' : 'Guest' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 font-medium">
                                {{ $response->completed_at ? $response->completed_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('dashboard.surveys.responses.show', [$survey, $response]) }}" 
                                   class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-semibold transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">No responses yet</h3>
                                <p class="text-gray-500 dark:text-gray-400">There are no completed responses for this survey.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($responses->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                {{ $responses->links() }}
            </div>
        @endif
    </div>
</div>

<!-- CHART JS & SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function switchTab(showId, hideId) {
        // Hide and show tabs
        document.getElementById(showId).classList.remove('hidden');
        document.getElementById(hideId).classList.add('hidden');
        
        // Style active and inactive buttons
        const showBtn = document.getElementById(showId + '-btn');
        const hideBtn = document.getElementById(hideId + '-btn');
        
        showBtn.className = "flex-1 py-3 px-4 rounded-lg font-bold text-sm transition-all duration-200 bg-emerald-600 text-white shadow-md";
        hideBtn.className = "flex-1 py-3 px-4 rounded-lg font-semibold text-sm transition-all duration-200 text-gray-600 hover:text-gray-900 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50";
    }

    function toggleTextCollapse(qId) {
        const feed = document.getElementById('text-feed-' + qId);
        const btn = document.getElementById('text-toggle-btn-' + qId);
        const svg = document.getElementById('text-toggle-svg-' + qId);
        
        if (feed.style.maxHeight === 'none') {
            feed.style.maxHeight = '20rem'; // Reset to original max-h-80 (20rem)
            btn.querySelector('span').textContent = 'Lihat Semua Tanggapan (' + feed.children.length + ')';
            svg.style.transform = 'rotate(0deg)';
        } else {
            feed.style.maxHeight = 'none';
            btn.querySelector('span').textContent = 'Sembunyikan Tanggapan';
            svg.style.transform = 'rotate(180deg)';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        @if($totalResponses > 0 && $totalLikertAnswers > 0)
        const ctx = document.getElementById('overallLikertChart').getContext('2d');
        
        // HSL tailored vibrant premium color palette matching our gradient scales
        const colors = {
            5: '#10B981', // green-500 (Sangat Baik)
            4: '#34D399', // emerald-400 (Baik)
            3: '#FBBF24', // amber-400 (Netral)
            2: '#F97316', // orange-500 (Buruk)
            1: '#EF4444'  // red-500 (Sangat Buruk)
        };
        
        const labels = [];
        const data = [];
        const bgColors = [];
        
        @foreach($overallLikertDistribution as $val => $data)
            labels.push("{{ $data['label'] }}");
            data.push({{ $data['count'] }});
            bgColors.push(colors[{{ $val }}] || '#6B7280');
        @endforeach
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: bgColors,
                    borderWidth: 2,
                    borderColor: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.95)',
                        titleFont: { size: 13, weight: 'bold', family: 'Inter' },
                        bodyFont: { size: 12, family: 'Inter' },
                        padding: 12,
                        borderRadius: 12,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const value = context.raw;
                                const percentage = round((value / total) * 100, 1);
                                return ` ${context.label}: ${value} respon (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '75%'
            }
        });
        
        function round(value, precision) {
            var multiplier = Math.pow(10, precision || 0);
            return Math.round(value * multiplier) / multiplier;
        }
        @endif
    });
</script>

<style>
    /* Premium custom scrollbar styling */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.3);
        border-radius: 9999px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(156, 163, 175, 0.5);
    }
</style>
@endsection
