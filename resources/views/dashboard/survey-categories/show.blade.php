@extends('layouts.dashboard')

@section('title', 'Detail Kategori Survey')
@section('page-title', 'Detail Kategori Survey')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6 mb-4">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h3>
                <p class="text-sm text-gray-500 mt-1">Dibuat: {{ $category->created_at->format('d M Y') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard.categories.edit', $category) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                    Edit
                </a>
                <form action="{{ route('dashboard.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
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
            <p class="text-gray-900">{{ $category->description ?? '-' }}</p>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
            </span>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Survey dalam Kategori ini ({{ $category->surveys->count() }})</h4>
        @if($category->surveys->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($category->surveys as $survey)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $survey->title }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $survey->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $survey->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('dashboard.surveys.show', $survey) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">Belum ada survey dalam kategori ini.</p>
        @endif
    </div>
    
    <div class="mt-4">
        <a href="{{ route('dashboard.categories.index') }}" class="text-blue-600 hover:text-blue-900">← Kembali ke daftar</a>
    </div>
</div>
@endsection

