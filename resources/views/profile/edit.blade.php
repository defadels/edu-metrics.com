@extends('layouts.app')

@section('content')
<div class="bg-theme-primary text-white py-12 mb-10 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2 uppercase tracking-wide">Lengkapi Data Diri</h1>
        <p class="text-white/80">Silakan lengkapi data diri anda untuk melanjutkan pengisian kuesioner</p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="bg-white rounded-3xl p-8 lg:p-12 shadow-sm border border-gray-100">
        <div class="max-w-xl mx-auto">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="mt-10 bg-white rounded-3xl p-8 lg:p-12 shadow-sm border border-gray-100">
        <div class="max-w-xl mx-auto">
            @include('profile.partials.update-password-form')
        </div>
    </div>
</div>
@endsection
