@extends('layouts.dashboard')

@section('title', 'Detail Pengguna - ' . $user->name)
@section('page-title', 'Detail Pengguna')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    <!-- Top Back & Actions Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('dashboard.users.index') }}" 
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Daftar Pengguna</span>
        </a>

        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard.users.edit', $user) }}" 
               class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl inline-flex items-center gap-2 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit Pengguna</span>
            </a>

            @if($user->id !== auth()->id())
                <form action="{{ route('dashboard.users.destroy', $user) }}" method="POST" class="inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna \'{{ addslashes($user->name) }}\'? Tindakan ini tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl inline-flex items-center gap-2 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Hapus</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- User Profile Header Card -->
    <div class="card-modern p-6 sm:p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center font-black text-2xl shadow-md {{ $user->isAdmin() ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' }}">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                        @if($user->isAdmin())
                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold rounded-lg bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Administrator
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                                Mahasiswa
                            </span>
                        @endif

                        @if($user->id === auth()->id())
                            <span class="px-2.5 py-0.5 text-xs font-bold rounded bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">Akun Anda</span>
                        @endif
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $user->email }}</span>
                    </p>
                </div>
            </div>

            <!-- Meta Quick Badges -->
            <div class="grid grid-cols-2 gap-4 border-t md:border-t-0 md:border-l border-gray-100 dark:border-gray-700 pt-4 md:pt-0 md:pl-6">
                <div>
                    <span class="text-xs uppercase font-bold text-gray-400 tracking-wider">NIM</span>
                    <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $user->nim ?? '-' }}</p>
                </div>
                <div>
                    <span class="text-xs uppercase font-bold text-gray-400 tracking-wider">Program Studi</span>
                    <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $user->program_study ?? '-' }}</p>
                </div>
                <div>
                    <span class="text-xs uppercase font-bold text-gray-400 tracking-wider">Terdaftar Pada</span>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}</p>
                </div>
                <div>
                    <span class="text-xs uppercase font-bold text-gray-400 tracking-wider">Terakhir Diperbarui</span>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->updated_at ? $user->updated_at->format('d M Y, H:i') : '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Activity Section -->
    @if($user->isMahasiswa())
        <div class="card-modern overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Pengisian Kuesioner</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Total {{ $user->completed_responses_count }} survei telah diselesaikan oleh mahasiswa ini.</p>
                </div>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 font-bold text-sm rounded-xl">
                    {{ $user->responses->count() }} Total Partisipasi
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-modern">
                    <thead>
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Survei</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Waktu Mulai</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Waktu Selesai</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($user->responses as $response)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $response->survey->title ?? 'Survei Tidak Tersedia' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-medium px-2.5 py-1 rounded-md bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                        {{ $response->survey->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $response->started_at ? $response->started_at->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $response->completed_at ? $response->completed_at->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($response->is_completed)
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300">
                                            Sedang Dikerjakan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    @if($response->survey_id)
                                        <a href="{{ route('dashboard.surveys.responses.show', [$response->survey_id, $response->id]) }}" 
                                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 font-semibold text-xs inline-flex items-center gap-1">
                                            <span>Lihat Jawaban</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">
                                    Mahasiswa ini belum pernah mengisi kuesioner.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($user->isAdmin())
        <div class="card-modern overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">Kuesioner yang Dibuat</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Daftar survei yang dipublikasikan atau dibuat oleh administrator ini.</p>
                </div>
                <span class="px-3 py-1 bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300 font-bold text-sm rounded-xl">
                    {{ $user->createdSurveys->count() }} Survei
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-modern">
                    <thead>
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Judul Survei</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Responden</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($user->createdSurveys as $survey)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $survey->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-medium px-2.5 py-1 rounded-md bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                        {{ $survey->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $survey->start_date ? $survey->start_date->format('d M Y') : '-' }} s/d {{ $survey->end_date ? $survey->end_date->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $survey->responses_count }} Respon
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($survey->is_active)
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('dashboard.surveys.show', $survey) }}" 
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 font-semibold text-xs inline-flex items-center gap-1">
                                        <span>Lihat Survei</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">
                                    Administrator ini belum membuat kuesioner.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
