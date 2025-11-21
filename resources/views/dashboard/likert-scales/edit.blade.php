@extends('layouts.dashboard')

@section('title', 'Edit Skala Likert')
@section('page-title', 'Edit Skala Likert')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('dashboard.likert-scales.update', $likertScale) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Skala</label>
            <input type="text" name="name" id="name" value="{{ old('name', $likertScale->name) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @error('name')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="min_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nilai Minimum</label>
                <input type="number" name="min_value" id="min_value" value="{{ old('min_value', $likertScale->min_value) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('min_value')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="max_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nilai Maksimum</label>
                <input type="number" name="max_value" id="max_value" value="{{ old('max_value', $likertScale->max_value) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('max_value')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="min_label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Label Minimum</label>
                <input type="text" name="min_label" id="min_label" value="{{ old('min_label', $likertScale->min_label) }}" required maxlength="100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('min_label')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="max_label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Label Maksimum</label>
                <input type="text" name="max_label" id="max_label" value="{{ old('max_label', $likertScale->max_label) }}" required maxlength="100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('max_label')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('dashboard.likert-scales.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                Update
            </button>
        </div>
    </form>
</div>
@endsection

