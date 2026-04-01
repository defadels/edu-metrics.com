@extends('layouts.app')

@section('title', 'Detail Riwayat Survei: ' . $response->survey->title)

@section('content')
<div class="bg-theme-primary text-white py-12 mb-10 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('surveys.history') }}" class="p-2 bg-white/10 hover:bg-white/20 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold uppercase tracking-wide">Detail Riwayat Survei</h1>
        </div>
        <p class="text-white/80">
            {{ $response->survey->title }} 
            <span class="inline-block px-3 py-1 ml-3 text-xs font-bold rounded-full bg-white text-theme-primary">
                Diselesaikan: {{ $response->completed_at->translatedFormat('d F Y H:i') }}
            </span>
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider w-16 text-center">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Pernyataan & Jawaban</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($response->survey->questions->sortBy('order') as $index => $question)
                        @php
                            $answer = $response->answers->where('question_id', $question->id)->first();
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-6 text-center font-bold text-gray-400 align-top">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-6">
                                <div class="text-gray-900 font-medium mb-3">
                                    {{ $question->question_text }}
                                </div>
                                
                                @if($question->question_type === 'text')
                                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-gray-700">
                                        {{ $answer ? $answer->text_value : '-' }}
                                    </div>
                                @elseif($question->question_type === 'multiple_choice')
                                    <div class="space-y-2">
                                        @foreach($question->options->sortBy('order') as $mcOption)
                                            @php
                                                $isSelected = $answer && $answer->selected_option_id == $mcOption->id;
                                            @endphp
                                            <div class="flex items-center gap-3 p-3 border {{ $isSelected ? 'border-theme-primary bg-theme-primary/5' : 'border-gray-100 bg-gray-50 opacity-60' }} rounded-xl">
                                                <div class="w-5 h-5 flex items-center justify-center rounded-full border {{ $isSelected ? 'border-theme-primary' : 'border-gray-300 bg-white' }}">
                                                    @if($isSelected)
                                                        <div class="w-2.5 h-2.5 bg-theme-primary rounded-full"></div>
                                                    @endif
                                                </div>
                                                <span class="{{ $isSelected ? 'text-theme-primary font-bold' : 'text-gray-500' }}">
                                                    {{ $mcOption->option_text }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($question->question_type === 'likert')
                                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-2 mt-4">
                                        @foreach($question->likertScale->options->sortBy('order') as $option)
                                            @php
                                                $isSelected = $answer && $answer->likert_value == $option->value;
                                            @endphp
                                            <div class="flex flex-col items-center justify-center p-3 rounded-xl border {{ $isSelected ? 'border-theme-active bg-theme-active/5 shadow-sm' : 'border-gray-100 bg-gray-50 opacity-60' }}">
                                                <div class="w-6 h-6 flex items-center justify-center rounded-full border mb-2 {{ $isSelected ? 'border-theme-active bg-white' : 'border-gray-300 bg-white' }}">
                                                    @if($isSelected)
                                                        <div class="w-3 h-3 bg-theme-active rounded-full"></div>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-center {{ $isSelected ? 'text-theme-active font-bold' : 'text-gray-500' }}">
                                                    {{ $option->label }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
