@php
    $title = 'Login';
@endphp

<x-auth-layout>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Login Account</h2>
        <p class="text-gray-600">Enter your username and password</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
            <x-input-label for="email" :value="__('Username')" />
                <x-text-input 
                    id="email" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username"
                placeholder="Enter your username"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input 
                    id="password"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                placeholder="Enter your password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-2 w-4 h-4" 
                        name="remember"
                    >
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-700 font-medium transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="pt-4">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                <span>Sign In</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
            </div>

        <div class="text-center pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                    Belum punya akun? 
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </form>
</x-auth-layout>
