<section>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-tight">Nama
                Lengkap</label>
            <input id="name" name="name" type="text"
                class="block w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:border-theme-primary focus:ring-theme-primary/10 transition-all font-medium"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email"
                class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-tight">Email</label>
            <input id="email" name="email" type="email"
                class="block w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:border-theme-primary focus:ring-theme-primary/10 transition-all font-medium"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        @if (Auth::user()->role == 'mahasiswa')
            <div>
                <label for="nim"
                    class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-tight">NIM</label>
                <input id="nim" name="nim" type="text"
                    class="block w-full px-5 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:border-theme-primary focus:ring-theme-primary/10 transition-all font-medium"
                    value="{{ old('nim', $user->nim) }}" required autocomplete="nim" />
                <x-input-error class="mt-2" :messages="$errors->get('nim')" />
            </div>

            <div>
                <label for="program_study"
                    class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-tight">Program Study</label>
                <select name="program_study" id="program_study"
                    class="form-select w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm mt-1">
                    <option value="">Select Program Study</option>
                    <option value="Agroteknologi" {{ $user->program_study == 'Agroteknologi' ? 'selected' : '' }}>
                        Agroteknologi</option>
                    <option value="Pendidikan Geografi"
                        {{ $user->program_study == 'Pendidikan Geografi' ? 'selected' : '' }}>Pendidikan Geografi
                    </option>
                    <option value="Pendidikan Bahasa Inggris"
                        {{ $user->program_study == 'Pendidikan Bahasa Inggris' ? 'selected' : '' }}>Pendidikan Bahasa
                        Inggris</option>
                    <option value="Pendidikan Bahasa dan Sastra Indonesia"
                        {{ $user->program_study == 'Pendidikan Bahasa dan Sastra Indonesia' ? 'selected' : '' }}>
                        Pendidikan Bahasa dan Sastra Indonesia</option>
                    <option value="Pendidikan IPS" {{ $user->program_study == 'Pendidikan IPS' ? 'selected' : '' }}>
                        Pendidikan IPS</option>
                    <option value="Teknik Informatika"
                        {{ $user->program_study == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                    <option value="Sistem Informasi"
                        {{ $user->program_study == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                    <option value="Ilmu Pemerintahan"
                        {{ $user->program_study == 'Ilmu Pemerintahan' ? 'selected' : '' }}>Ilmu Pemerintahan</option>
                    <option value="Matematika" {{ $user->program_study == 'Matematika' ? 'selected' : '' }}>Matematika
                    </option>
                    <option value="Ilmu Keperawatan"
                        {{ $user->program_study == 'Ilmu Keperawatan' ? 'selected' : '' }}>Ilmu Keperawatan</option>
                </select>
                <x-input-error :messages="$errors->get('program_study')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500">Required</p>
            </div>
        @endif

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="w-full sm:w-auto px-10 py-4 bg-theme-green text-white rounded-2xl font-bold shadow-xl shadow-theme-primary/20 hover:bg-theme-primary/90 transform hover:-translate-y-0.5 transition-all">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-theme-active">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
