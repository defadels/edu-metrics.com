@extends('layouts.dashboard')

@section('title', 'Detail Responden')
@section('page-title', 'Detail Profil Responden')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4 animate-fade-in-up">
        <div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Profil: {{ $respondent->name }}</h3>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Melihat informasi profil dan riwayat kuesioner</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('dashboard.respondents.index') }}"
                class="btn-modern bg-gray-600 hover:bg-gray-700 text-white inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Profil Info -->
        <div class="lg:col-span-1">
            <div class="card-modern h-full">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col items-center text-center">
                    <div
                        class="w-24 h-24 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center text-3xl font-bold mb-4">
                        {{ substr($respondent->name, 0, 1) }}
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $respondent->name }}</h4>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ $respondent->email }}</p>
                </div>

                <div class="p-6">
                    <h5 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Informasi
                        Tambahan</h5>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm text-gray-500 dark:text-gray-400">NIM / Nomor Induk</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                                {{ $respondent->nim ?? 'Tidak ada data' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm text-gray-500 dark:text-gray-400">Program Studi</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                                {{ $respondent->program_study ?? 'Tidak ada data' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm text-gray-500 dark:text-gray-400">Tanggal Mendaftar</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                                {{ $respondent->created_at->format('d M Y, H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500 dark:text-gray-400">Total Kuesioner Selesai</dt>
                            <dd class="mt-2">
                                <span
                                    class="px-3 py-1 text-xs font-bold rounded-lg bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                    {{ $respondent->responses->count() }} Kuesioner
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Riwayat Survey -->
        <div class="lg:col-span-2">
            <div class="card-modern h-full">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Pengisian Kuesioner</h4>
                    <p class="text-gray-500 text-sm mt-1">Daftar kuesioner yang telah diselesaikan oleh responden ini.</p>
                </div>

                <div class="p-0">
                    @if ($respondent->responses->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-modern">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Judul Kuesioner</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Kategori</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Tanggal Selesai</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($respondent->responses as $response)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                    {{ $response->survey->title }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300">
                                                    {{ $response->survey->category->name }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $response->completed_at ? $response->completed_at->format('d M Y, H:i') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <a href="{{ route('dashboard.surveys.responses.show', [$response->survey, $response]) }}"
                                                    class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-semibold transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat Jawaban
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-12 text-center px-6">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h5 class="text-base font-bold text-gray-900 dark:text-white mb-1">Belum ada aktivitas</h5>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Responden ini belum pernah menyelesaikan
                                kuesioner apapun.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
