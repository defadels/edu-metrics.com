<div
    class="flex w-full lg:w-1/2 bg-gradient-to-br from-lime-600 via-lime-700 to-lime-800 relative overflow-hidden min-h-[260px] lg:min-h-screen">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute inset-0"
            style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 40px 40px;">
        </div>
    </div>

    <div class="relative z-10 flex flex-col justify-between items-center h-full w-full p-6 lg:p-8 xl:p-10 text-white">
        <!-- Unified Branding Center Group (Logo + Title + Slogan + Description) -->
        <div class="flex flex-col items-center text-center max-w-md mx-auto my-auto animate-fade-in-up">
            <!-- Logo -->
            <div
                class="w-20 h-20 lg:w-28 lg:h-28 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 shadow-2xl p-2.5">
                <img src="{{ asset('logo.png') }}" alt="STKIP Pasundan Cimahi"
                    class="w-full h-full object-contain rounded-full">
            </div>

            <!-- Title & Slogan -->
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-1 text-shadow-lg">EduMetrics</h1>
            <p class="text-sm lg:text-base font-medium text-lime-100 text-shadow mb-4">Measure. Improve. Thrive.</p>

            <!-- Description Paragraph (Tightly and nicely spaced directly below the slogan) -->
            <p class="hidden lg:block text-xs lg:text-sm text-lime-50/90 leading-relaxed max-w-sm text-center">
                A system for continuous improvement in higher education quality at Universitas Bale Bandung.
                EduMetrics is designed to ensure the effective and integrated implementation of quality assurance
                processes in alignment with the institution’s vision and mission. This platform supports the fulfillment
                of stakeholders’ needs by promoting high-quality, transparent, and accountable higher education.
            </p>
        </div>

        <!-- Copyright -->
        <div class="text-xs text-lime-200/80 mt-auto pt-4 animate-fade-in-up animate-delay-100 text-center">
            © {{ date('Y') }} EduMetrics
        </div>
    </div>
</div>
