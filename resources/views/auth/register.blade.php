<x-guest-layout>
    <!-- Animated Background -->
    <div class="absolute inset-0 gradient-primary opacity-10"></div>
    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 40px 40px;"></div>
    
    <div class="relative w-full sm:max-w-md mt-6 px-6 py-8 glass dark:glass-dark shadow-2xl overflow-y-auto sm:rounded-2xl animate-fade-in-up">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Buat Akun Baru</h2>
            <p class="text-gray-600 dark:text-gray-400">Daftar untuk mulai menggunakan platform</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input 
                    id="name" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    required 
                    autofocus 
                    autocomplete="name"
                    placeholder="John Doe"
                />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
            <div>
            <x-input-label for="email" :value="__('Email')" />
                <x-text-input 
                    id="email" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autocomplete="username"
                    placeholder="nama@email.com"
                />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

            <!-- NIM -->
            <div>
                <x-input-label for="nim" :value="__('NIM (Nomor Induk Mahasiswa)')" />
                <x-text-input 
                    id="nim" 
                    type="text" 
                    name="nim" 
                    :value="old('nim')" 
                    autocomplete="nim"
                    placeholder="1234567890"
                />
                <x-input-error :messages="$errors->get('nim')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Opsional - Isi jika Anda adalah mahasiswa</p>
            </div>

        <!-- Password -->
            <div>
            <x-input-label for="password" :value="__('Password')" />
                <x-text-input 
                    id="password"
                            type="password"
                            name="password"
                    required 
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                <x-text-input 
                    id="password_confirmation"
                            type="password"
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    placeholder="Ulangi password"
                />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

            <div class="pt-4">
                <x-primary-button class="w-full justify-center">
                {{ __('Register') }}
            </x-primary-button>
        </div>

            <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                        Masuk
                    </a>
                </p>
            </div>
    </form>
    </div>
</x-guest-layout>
