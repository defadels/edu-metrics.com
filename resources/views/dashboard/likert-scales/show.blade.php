@extends('layouts.dashboard')

@section('title', 'Detail Skala Likert')
@section('page-title', 'Detail Skala Likert')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6 mb-4">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $likertScale->name }}</h3>
                <p class="text-sm text-gray-500 mt-1">Range: {{ $likertScale->min_value }} - {{ $likertScale->max_value }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard.likert-scales.edit', $likertScale) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                    Edit
                </a>
                <form action="{{ route('dashboard.likert-scales.destroy', $likertScale) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus skala ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
            <p class="text-gray-900">{{ $likertScale->min_label }} - {{ $likertScale->max_label }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Opsi Skala ({{ $likertScale->options->count() }})</h4>
        @if($likertScale->options->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Label</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($likertScale->options->sortBy('order') as $option)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $option->value }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $option->label }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $option->order }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">Belum ada opsi dalam skala ini.</p>
        @endif
    </div>
    
    <div class="mt-4">
        <a href="{{ route('dashboard.likert-scales.index') }}" class="text-blue-600 hover:text-blue-900">← Kembali ke daftar</a>
    </div>
</div>
@endsection

