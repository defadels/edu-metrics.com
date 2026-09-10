@extends('layouts.dashboard')

@section('title', 'Add New User')
@section('page-title', 'Add New User')

@section('content')
<div class="max-w-3xl animate-fade-in-up" x-data="{ role: '{{ old('role', 'mahasiswa') }}' }">
    <div class="mb-6">
        <a href="{{ route('dashboard.users.index') }}" 
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to User List</span>
        </a>
    </div>

    <form action="{{ route('dashboard.users.store') }}" method="POST" class="card-modern p-8">
        @csrf

        <div class="mb-8 pb-6 border-b border-gray-100 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Add User Account</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Complete the information below to create a new account.</p>
        </div>

        <!-- Role Selection -->
        <div class="mb-6">
            <label class="block text-sm font-bold uppercase tracking-tight text-gray-700 dark:text-gray-300 mb-2">
                Account Role <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="relative flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all"
                       :class="role === 'mahasiswa' ? 'border-theme-primary bg-emerald-50/40 dark:bg-emerald-950/20 shadow-sm' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300'">
                    <input type="radio" name="role" value="mahasiswa" x-model="role" class="sr-only">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 dark:text-white">Student</div>
                            <div class="text-xs text-gray-500">Questionnaire respondent</div>
                        </div>
                    </div>
                </label>

                <label class="relative flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all"
                       :class="role === 'admin' ? 'border-theme-active bg-red-50/40 dark:bg-red-950/20 shadow-sm' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300'">
                    <input type="radio" name="role" value="admin" x-model="role" class="sr-only">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 dark:text-white">Administrator</div>
                            <div class="text-xs text-gray-500">Manage surveys and users</div>
                        </div>
                    </div>
                </label>
            </div>
            @error('role')
                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Name -->
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-bold uppercase tracking-tight text-gray-700 dark:text-gray-300 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                       placeholder="Example: Budi Santoso"
                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-theme-primary focus:border-theme-primary dark:bg-gray-800 dark:text-white transition-all text-sm">
                @error('name')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="md:col-span-2">
                <label for="email" class="block text-sm font-bold uppercase tracking-tight text-gray-700 dark:text-gray-300 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       placeholder="Example: user@stkip-pasundan.ac.id"
                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-theme-primary focus:border-theme-primary dark:bg-gray-800 dark:text-white transition-all text-sm">
                @error('email')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIM (Nullable) -->
            <div>
                <label for="nim" class="block text-sm font-bold uppercase tracking-tight text-gray-700 dark:text-gray-300 mb-2">
                    NIM (Student ID) <span class="text-xs font-normal text-gray-500 lowercase">(optional)</span>
                </label>
                <input type="text" id="nim" name="nim" value="{{ old('nim') }}"
                       placeholder="Example: 2021001"
                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-theme-primary focus:border-theme-primary dark:bg-gray-800 dark:text-white transition-all text-sm">
                @error('nim')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Program Study (Nullable) -->
            <div>
                <label for="program_study" class="block text-sm font-bold uppercase tracking-tight text-gray-700 dark:text-gray-300 mb-2">
                    Study Program <span class="text-xs font-normal text-gray-500 lowercase">(optional)</span>
                </label>
                <select id="program_study" name="program_study"
                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-theme-primary focus:border-theme-primary dark:bg-gray-800 dark:text-white transition-all text-sm">
                    <option value="">-- Select Study Program --</option>
                    @foreach($programStudies as $study)
                        <option value="{{ $study }}" {{ old('program_study') === $study ? 'selected' : '' }}>{{ $study }}</option>
                    @endforeach
                </select>
                @error('program_study')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-bold uppercase tracking-tight text-gray-700 dark:text-gray-300 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" id="password" name="password" required
                       placeholder="At least 8 characters"
                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-theme-primary focus:border-theme-primary dark:bg-gray-800 dark:text-white transition-all text-sm">
                @error('password')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-bold uppercase tracking-tight text-gray-700 dark:text-gray-300 mb-2">
                    Confirm Password <span class="text-red-500">*</span>
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       placeholder="Repeat the password above"
                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-theme-primary focus:border-theme-primary dark:bg-gray-800 dark:text-white transition-all text-sm">
                @error('password_confirmation')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
            <a href="{{ route('dashboard.users.index') }}" 
               class="px-6 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-all text-sm">
                Cancel
            </a>
            <button type="submit" 
                    class="btn-modern bg-theme-primary hover:bg-theme-primary/90 text-sm">
                Save User
            </button>
        </div>
    </form>
</div>
@endsection
