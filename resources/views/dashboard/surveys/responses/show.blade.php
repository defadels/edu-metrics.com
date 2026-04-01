@extends('layouts.dashboard')

@section('title', 'Survey Response Detail')
@section('page-title', 'Survey Response Detail')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4 animate-fade-in-up">
    <div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Response Details</h3>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Viewing answers from {{ $survey->is_anonymous ? 'Anonymous' : ($response->user->name ?? $response->respondent_name ?? 'Unknown') }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('dashboard.surveys.responses.index', $survey) }}" 
           class="btn-modern bg-gray-600 hover:bg-gray-700 text-white inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to Responses</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 mb-6">
    <div class="card-modern">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-6 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $survey->title }}</h4>
                <div class="flex items-center gap-3 mt-2 text-sm text-gray-500 dark:text-gray-400">
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Completed: {{ $response->completed_at ? $response->completed_at->format('d M Y, H:i') : '-' }}
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Respondent: {{ $survey->is_anonymous ? 'Anonymous User' : ($response->user->email ?? $response->respondent_name ?? 'Guest') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="space-y-8">
                @foreach($survey->questions->sortBy('order') as $index => $question)
                    @php
                        $answer = $response->answers->where('question_id', $question->id)->first();
                    @endphp
                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-5 border border-gray-100 dark:border-gray-700">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full font-bold text-sm bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1">
                                <h5 class="text-base font-medium text-gray-900 dark:text-white mb-4">
                                    {{ $question->question_text }}
                                </h5>

                                @if($question->question_type === 'text')
                                    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                        {{ $answer ? $answer->text_value : '-' }}
                                    </div>
                                @elseif($question->question_type === 'multiple_choice')
                                    <div class="space-y-2">
                                        @foreach($question->options->sortBy('order') as $mcOption)
                                            @php
                                                $isSelected = $answer && $answer->selected_option_id == $mcOption->id;
                                            @endphp
                                            <div class="flex items-center gap-3 p-3 rounded-lg border {{ $isSelected ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 opacity-60' }}">
                                                <div class="w-5 h-5 flex items-center justify-center rounded-full border {{ $isSelected ? 'border-indigo-600' : 'border-gray-300' }}">
                                                    @if($isSelected)
                                                        <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full"></div>
                                                    @endif
                                                </div>
                                                <span class="{{ $isSelected ? 'text-indigo-900 dark:text-indigo-300 font-bold' : 'text-gray-500 dark:text-gray-400' }}">
                                                    {{ $mcOption->option_text }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($question->question_type === 'likert')
                                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                                        @foreach($question->likertScale->options->sortBy('order') as $option)
                                            @php
                                                $isSelected = $answer && $answer->likert_value == $option->value;
                                            @endphp
                                            <div class="flex flex-col items-center justify-center p-3 rounded-lg border {{ $isSelected ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20 shadow-sm' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 opacity-60' }}">
                                                <div class="w-5 h-5 flex items-center justify-center rounded-full border mb-2 {{ $isSelected ? 'border-indigo-600 bg-white' : 'border-gray-300 bg-white dark:bg-gray-900' }}">
                                                    @if($isSelected)
                                                        <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full"></div>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-center {{ $isSelected ? 'text-indigo-900 dark:text-indigo-300 font-bold' : 'text-gray-500 dark:text-gray-400' }}">
                                                    {{ $option->label }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
