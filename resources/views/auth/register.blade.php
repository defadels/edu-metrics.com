<x-auth-layout title="Register">
    <div class="mb-5">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1">Register Account</h2>
        <p class="text-sm text-gray-600">Create your account to get started</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                autocomplete="name" placeholder="Enter your full name" class="mt-1 block w-full py-2.5" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required
                autocomplete="username" placeholder="Enter your email" class="mt-1 block w-full py-2.5" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- NIM -->
        <div>
            <x-input-label for="nim" :value="__('NIM (Student ID Number)')" />
            <x-text-input id="nim" type="text" name="nim" :value="old('nim')" autocomplete="nim"
                placeholder="Enter your NIM (optional)" class="mt-1 block w-full py-2.5" />
            <x-input-error :messages="$errors->get('nim')" class="mt-1" />
        </div>

        <!-- Program Study -->
        <div>
            <x-input-label for="program_study" :value="__('Program Study')" />
            <select name="program_study" id="program_study"
                class="form-select w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm mt-1 py-2.5 text-sm">
                <option value="">Select Program Study</option>
                @foreach(\App\Models\User::PROGRAM_STUDIES as $study)
                    <option value="{{ $study }}" {{ old('program_study') === $study ? 'selected' : '' }}>{{ $study }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('program_study')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Enter your password" class="mt-1 block w-full py-2.5" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" placeholder="Confirm your password" class="mt-1 block w-full py-2.5" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-300 transform hover:scale-[1.01] shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-sm sm:text-base">
                <span>Register</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </div>

        <div class="text-center pt-3 border-t border-gray-200">
            <p class="text-xs sm:text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}"
                    class="font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                    Login
                </a>
            </p>
        </div>
    </form>
</x-auth-layout>
