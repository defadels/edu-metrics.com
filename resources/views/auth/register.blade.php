@php
    $title = 'Register';
@endphp

<x-auth-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Register Account</h2>
        <p class="text-gray-600">Create your account to get started</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                autocomplete="name" placeholder="Enter your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required
                autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- NIM -->
        <div>
            <x-input-label for="nim" :value="__('NIM (Student ID Number)')" />
            <x-text-input id="nim" type="text" name="nim" :value="old('nim')" required autocomplete="nim"
                placeholder="Enter your NIM" />
            <x-input-error :messages="$errors->get('nim')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500">Required</p>
        </div>

        {{-- Program Study --}}
        <div>
            <x-input-label for="program_study" :value="__('Program Study')" />
            <select name="program_study" id="program_study"
                class="form-select w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm mt-1">
                <option value="">Select Program Study</option>
                <option value="Agroteknologi">Agroteknologi</option>
                <option value="Akuntansi dan Agribisnis">Akuntansi dan Agribisnis</option>
                <option value="Ilmu Pemerintahan">Ilmu Pemerintahan</option>
                <option value="Ilmu Keperawatan">Ilmu Keperawatan</option>
                <option value="Matematika">Matematika</option>
                <option value="Pendidikan Geografi">Pendidikan Geografi</option>
                <option value="Pendidikan Bahasa Inggris">Pendidikan Bahasa Inggris</option>
                <option value="Pendidikan Bahasa dan Sastra Indonesia">Pendidikan Bahasa dan Sastra Indonesia</option>
                <option value="Pendidikan IPS">Pendidikan IPS</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
            </select>
            <x-input-error :messages="$errors->get('program_study')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500">Required</p>
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" placeholder="Confirm your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                <span>Register</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </div>

        <div class="text-center pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}"
                    class="font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                    Login
                </a>
            </p>
        </div>
    </form>
</x-auth-layout>
