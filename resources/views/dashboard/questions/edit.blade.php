@extends('layouts.dashboard')

@section('title', 'Edit Pertanyaan')
@section('page-title', 'Edit Pertanyaan')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('dashboard.questions.update', $question) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="survey_id" class="block text-sm font-medium text-gray-700 mb-2">Survey</label>
            <select name="survey_id" id="survey_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">Pilih Survey</option>
                @foreach($surveys as $survey)
                    <option value="{{ $survey->id }}" {{ old('survey_id', $question->survey_id) == $survey->id ? 'selected' : '' }}>{{ $survey->title }}</option>
                @endforeach
            </select>
            @error('survey_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="question_text" class="block text-sm font-medium text-gray-700 mb-2">Teks Pertanyaan</label>
            <textarea name="question_text" id="question_text" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('question_text', $question->question_text) }}</textarea>
            @error('question_text')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="question_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Pertanyaan</label>
            <select name="question_type" id="question_type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" onchange="toggleLikertScale()">
                <option value="">Pilih Tipe</option>
                <option value="likert" {{ old('question_type', $question->question_type) == 'likert' ? 'selected' : '' }}>Likert</option>
                <option value="text" {{ old('question_type', $question->question_type) == 'text' ? 'selected' : '' }}>Text</option>
                <option value="multiple_choice" {{ old('question_type', $question->question_type) == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
            </select>
            @error('question_type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4" id="likert_scale_field" style="display: {{ old('question_type', $question->question_type) == 'likert' ? 'block' : 'none' }};">
            <label for="likert_scale_id" class="block text-sm font-medium text-gray-700 mb-2">Skala Likert</label>
            <select name="likert_scale_id" id="likert_scale_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">Pilih Skala Likert</option>
                @foreach($likertScales as $scale)
                    <option value="{{ $scale->id }}" {{ old('likert_scale_id', $question->likert_scale_id) == $scale->id ? 'selected' : '' }}>{{ $scale->name }} ({{ $scale->min_value }}-{{ $scale->max_value }})</option>
                @endforeach
            </select>
            @error('likert_scale_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
            <input type="number" name="order" id="order" value="{{ old('order', $question->order) }}" required min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @error('order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_required" value="1" {{ old('is_required', $question->is_required) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Wajib diisi</span>
            </label>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('dashboard.questions.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>

<script>
function toggleLikertScale() {
    const questionType = document.getElementById('question_type').value;
    const likertField = document.getElementById('likert_scale_field');
    const likertSelect = document.getElementById('likert_scale_id');
    
    if (questionType === 'likert') {
        likertField.style.display = 'block';
        likertSelect.setAttribute('required', 'required');
    } else {
        likertField.style.display = 'none';
        likertSelect.removeAttribute('required');
    }
}
</script>
@endsection

