@extends('layouts.dashboard')

@section('title', 'Edit Survey')
@section('page-title', 'Edit Survey')

@section('content')
<div class="max-w-2xl animate-fade-in-up">
    <form action="{{ route('dashboard.surveys.update', $survey) }}" method="POST" class="card-modern p-8">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <x-input-label for="category_id" :value="__('Category')" />
            <select name="category_id" id="category_id" required 
                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white transition-all duration-300">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $survey->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <x-input-label for="title" :value="__('Survey Title')" />
            <x-text-input 
                id="title" 
                name="title" 
                :value="old('title', $survey->title)" 
                required 
                placeholder="Example: Lecturer Performance Evaluation Odd Semester 2024"
            />
            @error('title')
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
                placeholder="Survey description...">{{ old('description', $survey->description) }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <x-input-label for="start_date" :value="__('Start Date')" />
                <x-text-input 
                    id="start_date" 
                    type="datetime-local" 
                    name="start_date" 
                    :value="old('start_date', $survey->start_date->format('Y-m-d\TH:i'))" 
                    required
                />
                @error('start_date')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <x-input-label for="end_date" :value="__('End Date')" />
                <x-text-input 
                    id="end_date" 
                    type="datetime-local" 
                    name="end_date" 
                    :value="old('end_date', $survey->end_date->format('Y-m-d\TH:i'))" 
                    required
                />
                @error('end_date')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-6 space-y-3">
            <label class="flex items-center cursor-pointer group">
                <input 
                    type="checkbox" 
                    name="is_active" 
                    value="1" 
                    {{ old('is_active', $survey->is_active) ? 'checked' : '' }} 
                    class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2 cursor-pointer"
                >
                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                    Active
                </span>
            </label>
            <label class="flex items-center cursor-pointer group">
                <input 
                    type="checkbox" 
                    name="is_anonymous" 
                    value="1" 
                    {{ old('is_anonymous', $survey->is_anonymous) ? 'checked' : '' }} 
                    class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2 cursor-pointer"
                >
                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                    Anonymous
                </span>
            </label>
        </div>
        
        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('dashboard.surveys.index') }}" 
               class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transform hover:scale-105 transition-all duration-300">
                Cancel
            </a>
            <button type="submit" 
                    class="btn-modern bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
