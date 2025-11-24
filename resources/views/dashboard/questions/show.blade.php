@extends('layouts.dashboard')

@section('title', 'Detail Pertanyaan')
@section('page-title', 'Detail Pertanyaan')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6 mb-4">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Pertanyaan</h3>
                <p class="text-sm text-gray-500 mt-1">Survey: {{ $question->survey->title }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard.questions.edit', $question) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                    Edit
                </a>
                <form action="{{ route('dashboard.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Teks Pertanyaan</label>
            <p class="text-gray-900">{{ $question->question_text }}</p>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                    {{ $question->question_type }}
                </span>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                <p class="text-gray-900">{{ $question->order }}</p>
            </div>
        </div>
        
        @if($question->likertScale)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Skala Likert</label>
                <p class="text-gray-900">{{ $question->likertScale->name }} ({{ $question->likertScale->min_value }}-{{ $question->likertScale->max_value }})</p>
            </div>
        @endif
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $question->is_required ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                {{ $question->is_required ? 'Wajib' : 'Opsional' }}
            </span>
        </div>
    </div>
    
    @if($question->options->count() > 0)
        <div class="bg-white rounded-lg shadow p-6 mb-4">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Opsi ({{ $question->options->count() }})</h4>
            <div class="space-y-2">
                @foreach($question->options->sortBy('order') as $option)
                    <div class="border border-gray-200 rounded-lg p-3">
                        <p class="text-gray-900">{{ $option->option_text }}</p>
                        <p class="text-xs text-gray-500 mt-1">Urutan: {{ $option->order }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    <div class="mt-4">
        <a href="{{ route('dashboard.questions.index') }}" class="text-blue-600 hover:text-blue-900">← Kembali ke daftar</a>
    </div>
</div>
@endsection

