@extends('layouts.dashboard')

@section('title', 'Dashboard Mutu')
@section('page-title', 'Dashboard Mutu')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="max-w-2xl text-base leading-relaxed text-gray-600 dark:text-gray-400">
                    Pantau partisipasi, tingkat kepuasan, dan area perbaikan layanan mahasiswa dalam satu ringkasan.
                </p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Diperbarui {{ now()->locale('id')->translatedFormat('d M Y, H:i') }} WIB
                </p>
            </div>
            <a href="{{ route('dashboard.surveys.index') }}"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-[#8B0000] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#720000] focus:outline-none focus:ring-2 focus:ring-[#8B0000] focus:ring-offset-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Kelola Survei
            </a>
        </section>

        <section aria-label="Ringkasan metrik" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <article class="rounded-2xl border border-gray-200 border-l-4 border-l-blue-600 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Survei</p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-gray-950 dark:text-white">{{ number_format($stats['surveys'], 0, ',', '.') }}</p>
                        <p class="mt-1 text-sm font-medium text-blue-700 dark:text-blue-300">{{ $stats['active_surveys'] }} sedang aktif</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-gray-200 border-l-4 border-l-emerald-600 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Respons Selesai</p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-gray-950 dark:text-white">{{ number_format($stats['responses'], 0, ',', '.') }}</p>
                        <p class="mt-1 text-sm font-medium text-emerald-700 dark:text-emerald-300">Siap dianalisis</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-gray-200 border-l-4 border-l-violet-600 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Indeks Kepuasan</p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-gray-950 dark:text-white">{{ $totalLikertAnswers > 0 ? number_format($stats['average_satisfaction'], 2, ',', '.') : '-' }}</p>
                        <p class="mt-1 text-sm font-medium text-violet-700 dark:text-violet-300">dari {{ number_format($maxLikert, 0, ',', '.') }} poin</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-950/50 dark:text-violet-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.969 0 1.371 1.24.588 1.81l-3.97 2.885a1 1 0 00-.364 1.118l1.517 4.67c.3.922-.755 1.688-1.54 1.119l-3.97-2.885a1 1 0 00-1.176 0l-3.97 2.885c-.784.57-1.838-.197-1.539-1.119l1.517-4.67a1 1 0 00-.363-1.118L3.1 10.1c-.783-.57-.38-1.81.588-1.81h4.907a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-gray-200 border-l-4 border-l-amber-500 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Respons Positif</p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-gray-950 dark:text-white">{{ $totalLikertAnswers > 0 ? number_format($stats['satisfaction_percentage'], 1, ',', '.') . '%' : '-' }}</p>
                        <p class="mt-1 text-sm font-medium text-amber-700 dark:text-amber-300">Puas dan sangat puas</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/50 dark:text-amber-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-gray-200 border-l-4 border-l-cyan-600 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Program Studi</p>
                        <p class="mt-2 text-3xl font-black tracking-tight text-gray-950 dark:text-white">{{ number_format($stats['program_studies'], 0, ',', '.') }}</p>
                        <p class="mt-1 text-sm font-medium text-cyan-700 dark:text-cyan-300">Terdata di sistem</p>
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
                        <h3 class="text-lg font-extrabold text-gray-950 dark:text-white">Kepuasan per Kategori Survei</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Rata-rata jawaban Likert berdasarkan kategori</p>
                    </div>
                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 dark:bg-blue-950/50 dark:text-blue-300">Skala {{ $minLikert }}–{{ $maxLikert }}</span>
                </div>
                @forelse ($categoryScores as $category)
                    <div class="mb-5 last:mb-0">
                        <div class="mb-2 flex items-center justify-between gap-4 text-sm">
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $category->name }}</span>
                            <span class="shrink-0 font-extrabold text-gray-950 dark:text-white">{{ number_format($category->average_score, 2, ',', '.') }} <span class="font-medium text-gray-400">/ {{ $maxLikert }}</span></span>
                        </div>
                        <div class="h-3 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-700" role="progressbar" aria-label="Nilai kategori {{ $category->name }}" aria-valuenow="{{ $category->average_score }}" aria-valuemin="{{ $minLikert }}" aria-valuemax="{{ $maxLikert }}">
                            <div class="h-full rounded-full bg-gradient-to-r from-blue-600 to-cyan-400" style="width: {{ $category->percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="flex min-h-64 flex-col items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 text-center dark:border-gray-600 dark:bg-gray-900/30">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-400 shadow-sm dark:bg-gray-800">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6V7m4 10v-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        </span>
                        <p class="mt-4 font-bold text-gray-800 dark:text-gray-200">Belum ada data kategori</p>
                        <p class="mt-1 max-w-md text-sm text-gray-500 dark:text-gray-400">Nilai akan muncul setelah respons Likert selesai dikirim.</p>
                    </div>
                @endforelse
            </article>

            <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 xl:col-span-2 sm:p-6">
                <h3 class="text-lg font-extrabold text-gray-950 dark:text-white">Distribusi Tingkat Kepuasan</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Komposisi seluruh jawaban Likert</p>
                <div class="mt-6 flex flex-col items-center gap-6 sm:flex-row sm:justify-center">
                    <div class="relative h-48 w-48 shrink-0 rounded-full" style="background: conic-gradient({{ $satisfactionGradient }})" role="img" aria-label="Distribusi {{ number_format($totalLikertAnswers, 0, ',', '.') }} jawaban Likert">
                        <div class="absolute inset-9 flex flex-col items-center justify-center rounded-full bg-white text-center shadow-inner dark:bg-gray-800">
                            <strong class="text-2xl font-black text-gray-950 dark:text-white">{{ number_format($totalLikertAnswers, 0, ',', '.') }}</strong>
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Jawaban</span>
                        </div>
                    </div>
                    <div class="w-full space-y-2.5">
                        @foreach ($satisfactionDistribution as $item)
                            <div class="flex items-center justify-between gap-4 text-sm">
                                <span class="flex min-w-0 items-center gap-2 text-gray-600 dark:text-gray-300"><span class="h-2.5 w-2.5 shrink-0 rounded-full" style="background-color: {{ $item['color'] }}"></span><span class="truncate">{{ $item['label'] }}</span></span>
                                <strong class="shrink-0 text-gray-950 dark:text-white">{{ number_format($item['percentage'], 1, ',', '.') }}%</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            </article>
        </section>

        <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                <div><h3 class="text-lg font-extrabold text-gray-950 dark:text-white">Tren Indeks Kepuasan</h3><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Perubahan rata-rata jawaban dalam enam bulan terakhir</p></div>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Seluruh survei</span>
            </div>
            @if ($trendPoints !== '')
                <div class="mt-6 overflow-x-auto">
                    <div class="min-w-[680px]">
                        <svg class="h-52 w-full" viewBox="0 0 600 155" preserveAspectRatio="none" role="img" aria-label="Grafik tren kepuasan enam bulan terakhir">
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
                                    <text x="{{ $point['x'] }}" y="{{ max(14, $point['y'] - 12) }}" text-anchor="middle" class="fill-gray-900 text-xs font-bold dark:fill-white">{{ number_format($point['average'], 2, ',', '.') }}</text>
                                @endif
                            @endforeach
                        </svg>
                        <div class="grid grid-cols-6 gap-2 px-1 text-center text-xs font-semibold text-gray-500 dark:text-gray-400">
                            @foreach ($satisfactionTrend as $point)<span>{{ $point['label'] }}</span>@endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-6 flex min-h-48 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 text-center text-sm text-gray-500 dark:border-gray-600 dark:bg-gray-900/30 dark:text-gray-400">Tren akan tersedia setelah respons Likert terkumpul.</div>
            @endif
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            @foreach ([['items' => $topIndicators, 'title' => '5 Indikator Tertinggi', 'subtitle' => 'Kekuatan layanan yang perlu dipertahankan', 'color' => 'emerald'], ['items' => $lowestIndicators, 'title' => '5 Indikator Terendah', 'subtitle' => 'Prioritas evaluasi dan tindak lanjut', 'color' => 'rose']] as $group)
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
                                        <div class="flex items-start justify-between gap-4"><p class="text-sm font-semibold leading-snug text-gray-800 dark:text-gray-200">{{ $indicator['question'] }}</p><strong class="shrink-0 text-sm text-gray-950 dark:text-white">{{ number_format($indicator['average'], 2, ',', '.') }}</strong></div>
                                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-700"><div class="h-full rounded-full {{ $group['color'] === 'emerald' ? 'bg-emerald-500' : 'bg-rose-500' }}" style="width: {{ $indicator['percentage'] }}%"></div></div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="rounded-xl bg-gray-50 px-4 py-8 text-center text-sm text-gray-500 dark:bg-gray-900/30 dark:text-gray-400">Belum ada indikator yang dapat dibandingkan.</li>
                        @endforelse
                    </ol>
                </article>
            @endforeach
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-5">
            <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 xl:col-span-3 sm:p-6">
                <div class="mb-6"><h3 class="text-lg font-extrabold text-gray-950 dark:text-white">Distribusi Respons per Program Studi</h3><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enam program studi dengan respons selesai terbanyak</p></div>
                <div class="space-y-4">
                    @forelse ($programStudyDistribution as $study)
                        <div class="grid grid-cols-[minmax(0,1fr)_auto] items-center gap-x-4 gap-y-2 sm:grid-cols-[minmax(160px,0.8fr)_minmax(180px,2fr)_auto]">
                            <span class="truncate text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $study->program_study }}</span>
                            <div class="col-span-2 h-2.5 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-700 sm:col-span-1"><div class="h-full rounded-full bg-gradient-to-r from-cyan-500 to-blue-600" style="width: {{ $study->percentage }}%"></div></div>
                            <strong class="row-start-1 text-sm text-gray-950 dark:text-white sm:row-auto">{{ number_format($study->total, 0, ',', '.') }}</strong>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center dark:border-gray-600 dark:bg-gray-900/30"><p class="font-bold text-gray-800 dark:text-gray-200">Data program studi belum tersedia</p><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lengkapi program studi pengguna agar distribusi respons dapat ditampilkan.</p></div>
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
                    <div><p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Insight dan Rekomendasi</p><h3 class="mt-1 text-lg font-extrabold leading-snug text-gray-950 dark:text-white">{{ $insight['title'] }}</h3></div>
                </div>
                <div class="mt-5 space-y-3 text-sm leading-relaxed text-gray-700 dark:text-gray-200"><p>{{ $insight['summary'] }}</p><p><strong>Fokus berikutnya:</strong> {{ $insight['recommendation'] }}</p></div>
                <a href="{{ route('dashboard.surveys.index') }}" class="mt-6 inline-flex min-h-10 items-center gap-2 rounded-lg bg-white px-3.5 py-2 text-sm font-bold text-gray-800 shadow-sm ring-1 ring-black/5 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">Lihat hasil survei<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></a>
            </article>
        </section>

        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-5 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div><h3 class="text-lg font-extrabold text-gray-950 dark:text-white">Survei Terbaru</h3><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Status periode dan jumlah respons yang sudah selesai</p></div>
                <a href="{{ route('dashboard.surveys.index') }}" class="text-sm font-bold text-blue-700 hover:underline dark:text-blue-300">Lihat semua survei</a>
            </div>
            @if ($recentSurveys->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/40"><tr><th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500 sm:px-6">Survei</th><th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Periode</th><th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status</th><th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Respons</th><th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500 sm:px-6">Aksi</th></tr></thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($recentSurveys as $survey)
                                @php $isRunning = $survey->is_active && $survey->start_date->lte(now()) && $survey->end_date->gte(now()); @endphp
                                <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                    <td class="max-w-sm px-5 py-4 sm:px-6"><p class="truncate text-sm font-bold text-gray-900 dark:text-white">{{ $survey->title }}</p><p class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400">{{ $survey->category?->name ?? 'Tanpa kategori' }}</p></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $survey->start_date->format('d M Y') }} – {{ $survey->end_date->format('d M Y') }}</td>
                                    <td class="whitespace-nowrap px-5 py-4"><span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold {{ $isRunning ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">{{ $isRunning ? 'Aktif' : 'Tidak aktif' }}</span></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-extrabold text-gray-900 dark:text-white">{{ number_format($survey->completed_responses_count, 0, ',', '.') }}</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right sm:px-6"><a href="{{ route('dashboard.surveys.responses.index', $survey) }}" class="text-sm font-bold text-blue-700 hover:underline dark:text-blue-300">Analisis</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center"><p class="font-bold text-gray-800 dark:text-gray-200">Belum ada survei</p><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Buat survei pertama untuk mulai mengumpulkan data mutu.</p><a href="{{ route('dashboard.surveys.create') }}" class="mt-4 inline-flex rounded-lg bg-[#8B0000] px-4 py-2 text-sm font-bold text-white hover:bg-[#720000]">Buat survei</a></div>
            @endif
        </section>
    </div>
@endsection
