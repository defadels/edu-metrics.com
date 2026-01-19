<section>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-tight">Nama Lengkap</label>
            <input id="name" name="name" type="text" 
                   class="block w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:border-theme-primary focus:ring-theme-primary/10 transition-all font-medium" 
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-tight">Email</label>
            <input id="email" name="email" type="email" 
                   class="block w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:border-theme-primary focus:ring-theme-primary/10 transition-all font-medium" 
                   value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" 
                    class="w-full sm:w-auto px-10 py-4 bg-theme-primary text-white rounded-2xl font-bold shadow-xl shadow-theme-primary/20 hover:bg-theme-primary/90 transform hover:-translate-y-0.5 transition-all">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-theme-active"
                >Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
