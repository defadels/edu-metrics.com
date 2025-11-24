@extends('layouts.dashboard')

@section('title', 'Detail Survey')
@section('page-title', 'Detail Survey')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6 mb-4">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $survey->title }}</h3>
                <p class="text-sm text-gray-500 mt-1">Kategori: {{ $survey->category->name }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard.surveys.edit', $survey) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                    Edit
                </a>
                <form action="{{ route('dashboard.surveys.destroy', $survey) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus survey ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <p class="text-gray-900">{{ $survey->description ?? '-' }}</p>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                <p class="text-gray-900">{{ $survey->start_date->format('d M Y H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                <p class="text-gray-900">{{ $survey->end_date->format('d M Y H:i') }}</p>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <div class="flex space-x-4">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $survey->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $survey->is_active ? 'Aktif' : 'Tidak Aktif' }}
                </span>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $survey->is_anonymous ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $survey->is_anonymous ? 'Anonim' : 'Tidak Anonim' }}
                </span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6 mb-4">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-lg font-semibold text-gray-900">Pertanyaan ({{ $survey->questions->count() }})</h4>
            <a href="{{ route('dashboard.questions.create', ['survey_id' => $survey->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Tambah Pertanyaan
            </a>
        </div>
        @if($survey->questions->count() > 0)
            <div class="space-y-4">
                @foreach($survey->questions->sortBy('order') as $question)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $question->question_text }}</p>
                                <div class="mt-2 flex space-x-2">
                                    <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-800">{{ $question->question_type }}</span>
                                    @if($question->likertScale)
                                        <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">{{ $question->likertScale->name }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4 flex space-x-2">
                                <a href="{{ route('dashboard.questions.show', $question) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                <a href="{{ route('dashboard.questions.edit', $question) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Belum ada pertanyaan dalam survey ini.</p>
        @endif
    </div>
    
    <div class="mt-4">
        <a href="{{ route('dashboard.surveys.index') }}" class="text-blue-600 hover:text-blue-900">← Kembali ke daftar</a>
    </div>
</div>
@endsection

