@extends('layouts.app')

@section('title', 'Riwayat Survei')

@section('content')
<div class="bg-theme-primary text-white py-12 mb-10 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2 uppercase tracking-wide">Riwayat Pengisian Survei</h1>
        <p class="text-white/80">Daftar instrumen kuesioner yang telah anda isi sebelumnya</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center w-16">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Responden</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal Dikirim</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($responses as $index => $response)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-6 text-center text-gray-400 font-medium">
                                {{ $responses->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-6">
                                <div class="font-bold text-gray-900">{{ Auth::user()->name }}</div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="px-3 py-1 text-xs font-bold rounded-lg bg-gray-100 text-gray-600 uppercase">
                                    {{ $response->survey->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="text-gray-900 font-medium">{{ $response->survey->title }}</div>
                            </td>
                            <td class="px-6 py-6 text-gray-500 font-medium">
                                {{ $response->completed_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-6 text-center">
                                <a href="{{ route('surveys.show', $response->survey) }}" class="inline-flex items-center px-4 py-2 bg-theme-primary/10 text-theme-primary rounded-xl font-bold text-sm hover:bg-theme-primary/20 transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada riwayat pengisian</h3>
                                    <p class="text-gray-500 mb-6">Anda belum pernah mengisi kuesioner apapun.</p>
                                    <a href="{{ route('surveys.index') }}" class="px-6 py-3 bg-theme-primary text-white rounded-xl font-bold shadow-lg shadow-theme-primary/20 hover:bg-theme-primary/90 transition-all">
                                        Isi Kuesioner Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($responses->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $responses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
