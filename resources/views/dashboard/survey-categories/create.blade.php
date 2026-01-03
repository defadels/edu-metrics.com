@extends('layouts.dashboard')

@section('title', 'Add Survey Category')
@section('page-title', 'Add Survey Category')

@section('content')
<div class="max-w-2xl animate-fade-in-up">
    <form action="{{ route('dashboard.categories.store') }}" method="POST" class="card-modern p-8">
        @csrf
        
        <div class="mb-6">
            <x-input-label for="name" :value="__('Category Name')" />
            <x-text-input 
                id="name" 
                name="name" 
                :value="old('name')" 
                required 
                placeholder="Example: Lecturer Evaluation"
            />
            @error('name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <x-input-label for="description" :value="__('Description')" />
            <textarea 
                name="description" 
                id="description" 
                rows="4" 
                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white transition-all duration-300 resize-none"
                placeholder="Survey category description...">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="flex items-center cursor-pointer group">
                <input 
                    type="checkbox" 
                    name="is_active" 
                    value="1" 
                    {{ old('is_active', true) ? 'checked' : '' }} 
                    class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2 cursor-pointer"
                >
                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                    Active
                </span>
            </label>
        </div>
        
        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('dashboard.categories.index') }}" 
               class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transform hover:scale-105 transition-all duration-300">
                Cancel
            </a>
            <button type="submit" 
                    class="btn-modern bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700">
                Save
            </button>
        </div>
    </form>
</div>
@endsection
