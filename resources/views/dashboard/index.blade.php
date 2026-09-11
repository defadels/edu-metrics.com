@extends('layouts.dashboard')

@section('title', 'Quality Dashboard')
@section('page-title', 'Quality Dashboard')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="max-w-2xl text-base leading-relaxed text-gray-600 dark:text-gray-400">
                    Monitor participation, satisfaction levels, and areas for improvement in student services at a glance.
                </p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Last updated {{ now()->locale('en')->translatedFormat('d M Y, H:i') }} WIB
                </p>
            </div>
            <a href="{{ route('dashboard.surveys.index') }}"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-[#8B0000] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#720000] focus:outline-none focus:ring-2 focus:ring-[#8B0000] focus:ring-offset-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Manage Surveys
            </a>
        </section>

        <section aria-label="Metric summary" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
            <article class="rounded-2xl border border-gray-200 border-l-4 border-l-blue-600 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Surveys</p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-gray-950 dark:text-white">{{ number_format($stats['surveys']) }}</p>
                        <p class="mt-1 text-sm font-medium text-blue-700 dark:text-blue-300">{{ $stats['active_surveys'] }} currently active</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-gray-200 border-l-4 border-l-emerald-600 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Completed Responses</p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-gray-950 dark:text-white">{{ number_format($stats['responses']) }}</p>
                        <p class="mt-1 text-sm font-medium text-emerald-700 dark:text-emerald-300">Ready for analysis</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-gray-200 border-l-4 border-l-violet-600 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Satisfaction Index</p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-gray-950 dark:text-white">{{ $totalLikertAnswers > 0 ? number_format($stats['average_satisfaction'], 2) : '-' }}</p>
                        <p class="mt-1 text-sm font-medium text-violet-700 dark:text-violet-300">out of {{ number_format($maxLikert) }} points</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-950/50 dark:text-violet-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.969 0 1.371 1.24.588 1.81l-3.97 2.885a1 1 0 00-.364 1.118l1.517 4.67c.3.922-.755 1.688-1.54 1.119l-3.97-2.885a1 1 0 00-1.176 0l-3.97 2.885c-.784.57-1.838-.197-1.539-1.119l1.517-4.67a1 1 0 00-.363-1.118L3.1 10.1c-.783-.57-.38-1.81.588-1.81h4.907a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-gray-200 border-l-4 border-l-amber-500 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Positive Responses</p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-gray-950 dark:text-white">{{ $totalLikertAnswers > 0 ? number_format($stats['satisfaction_percentage'], 1) . '%' : '-' }}</p>
                        <p class="mt-1 text-sm font-medium text-amber-700 dark:text-amber-300">Satisfied & very satisfied</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/50 dark:text-amber-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-gray-200 border-l-4 border-l-rose-500 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Saran Mahasiswa</p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-gray-950 dark:text-white">{{ number_format($stats['total_suggestions']) }}</p>
                        <p class="mt-1 text-sm font-medium text-rose-700 dark:text-rose-300">Aspirasi tertulis</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-950/50 dark:text-rose-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-gray-200 border-l-4 border-l-cyan-600 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Study Programs</p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-gray-950 dark:text-white">{{ number_format($stats['program_studies']) }}</p>
                        <p class="mt-1 text-sm font-medium text-cyan-700 dark:text-cyan-300">Recorded in system</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 dark:bg-cyan-950/50 dark:text-cyan-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4M4 3h16a1 1 0 011 1v11a2 2 0 01-2 2H5a2 2 0 01-2-2V4a1 1 0 011-1zM7 7h10M7 11h6" />
                        </svg>
                    </span>
                </div>
            </article>
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-5">
            <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 xl:col-span-3 sm:p-6">
                <div class="mb-6 flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-950 dark:text-white">Satisfaction by Survey Category</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Average Likert response by category</p>
                    </div>
                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 dark:bg-blue-950/50 dark:text-blue-300">Scale {{ $minLikert }}–{{ $maxLikert }}</span>
                </div>
                @forelse ($categoryScores as $category)
                    <div class="mb-5 last:mb-0">
                        <div class="mb-2 flex items-center justify-between gap-4 text-sm">
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $category->name }}</span>
                            <span class="shrink-0 font-extrabold text-gray-950 dark:text-white">{{ number_format($category->average_score, 2) }} <span class="font-medium text-gray-400">/ {{ $maxLikert }}</span></span>
                        </div>
                        <div class="h-3 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-700" role="progressbar" aria-label="Score for category {{ $category->name }}" aria-valuenow="{{ $category->average_score }}" aria-valuemin="{{ $minLikert }}" aria-valuemax="{{ $maxLikert }}">
                            <div class="h-full rounded-full bg-gradient-to-r from-blue-600 to-cyan-400" style="width: {{ $category->percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="flex min-h-64 flex-col items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 text-center dark:border-gray-600 dark:bg-gray-900/30">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-400 shadow-sm dark:bg-gray-800">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6V7m4 10v-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        </span>
                        <p class="mt-4 font-bold text-gray-800 dark:text-gray-200">No category data yet</p>
                        <p class="mt-1 max-w-md text-sm text-gray-500 dark:text-gray-400">Scores will appear after completed Likert responses are submitted.</p>
                    </div>
                @endforelse
            </article>

            <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 xl:col-span-2 sm:p-6">
                <h3 class="text-lg font-extrabold text-gray-950 dark:text-white">Satisfaction Level Distribution</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Distribution of all Likert responses</p>
                <div class="mt-6 flex flex-col items-center gap-6 sm:flex-row sm:justify-center">
                    <div class="relative h-48 w-48 shrink-0 rounded-full" style="background: conic-gradient({{ $satisfactionGradient }})" role="img" aria-label="Distribution of {{ number_format($totalLikertAnswers) }} Likert responses">
                        <div class="absolute inset-9 flex flex-col items-center justify-center rounded-full bg-white text-center shadow-inner dark:bg-gray-800">
                            <strong class="text-2xl font-black text-gray-950 dark:text-white">{{ number_format($totalLikertAnswers) }}</strong>
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Responses</span>
                        </div>
                    </div>
                    <div class="w-full space-y-2.5">
                        @foreach ($satisfactionDistribution as $item)
                            <div class="flex items-center justify-between gap-4 text-sm">
                                <span class="flex min-w-0 items-center gap-2 text-gray-600 dark:text-gray-300"><span class="h-2.5 w-2.5 shrink-0 rounded-full" style="background-color: {{ $item['color'] }}"></span><span class="truncate">{{ $item['label'] }}</span></span>
                                <strong class="shrink-0 text-gray-950 dark:text-white">{{ number_format($item['percentage'], 1) }}%</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            </article>
        </section>

        <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                <div><h3 class="text-lg font-extrabold text-gray-950 dark:text-white">Satisfaction Index Trend</h3><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Average response changes over the last six months</p></div>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">All surveys</span>
            </div>
            @if ($trendPoints !== '')
                <div class="mt-6 overflow-x-auto">
                    <div class="min-w-[680px]">
                        <svg class="h-52 w-full" viewBox="0 0 600 155" preserveAspectRatio="none" role="img" aria-label="Satisfaction trend chart for the last six months">
                            <defs><linearGradient id="trendStroke" x1="0" x2="1"><stop offset="0%" stop-color="#2563eb" /><stop offset="100%" stop-color="#06b6d4" /></linearGradient></defs>
                            @foreach ([20, 47.5, 75, 102.5, 130] as $gridY)
                                <line x1="20" x2="580" y1="{{ $gridY }}" y2="{{ $gridY }}" stroke="currentColor" class="text-gray-200 dark:text-gray-700" stroke-width="1" />
                            @endforeach
                            @if ($satisfactionTrend->whereNotNull('average')->count() > 1)
                                <polyline points="{{ $trendPoints }}" fill="none" stroke="url(#trendStroke)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                            @endif
                            @foreach ($satisfactionTrend as $point)
                                @if ($point['y'] !== null)
                                    <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="6" fill="#ffffff" stroke="#2563eb" stroke-width="4" />
                                    <text x="{{ $point['x'] }}" y="{{ max(14, $point['y'] - 12) }}" text-anchor="middle" class="fill-gray-900 text-xs font-bold dark:fill-white">{{ number_format($point['average'], 2) }}</text>
                                @endif
                            @endforeach
                        </svg>
                        <div class="grid grid-cols-6 gap-2 px-1 text-center text-xs font-semibold text-gray-500 dark:text-gray-400">
                            @foreach ($satisfactionTrend as $point)<span>{{ $point['label'] }}</span>@endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-6 flex min-h-48 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 text-center text-sm text-gray-500 dark:border-gray-600 dark:bg-gray-900/30 dark:text-gray-400">The trend will appear after Likert responses have been collected.</div>
            @endif
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            @foreach ([['items' => $topIndicators, 'title' => 'Top 5 Indicators', 'subtitle' => 'Service strengths to maintain', 'color' => 'emerald'], ['items' => $lowestIndicators, 'title' => 'Bottom 5 Indicators', 'subtitle' => 'Priorities for evaluation and follow-up', 'color' => 'rose']] as $group)
                <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                    <div class="mb-5 flex items-center justify-between gap-4">
                        <div><h3 class="text-lg font-extrabold {{ $group['color'] === 'emerald' ? 'text-emerald-700 dark:text-emerald-300' : 'text-rose-700 dark:text-rose-300' }}">{{ $group['title'] }}</h3><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $group['subtitle'] }}</p></div>
                        <svg class="h-6 w-6 {{ $group['color'] === 'emerald' ? 'text-emerald-600' : 'text-rose-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $group['color'] === 'emerald' ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}" /></svg>
                    </div>
                    <ol class="space-y-4">
                        @forelse ($group['items'] as $indicator)
                            <li>
                                <div class="flex items-start gap-3">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-xs font-black {{ $group['color'] === 'emerald' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300' : 'bg-rose-50 text-rose-700 dark:bg-rose-950/50 dark:text-rose-300' }}">{{ $loop->iteration }}</span>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-start justify-between gap-4"><p class="text-sm font-semibold leading-snug text-gray-800 dark:text-gray-200">{{ $indicator['question'] }}</p><strong class="shrink-0 text-sm text-gray-950 dark:text-white">{{ number_format($indicator['average'], 2) }}</strong></div>
                                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-700"><div class="h-full rounded-full {{ $group['color'] === 'emerald' ? 'bg-emerald-500' : 'bg-rose-500' }}" style="width: {{ $indicator['percentage'] }}%"></div></div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="rounded-xl bg-gray-50 px-4 py-8 text-center text-sm text-gray-500 dark:bg-gray-900/30 dark:text-gray-400">No indicators are available for comparison yet.</li>
                        @endforelse
                    </ol>
                </article>
            @endforeach
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-5">
            <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 xl:col-span-3 sm:p-6">
                <div class="mb-6"><h3 class="text-lg font-extrabold text-gray-950 dark:text-white">Response Distribution by Study Program</h3><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">The six study programs with the most completed responses</p></div>
                <div class="space-y-4">
                    @forelse ($programStudyDistribution as $study)
                        <div class="grid grid-cols-[minmax(0,1fr)_auto] items-center gap-x-4 gap-y-2 sm:grid-cols-[minmax(160px,0.8fr)_minmax(180px,2fr)_auto]">
                            <span class="truncate text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $study->program_study }}</span>
                            <div class="col-span-2 h-2.5 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-700 sm:col-span-1"><div class="h-full rounded-full bg-gradient-to-r from-cyan-500 to-blue-600" style="width: {{ $study->percentage }}%"></div></div>
                            <strong class="row-start-1 text-sm text-gray-950 dark:text-white sm:row-auto">{{ number_format($study->total) }}</strong>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center dark:border-gray-600 dark:bg-gray-900/30"><p class="font-bold text-gray-800 dark:text-gray-200">Study program data is not available yet</p><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Add study programs to user profiles to display the response distribution.</p></div>
                    @endforelse
                </div>
            </article>

            @php
                $insightTheme = match ($insight['tone']) {
                    'positive' => ['bg' => 'bg-emerald-50 dark:bg-emerald-950/30', 'border' => 'border-emerald-200 dark:border-emerald-900', 'icon' => 'bg-emerald-600'],
                    'warning' => ['bg' => 'bg-amber-50 dark:bg-amber-950/30', 'border' => 'border-amber-200 dark:border-amber-900', 'icon' => 'bg-amber-500'],
                    'critical' => ['bg' => 'bg-rose-50 dark:bg-rose-950/30', 'border' => 'border-rose-200 dark:border-rose-900', 'icon' => 'bg-rose-600'],
                    default => ['bg' => 'bg-blue-50 dark:bg-blue-950/30', 'border' => 'border-blue-200 dark:border-blue-900', 'icon' => 'bg-blue-600'],
                };
            @endphp
            <article class="rounded-2xl border {{ $insightTheme['border'] }} {{ $insightTheme['bg'] }} p-5 shadow-sm xl:col-span-2 sm:p-6">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $insightTheme['icon'] }} text-white shadow-sm"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3a6 6 0 00-3.6 10.8c.45.338.6.77.6 1.2h6c0-.43.15-.862.6-1.2A6 6 0 0012 3zM10 21h4" /></svg></span>
                    <div><p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Insights and Recommendations</p><h3 class="mt-1 text-lg font-extrabold leading-snug text-gray-950 dark:text-white">{{ $insight['title'] }}</h3></div>
                </div>
                <div class="mt-5 space-y-3 text-sm leading-relaxed text-gray-700 dark:text-gray-200"><p>{{ $insight['summary'] }}</p><p><strong>Next focus:</strong> {{ $insight['recommendation'] }}</p></div>
                <a href="{{ route('dashboard.surveys.index') }}" class="mt-6 inline-flex min-h-10 items-center gap-2 rounded-lg bg-white px-3.5 py-2 text-sm font-bold text-gray-800 shadow-sm ring-1 ring-black/5 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">View survey findings<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></a>
            </article>
        </section>

        {{-- SECTION: SUARA & SARAN MASUKAN MAHASISWA --}}
        <section
            x-data="{
                viewMode: 'grid',
                searchQuery: '',
                selectedSurvey: 'all',
                expandedId: null,
                copiedId: null,
                carouselIndex: 0,
                carouselInterval: null,
                isPaused: false,

                items: {{ Js::from($studentSuggestions) }},
                surveys: {{ Js::from($surveysWithSuggestions) }},

                get filteredItems() {
                    return this.items.filter(item => {
                        const matchSurvey = this.selectedSurvey === 'all' || item.survey_id == this.selectedSurvey;
                        if (!matchSurvey) return false;

                        if (!this.searchQuery.trim()) return true;
                        const query = this.searchQuery.toLowerCase();
                        return (item.text_value && item.text_value.toLowerCase().includes(query)) ||
                               (item.respondent_name && item.respondent_name.toLowerCase().includes(query)) ||
                               (item.nim && item.nim.toLowerCase().includes(query)) ||
                               (item.program_study && item.program_study.toLowerCase().includes(query)) ||
                               (item.survey_title && item.survey_title.toLowerCase().includes(query)) ||
                               (item.question_text && item.question_text.toLowerCase().includes(query));
                    });
                },

                copyText(text, id) {
                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(text);
                    } else {
                        let textArea = document.createElement('textarea');
                        textArea.value = text;
                        textArea.style.position = 'fixed';
                        textArea.style.left = '-999999px';
                        document.body.appendChild(textArea);
                        textArea.focus();
                        textArea.select();
                        document.execCommand('copy');
                        textArea.remove();
                    }
                    this.copiedId = id;
                    setTimeout(() => { if (this.copiedId === id) this.copiedId = null; }, 2000);
                },

                nextSlide() {
                    if (this.filteredItems.length === 0) return;
                    this.carouselIndex = (this.carouselIndex + 1) % this.filteredItems.length;
                },

                prevSlide() {
                    if (this.filteredItems.length === 0) return;
                    this.carouselIndex = (this.carouselIndex - 1 + this.filteredItems.length) % this.filteredItems.length;
                },

                startAutoPlay() {
                    this.stopAutoPlay();
                    this.carouselInterval = setInterval(() => {
                        if (!this.isPaused && this.viewMode === 'carousel' && this.filteredItems.length > 1) {
                            this.nextSlide();
                        }
                    }, 5000);
                },

                stopAutoPlay() {
                    if (this.carouselInterval) {
                        clearInterval(this.carouselInterval);
                        this.carouselInterval = null;
                    }
                },

                init() {
                    this.startAutoPlay();
                    this.$watch('selectedSurvey', () => { this.carouselIndex = 0; });
                    this.$watch('searchQuery', () => { this.carouselIndex = 0; });
                    this.$watch('viewMode', (val) => {
                        if (val === 'carousel') this.startAutoPlay();
                        else this.stopAutoPlay();
                    });
                }
            }"
            aria-label="Student suggestions section"
            class="relative overflow-hidden rounded-3xl border border-gray-200/80 bg-gradient-to-b from-white via-white to-rose-50/20 p-6 shadow-sm transition-all duration-300 dark:border-gray-700/80 dark:bg-gradient-to-b dark:from-gray-800 dark:via-gray-800 dark:to-gray-850 sm:p-8"
        >
            {{-- Ambient Decorative Glow --}}
            <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-rose-400/10 blur-3xl dark:bg-rose-500/10"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-blue-400/10 blur-3xl dark:bg-blue-500/10"></div>

            {{-- Section Header --}}
            <div class="relative mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700 ring-1 ring-inset ring-rose-600/20 dark:bg-rose-950/50 dark:text-rose-300">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-rose-500"></span>
                        </span>
                        <span>SUARA & MASUKAN MAHASISWA</span>
                    </div>
                    <h3 class="mt-2 text-xl font-black tracking-tight text-gray-950 dark:text-white sm:text-2xl">
                        Kotak Saran & Aspirasi Responden
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Masukan kualitatif, kritik membangun, dan rekomendasi layanan dari input pertanyaan terbuka kuesioner.
                    </p>
                </div>

                {{-- Header Actions / View Mode Toggle --}}
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-gray-100 px-3 py-1.5 text-xs font-extrabold text-gray-700 dark:bg-gray-700/60 dark:text-gray-200">
                        <svg class="h-4 w-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <span x-text="filteredItems.length + ' Masukan'"></span>
                    </span>

                    <div class="flex items-center rounded-xl bg-gray-100 p-1 dark:bg-gray-700/60">
                        <button
                            type="button"
                            @click="viewMode = 'grid'"
                            :class="viewMode === 'grid' ? 'bg-white text-gray-900 shadow-sm dark:bg-gray-850 dark:text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white'"
                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-bold transition-all duration-200"
                            title="Tampilan Grid Kartu"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span class="hidden sm:inline">Grid Kartu</span>
                        </button>
                        <button
                            type="button"
                            @click="viewMode = 'carousel'"
                            :class="viewMode === 'carousel' ? 'bg-white text-gray-900 shadow-sm dark:bg-gray-850 dark:text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white'"
                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-bold transition-all duration-200"
                            title="Tampilan Slider Interaktif"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                            </svg>
                            <span class="hidden sm:inline">Slider Fokus</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Filter & Search Toolbar --}}
            <template x-if="items.length > 0">
                <div class="relative mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-y border-gray-100 py-3 dark:border-gray-700/60">
                    {{-- Survey Filter Pills --}}
                    <div class="flex flex-wrap items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                        <button
                            type="button"
                            @click="selectedSurvey = 'all'"
                            :class="selectedSurvey === 'all' ? 'bg-rose-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700/70 dark:text-gray-300 dark:hover:bg-gray-700'"
                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-bold transition-all duration-200"
                        >
                            <span>Semua Survei</span>
                            <span class="rounded-full bg-white/20 px-1.5 py-0.2 text-[10px]" x-text="items.length"></span>
                        </button>

                        <template x-for="s in surveys" :key="s.id">
                            <button
                                type="button"
                                @click="selectedSurvey = s.id"
                                :class="selectedSurvey == s.id ? 'bg-rose-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700/70 dark:text-gray-300 dark:hover:bg-gray-700'"
                                class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-bold transition-all duration-200 whitespace-nowrap"
                            >
                                <span x-text="s.title"></span>
                                <span class="rounded-full bg-black/10 dark:bg-white/10 px-1.5 py-0.2 text-[10px]" x-text="s.count"></span>
                            </button>
                        </template>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative w-full sm:w-64">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            x-model="searchQuery"
                            placeholder="Cari saran, mahasiswa, prodi..."
                            class="w-full rounded-xl border border-gray-200 bg-white py-1.5 pl-9 pr-8 text-xs font-medium text-gray-800 placeholder-gray-400 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500/20 dark:border-gray-700 dark:bg-gray-900/60 dark:text-gray-200 dark:placeholder-gray-500"
                        />
                        <button
                            type="button"
                            x-show="searchQuery"
                            @click="searchQuery = ''"
                            class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                        >
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </template>

            {{-- 1. GRID VIEW MODE --}}
            <div x-show="viewMode === 'grid'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <template x-if="filteredItems.length > 0">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                        <template x-for="(item, idx) in filteredItems" :key="item.id">
                            <article
                                class="group relative flex flex-col justify-between overflow-hidden rounded-2xl border border-gray-200/80 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:border-rose-400 hover:shadow-xl hover:shadow-rose-500/5 dark:border-gray-700/80 dark:bg-gray-900/50 dark:hover:border-rose-500 sm:p-6"
                            >
                                {{-- Background Quote Watermark --}}
                                <svg class="pointer-events-none absolute right-3 top-3 h-20 w-20 text-gray-100 opacity-60 transition-all duration-300 group-hover:scale-110 group-hover:text-rose-100 dark:text-gray-800/40 dark:group-hover:text-rose-950/40" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                </svg>

                                <div class="relative z-10">
                                    {{-- Respondent Header --}}
                                    <div class="flex items-start gap-3.5">
                                        <div
                                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-tr font-black text-white shadow-md text-sm"
                                            :class="item.avatar_gradient"
                                            x-text="item.avatar_initials"
                                        ></div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-2">
                                                <h4 class="truncate text-sm font-extrabold text-gray-900 dark:text-white" x-text="item.respondent_name"></h4>
                                                <template x-if="!item.is_anonymous">
                                                    <span class="inline-flex shrink-0 items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-950/40 dark:text-emerald-300">
                                                        Mahasiswa
                                                    </span>
                                                </template>
                                                <template x-if="item.is_anonymous">
                                                    <span class="inline-flex shrink-0 items-center rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-bold text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                                        Anonim
                                                    </span>
                                                </template>
                                            </div>
                                            <div class="mt-0.5 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-gray-500 dark:text-gray-400">
                                                <template x-if="item.nim">
                                                    <span class="font-semibold text-gray-700 dark:text-gray-300" x-text="'NIM: ' + item.nim"></span>
                                                </template>
                                                <template x-if="item.program_study">
                                                    <span class="rounded bg-blue-50 px-1.5 py-0.5 text-[11px] font-medium text-blue-700 dark:bg-blue-950/50 dark:text-blue-300" x-text="item.program_study"></span>
                                                </template>
                                                <span class="text-[11px] text-gray-400" x-text="item.time_ago"></span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Survey & Question Tags --}}
                                    <div class="mt-4 flex flex-wrap items-center gap-1.5">
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-gray-100 px-2.5 py-1 text-[11px] font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                            <svg class="h-3 w-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span class="truncate max-w-[200px]" x-text="item.survey_title"></span>
                                        </span>
                                        <span class="inline-flex items-center rounded-lg bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700 dark:bg-rose-950/40 dark:text-rose-300">
                                            <span class="truncate max-w-[220px]" x-text="'Q: ' + item.question_text"></span>
                                        </span>
                                    </div>

                                    {{-- Feedback Message Content --}}
                                    <div class="mt-3.5 rounded-xl border-l-4 border-rose-500 bg-rose-50/30 p-3.5 text-sm leading-relaxed text-gray-800 dark:border-rose-400 dark:bg-rose-950/20 dark:text-gray-200">
                                        <p class="italic">
                                            “<span x-text="(expandedId === item.id || item.text_value.length <= 150) ? item.text_value : (item.text_value.substring(0, 150) + '...')"></span>”
                                        </p>
                                        <template x-if="item.text_value.length > 150">
                                            <button
                                                type="button"
                                                @click="expandedId = (expandedId === item.id ? null : item.id)"
                                                class="mt-2 inline-flex items-center text-xs font-bold text-rose-600 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300"
                                            >
                                                <span x-text="expandedId === item.id ? 'Sembunyikan' : 'Baca Selengkapnya'"></span>
                                                <svg class="ml-1 h-3.5 w-3.5 transition-transform" :class="expandedId === item.id ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                        </template>
                                    </div>
                                </div>

                                {{-- Card Footer --}}
                                <div class="relative z-10 mt-4 flex items-center justify-between border-t border-gray-100 pt-3 dark:border-gray-800">
                                    <span class="text-[11px] text-gray-400 font-medium" x-text="item.submitted_at"></span>

                                    <div class="flex items-center gap-2">
                                        <button
                                            type="button"
                                            @click="copyText(item.text_value, item.id)"
                                            class="inline-flex items-center gap-1 rounded-lg px-2 py-1 text-xs font-semibold text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition-colors"
                                            title="Salin isi saran"
                                        >
                                            <template x-if="copiedId === item.id">
                                                <span class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-bold">
                                                    <svg class="h-3.5 w-3.5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>Tersalin</span>
                                                </span>
                                            </template>
                                            <template x-if="copiedId !== item.id">
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>Salin</span>
                                                </span>
                                            </template>
                                        </button>

                                        <a
                                            :href="'{{ url('dashboard/surveys') }}/' + item.survey_id + '/responses/' + item.response_id"
                                            class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1 text-xs font-bold text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-950/50 transition-colors"
                                            title="Buka detail respon"
                                        >
                                            <span>Detail</span>
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </template>
                    </div>
                </template>
            </div>

            {{-- 2. CAROUSEL / SLIDER VIEW MODE --}}
            <div
                x-show="viewMode === 'carousel'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                @mouseenter="isPaused = true"
                @mouseleave="isPaused = false"
                class="relative"
            >
                <template x-if="filteredItems.length > 0">
                    <div class="relative overflow-hidden rounded-3xl border border-rose-200/80 bg-gradient-to-br from-white via-rose-50/40 to-white p-6 sm:p-10 shadow-lg dark:border-rose-900/50 dark:from-gray-900 dark:via-gray-850 dark:to-gray-900">
                        {{-- Watermark Quote in Carousel --}}
                        <svg class="pointer-events-none absolute right-8 top-8 h-32 w-32 text-rose-200/50 dark:text-rose-950/40" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>

                        <div class="relative z-10 max-w-4xl mx-auto flex flex-col items-center text-center">
                            {{-- Carousel Navigation Top indicator --}}
                            <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-rose-100/80 px-3 py-1 text-xs font-bold text-rose-800 dark:bg-rose-950/80 dark:text-rose-300">
                                <span x-text="'Masukan #' + (carouselIndex + 1) + ' dari ' + filteredItems.length"></span>
                            </div>

                            {{-- Active Slide Item --}}
                            <div class="w-full">
                                <template x-for="(item, idx) in filteredItems" :key="item.id">
                                    <div x-show="carouselIndex === idx" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                                        {{-- Large Quote Text --}}
                                        <blockquote class="text-xl sm:text-2xl font-bold leading-relaxed text-gray-900 dark:text-white italic px-4">
                                            “<span x-text="item.text_value"></span>”
                                        </blockquote>

                                        {{-- Survey Context --}}
                                        <div class="flex flex-wrap items-center justify-center gap-2 text-xs font-semibold text-gray-500 dark:text-gray-400">
                                            <span class="rounded-lg bg-gray-100 px-3 py-1 dark:bg-gray-800 dark:text-gray-300" x-text="'Survei: ' + item.survey_title"></span>
                                            <span class="rounded-lg bg-rose-50 px-3 py-1 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300" x-text="'Pertanyaan: ' + item.question_text"></span>
                                        </div>

                                        {{-- Respondent Profile --}}
                                        <div class="flex flex-col items-center justify-center pt-2">
                                            <div
                                                class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-tr font-black text-white shadow-lg text-lg mb-2"
                                                :class="item.avatar_gradient"
                                                x-text="item.avatar_initials"
                                            ></div>
                                            <h4 class="text-base font-extrabold text-gray-950 dark:text-white" x-text="item.respondent_name"></h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                <span x-text="item.program_study || 'Mahasiswa UNIBBA'"></span>
                                                <template x-if="item.nim">
                                                    <span x-text="' • ' + item.nim"></span>
                                                </template>
                                                <span x-text="' • ' + item.time_ago"></span>
                                            </p>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            {{-- Carousel Controls: Prev, Dots, Next --}}
                            <div class="mt-8 flex items-center justify-center gap-4 w-full">
                                <button
                                    type="button"
                                    @click="prevSlide()"
                                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-gray-700 shadow-md ring-1 ring-black/5 hover:bg-gray-50 hover:scale-105 active:scale-95 transition-all dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-750"
                                    title="Saran Sebelumnya"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>

                                {{-- Pagination Dots --}}
                                <div class="flex items-center gap-1.5 max-w-[200px] overflow-x-auto py-1">
                                    <template x-for="(item, idx) in filteredItems" :key="item.id">
                                        <button
                                            type="button"
                                            @click="carouselIndex = idx"
                                            class="h-2 rounded-full transition-all duration-300"
                                            :class="carouselIndex === idx ? 'w-6 bg-rose-600 dark:bg-rose-500' : 'w-2 bg-gray-300 hover:bg-gray-400 dark:bg-gray-700'"
                                        ></button>
                                    </template>
                                </div>

                                <button
                                    type="button"
                                    @click="nextSlide()"
                                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-gray-700 shadow-md ring-1 ring-black/5 hover:bg-gray-50 hover:scale-105 active:scale-95 transition-all dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-750"
                                    title="Saran Selanjutnya"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- 3. EMPTY STATE (When no suggestions match search or no text answers in database) --}}
            <template x-if="filteredItems.length === 0">
                <div class="flex min-h-[300px] flex-col items-center justify-center rounded-2xl border border-dashed border-gray-300 bg-white/60 p-8 text-center dark:border-gray-700 dark:bg-gray-900/30">
                    <div class="relative flex h-16 w-16 items-center justify-center rounded-3xl bg-rose-50 text-rose-600 shadow-sm dark:bg-rose-950/50 dark:text-rose-400 animate-float-slow mb-4">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>

                    <template x-if="items.length > 0 && searchQuery">
                        <div>
                            <h4 class="text-base font-extrabold text-gray-900 dark:text-white">Tidak ada saran yang cocok</h4>
                            <p class="mt-1 max-w-md text-xs text-gray-500 dark:text-gray-400">
                                Tidak ditemukan saran mahasiswa dengan kata kunci "<span class="font-bold text-gray-700 dark:text-gray-300" x-text="searchQuery"></span>".
                            </p>
                            <button
                                type="button"
                                @click="searchQuery = ''; selectedSurvey = 'all'"
                                class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-gray-100 px-4 py-2 text-xs font-bold text-gray-800 hover:bg-gray-200 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition-all"
                            >
                                <span>Reset Filter Pencarian</span>
                            </button>
                        </div>
                    </template>

                    <template x-if="items.length === 0">
                        <div>
                            <h4 class="text-base font-extrabold text-gray-900 dark:text-white">Belum Ada Masukan Saran Mahasiswa</h4>
                            <p class="mt-1.5 max-w-md text-xs leading-relaxed text-gray-500 dark:text-gray-400">
                                Masukan tertulis akan otomatis tampil di sini ketika admin menambahkan pertanyaan tipe <strong>Teks</strong> pada kuesioner dan mahasiswa mengisi saran/masukannya.
                            </p>
                            <div class="mt-5 flex flex-wrap items-center justify-center gap-3">
                                <a
                                    href="{{ route('dashboard.questions.create') }}"
                                    class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all transform hover:-translate-y-0.5"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Buat Pertanyaan Saran di Survei</span>
                                </a>
                                <a
                                    href="{{ route('dashboard.surveys.index') }}"
                                    class="inline-flex items-center gap-2 rounded-xl bg-gray-100 px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-all"
                                >
                                    <span>Kelola Survei</span>
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </section>

        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-5 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div><h3 class="text-lg font-extrabold text-gray-950 dark:text-white">Recent Surveys</h3><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Survey periods, status, and completed response totals</p></div>
                <a href="{{ route('dashboard.surveys.index') }}" class="text-sm font-bold text-blue-700 hover:underline dark:text-blue-300">View all surveys</a>
            </div>
            @if ($recentSurveys->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/40"><tr><th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500 sm:px-6">Survey</th><th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Period</th><th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status</th><th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Responses</th><th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500 sm:px-6">Actions</th></tr></thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($recentSurveys as $survey)
                                @php $isRunning = $survey->is_active && $survey->start_date->lte(now()) && $survey->end_date->gte(now()); @endphp
                                <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                    <td class="max-w-sm px-5 py-4 sm:px-6"><p class="truncate text-sm font-bold text-gray-900 dark:text-white">{{ $survey->title }}</p><p class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400">{{ $survey->category?->name ?? 'Uncategorized' }}</p></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $survey->start_date->format('d M Y') }} – {{ $survey->end_date->format('d M Y') }}</td>
                                    <td class="whitespace-nowrap px-5 py-4"><span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold {{ $isRunning ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">{{ $isRunning ? 'Active' : 'Inactive' }}</span></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-extrabold text-gray-900 dark:text-white">{{ number_format($survey->completed_responses_count) }}</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right sm:px-6"><a href="{{ route('dashboard.surveys.responses.index', $survey) }}" class="text-sm font-bold text-blue-700 hover:underline dark:text-blue-300">Analyze</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center"><p class="font-bold text-gray-800 dark:text-gray-200">No surveys yet</p><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Create your first survey to start collecting quality data.</p><a href="{{ route('dashboard.surveys.create') }}" class="mt-4 inline-flex rounded-lg bg-[#8B0000] px-4 py-2 text-sm font-bold text-white hover:bg-[#720000]">Create Survey</a></div>
            @endif
        </section>
    </div>
@endsection

