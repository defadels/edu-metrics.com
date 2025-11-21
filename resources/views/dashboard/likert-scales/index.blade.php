@extends('layouts.dashboard')

@section('title', 'Skala Likert')
@section('page-title', 'Skala Likert')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Skala Likert</h3>
    <a href="{{ route('dashboard.likert-scales.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
        Tambah Skala
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Range</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Opsi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Digunakan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($scales as $scale)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $scale->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $scale->min_value }} - {{ $scale->max_value }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $scale->options_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $scale->questions_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('dashboard.likert-scales.show', $scale) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">Lihat</a>
                        <a href="{{ route('dashboard.likert-scales.edit', $scale) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400">Edit</a>
                        <form action="{{ route('dashboard.likert-scales.destroy', $scale) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus skala ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada skala Likert.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($scales->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $scales->links() }}
        </div>
    @endif
</div>
@endsection

