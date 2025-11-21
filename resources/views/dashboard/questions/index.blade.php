@extends('layouts.dashboard')

@section('title', 'Pertanyaan')
@section('page-title', 'Pertanyaan')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Pertanyaan</h3>
    <a href="{{ route('dashboard.questions.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
        Tambah Pertanyaan
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pertanyaan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Survey</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Urutan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($questions as $question)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ Str::limit($question->question_text, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $question->survey->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $question->question_type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $question->order }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('dashboard.questions.show', $question) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">Lihat</a>
                        <a href="{{ route('dashboard.questions.edit', $question) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400">Edit</a>
                        <form action="{{ route('dashboard.questions.destroy', $question) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada pertanyaan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($questions->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $questions->links() }}
        </div>
    @endif
</div>
@endsection

