@extends('layouts.app')

@section('title', 'Take Survey: ' . $survey->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="card-modern animate-fade-in-up">
        <div class="p-8 lg:p-12">
            <div class="mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">{{ $survey->title }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Please answer all required questions</p>
            </div>

            <form action="{{ route('surveys.submit', $survey) }}" method="POST" id="surveyForm">
                @csrf
                <input type="hidden" name="response_id" value="{{ $activeResponse->id }}">

                <div class="space-y-8">
                    @foreach($survey->questions->sortBy('order') as $index => $question)
                        <div class="border-2 border-gray-200 dark:border-gray-700 rounded-2xl p-8 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-300 animate-fade-in-up" style="animation-delay: {{ $index * 0.1 }}s; opacity: 0;">
                            <div class="mb-6">
                                <label class="flex items-start gap-3">
                                    <span class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-lg">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-1">
                                        <span class="block text-xl font-bold text-gray-900 dark:text-white mb-2">
                                            {{ $question->question_text }}
                                            @if($question->is_required)
                                                <span class="text-red-500">*</span>
                                            @endif
                                        </span>
                                    </div>
                                </label>
                            </div>

                            <div class="ml-13">
                                @if($question->question_type === 'likert')
                                    @if($question->likertScale)
                                        <div class="space-y-3">
                                            @foreach($question->likertScale->options->sortBy('order') as $option)
                                                <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-indigo-400 dark:hover:border-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 cursor-pointer transition-all duration-300 group">
                                                    <input type="radio" 
                                                           name="answers[{{ $question->id }}][likert_value]" 
                                                           value="{{ $option->value }}"
                                                           class="w-5 h-5 text-indigo-600 border-gray-300 focus:ring-indigo-500 focus:ring-2"
                                                           {{ $question->is_required ? 'required' : '' }}>
                                                    <span class="ml-4 text-gray-900 dark:text-white font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $option->label }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                @elseif($question->question_type === 'text')
                                    <textarea 
                                        name="answers[{{ $question->id }}][text_value]" 
                                        rows="5"
                                        class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white transition-all duration-300 resize-none"
                                        placeholder="Write your answer here..."
                                        {{ $question->is_required ? 'required' : '' }}></textarea>
                                @elseif($question->question_type === 'multiple_choice')
                                    @if($question->options->count() > 0)
                                        <div class="space-y-3">
                                            @foreach($question->options->sortBy('order') as $option)
                                                <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-indigo-400 dark:hover:border-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 cursor-pointer transition-all duration-300 group">
                                                    <input type="radio" 
                                                           name="answers[{{ $question->id }}][selected_option_id]" 
                                                           value="{{ $option->id }}"
                                                           class="w-5 h-5 text-indigo-600 border-gray-300 focus:ring-indigo-500 focus:ring-2"
                                                           {{ $question->is_required ? 'required' : '' }}>
                                                    <span class="ml-4 text-gray-900 dark:text-white font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $option->option_text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500 dark:text-gray-400">No options available for this question.</p>
                                    @endif
                                @endif
                            </div>

                            <input type="hidden" name="answers[{{ $question->id }}][question_id]" value="{{ $question->id }}">
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700 flex gap-4">
                    <a href="{{ route('surveys.show', $survey) }}" 
                       class="flex-1 text-center bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 px-6 py-4 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-indigo-300">
                        Submit Survey
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('surveyForm').addEventListener('submit', function(e) {
    const requiredQuestions = document.querySelectorAll('[required]');
    let isValid = true;
    
    requiredQuestions.forEach(function(question) {
        const questionContainer = question.closest('.border-2');
        if (question.type === 'radio') {
            const name = question.name;
            const checked = document.querySelector(`input[name="${name}"]:checked`);
            if (!checked) {
                isValid = false;
                if (questionContainer) {
                    questionContainer.classList.add('border-red-400', 'bg-red-50', 'dark:bg-red-900/20');
                }
            } else {
                if (questionContainer) {
                    questionContainer.classList.remove('border-red-400', 'bg-red-50', 'dark:bg-red-900/20');
                }
            }
        } else if (!question.value.trim()) {
            isValid = false;
            question.classList.add('border-red-400');
        } else {
            question.classList.remove('border-red-400');
        }
    });

    if (!isValid) {
        e.preventDefault();
        alert('Please complete all required questions.');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
</script>
@endsection
