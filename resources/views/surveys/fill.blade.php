@extends('layouts.app')

@section('title', 'Take Survey: ' . $survey->title)

@section('content')
<div class="bg-theme-primary text-white py-12 mb-10 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">Isi Kuesioner</h1>
        <p class="text-white/80">{{ $survey->title }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <!-- Instructions -->
    <div class="bg-gray-100 rounded-2xl p-6 mb-10 border border-gray-200">
        <h3 class="font-bold text-gray-900 mb-2 flex items-center gap-2">
            <svg class="w-5 h-5 text-theme-primary" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            Petunjuk Pengisian
        </h3>
        <p class="text-gray-600 text-sm leading-relaxed">
            Silakan baca setiap pernyataan dengan seksama dan berikan jawaban yang paling sesuai dengan persepsi Anda. Berikan tanda centang pada kolom yang tersedia untuk setiap pilihan jawaban yang tersedia.
        </p>
    </div>

    <form action="{{ route('surveys.submit', $survey) }}" method="POST" id="surveyForm">
        @csrf
        <input type="hidden" name="response_id" value="{{ $activeResponse->id }}">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider w-16 text-center">No</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Pernyataan</th>
                            
                            @php
                                // Get unique likert options from all questions to build a common header if possible
                                // For simplicity and matching the UI, we assume common labels or use the first question's scale
                                $firstLikert = $survey->questions->where('question_type', 'likert')->first();
                                $options = $firstLikert ? $firstLikert->likertScale->options->sortBy('order') : collect();
                            @endphp

                            @foreach($options as $option)
                                <th class="px-4 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center w-24">
                                    {{ $option->label }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($survey->questions->sortBy('order') as $index => $question)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-6 text-center font-bold text-gray-400">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-6">
                                    <span class="text-gray-900 font-medium">
                                        {{ $question->question_text }}
                                        @if($question->is_required)
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </span>
                                    
                                    @if($question->question_type === 'text')
                                        <div class="mt-4">
                                            <textarea 
                                                name="answers[{{ $question->id }}][text_value]" 
                                                rows="3"
                                                placeholder="Tuliskan jawaban Anda..."
                                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-theme-primary/20 focus:border-theme-primary transition-all resize-none"
                                                {{ $question->is_required ? 'required' : '' }}></textarea>
                                        </div>
                                    @endif

                                    @if($question->question_type === 'multiple_choice')
                                        <div class="mt-4 space-y-2">
                                            @foreach($question->options->sortBy('order') as $mcOption)
                                                <label class="flex items-center gap-3 p-3 border border-gray-100 rounded-xl hover:bg-white cursor-pointer group">
                                                    <input type="radio" 
                                                           name="answers[{{ $question->id }}][selected_option_id]" 
                                                           value="{{ $mcOption->id }}"
                                                           class="w-5 h-5 text-theme-primary border-gray-300 focus:ring-theme-primary"
                                                           {{ $question->is_required ? 'required' : '' }}>
                                                    <span class="text-gray-700 group-hover:text-theme-primary transition-colors">{{ $mcOption->option_text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>

                                @if($question->question_type === 'likert')
                                    @foreach($options as $option)
                                        <td class="px-4 py-6 text-center">
                                            <label class="inline-flex items-center justify-center p-2 cursor-pointer group">
                                                <input type="radio" 
                                                       name="answers[{{ $question->id }}][likert_value]" 
                                                       value="{{ $option->value }}"
                                                       class="w-6 h-6 text-theme-active border-gray-300 focus:ring-theme-active cursor-pointer"
                                                       {{ $question->is_required ? 'required' : '' }}>
                                            </label>
                                        </td>
                                    @endforeach
                                @endif
                                
                                <input type="hidden" name="answers[{{ $question->id }}][question_id]" value="{{ $question->id }}">
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-10 flex justify-end">
            <button type="submit" 
                    class="px-12 py-4 bg-theme-active text-white rounded-2xl font-bold shadow-xl shadow-theme-active/20 hover:bg-theme-active/90 transform hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-theme-active/20">
                Simpan Jawaban
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('surveyForm').addEventListener('submit', function(e) {
    const requiredQuestions = document.querySelectorAll('[required]');
    let isValid = true;
    
    requiredQuestions.forEach(function(question) {
        if (question.type === 'radio') {
            const name = question.name;
            const checked = document.querySelector(`input[name="${name}"]:checked`);
            if (!checked) {
                isValid = false;
            }
        } else if (!question.value.trim()) {
            isValid = false;
        }
    });

    if (!isValid) {
        e.preventDefault();
        alert('Mohon lengkapi semua pertanyaan yang wajib diisi.');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
</script>
@endsection
