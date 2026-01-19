@extends('layouts.app')

@section('title', $survey->title)

@section('content')
<div class="bg-theme-primary text-white py-12 mb-10 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('surveys.index') }}" class="text-white/60 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <span class="px-3 py-1 text-xs font-bold rounded-lg bg-white/10 text-white uppercase tracking-wider">
                {{ $survey->category->name }}
            </span>
        </div>
        <h1 class="text-3xl font-bold mb-2">{{ $survey->title }}</h1>
        <p class="text-white/80">Informasi detail instrumen kuesioner</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="bg-white rounded-3xl p-8 lg:p-12 shadow-sm border border-gray-100 flex flex-col items-center text-center">
        <div class="w-20 h-20 bg-theme-primary/5 text-theme-primary rounded-2xl flex items-center justify-center mb-8">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $survey->title }}</h2>
        
        @if($survey->description)
            <p class="text-gray-500 mb-10 leading-relaxed max-w-2xl">
                {{ $survey->description }}
            </p>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full mb-10 text-left">
            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100">
                <div class="text-xs text-gray-400 font-bold uppercase mb-1">Jumlah Pertanyaan</div>
                <div class="text-lg font-bold text-gray-900">{{ $survey->questions->count() }} Soal</div>
            </div>
            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100">
                <div class="text-xs text-gray-400 font-bold uppercase mb-1">Batas Waktu Pengisian</div>
                <div class="text-lg font-bold text-gray-900">{{ $survey->end_date->format('d F Y') }}</div>
            </div>
        </div>

        @if($hasResponded)
            <div class="w-full p-6 bg-amber-50 rounded-2xl border border-amber-100 mb-10 flex items-center gap-4 text-left">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-amber-900 leading-tight">Anda Sudah Mengisi Instrumen Ini</h4>
                    <p class="text-amber-700 text-sm">Jawaban Anda sudah kami terima. Terima kasih atas partisipasi Anda.</p>
                </div>
            </div>
        @endif

        <div class="w-full flex flex-col sm:flex-row gap-4">
            <a href="{{ route('surveys.index') }}" 
               class="flex-1 text-center py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-colors">
                Kembali
            </a>
            @if(!$hasResponded)
                <a href="{{ route('surveys.start', $survey) }}" 
                   class="flex-1 text-center py-4 bg-theme-active text-white rounded-2xl font-bold shadow-lg shadow-theme-active/20 hover:bg-theme-active/90 transform hover:-translate-y-0.5 transition-all">
                    Mulai Isi Kuesioner
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
