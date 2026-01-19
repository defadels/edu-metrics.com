@extends('layouts.app')

@section('title', 'Survey List')

@section('content')
<div class="bg-theme-primary text-white py-12 mb-10 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">Pilih Instrumen untuk mengisi kuesioner sebagai Mahasiswa</h1>
        <p class="text-white/80">Pilih instrumen kuesioner yang tersedia pada daftar dibawah</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    @if($surveys->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($surveys as $index => $survey)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group flex flex-col">
                    <div class="mb-4">
                        <span class="px-3 py-1 text-xs font-bold rounded-lg bg-gray-100 text-gray-600 uppercase tracking-wider">
                            {{ $survey->category->name }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex-grow">
                        {{ $survey->title }}
                    </h3>

                    @if($survey->description)
                        <p class="text-gray-500 text-sm mb-6 line-clamp-2">
                            {{ $survey->description }}
                        </p>
                    @endif

                    <div class="flex items-center gap-4 text-xs text-gray-400 mb-6 font-medium">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $survey->questions_count }} Soal</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Ends {{ $survey->end_date->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('surveys.show', $survey) }}" 
                       class="w-full text-center py-3.5 bg-theme-active text-white rounded-xl font-bold shadow-lg shadow-theme-active/20 hover:bg-theme-active/90 transform hover:-translate-y-0.5 transition-all">
                        Pilih
                    </a>
                </div>
            @endforeach
        </div>

        @if($surveys->hasPages())
            <div class="mt-12">
                {{ $surveys->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-3xl p-16 text-center shadow-sm border border-gray-100">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 mb-6">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada instrumen tersedia</h3>
            <p class="text-gray-500 mb-8">Silakan cek kembali nanti atau hubungi administrator.</p>
            <a href="{{ route('home') }}" class="text-theme-primary font-bold hover:underline">Kembali ke Home</a>
        </div>
    @endif
</div>
@endsection
