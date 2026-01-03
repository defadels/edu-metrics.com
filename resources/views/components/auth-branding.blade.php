<div class="flex w-full lg:w-1/2 bg-gradient-to-br from-lime-600 via-lime-700 to-lime-800 relative overflow-hidden min-h-[300px] lg:min-h-screen">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <div class="relative z-10 flex flex-col justify-between h-full p-6 lg:p-12 text-white">
        <!-- Logo Section -->
        <div class="flex flex-col items-center mb-8 animate-fade-in-up">
            <div class="w-20 h-20 lg:w-32 lg:h-32 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-4 lg:mb-6 shadow-2xl p-3">
                <img src="{{ asset('logo.jpeg') }}" alt="STKIP Pasundan Cimahi" class="w-full h-full object-contain rounded-full">
            </div>
            <h1 class="text-2xl font-bold text-center mb-2 text-shadow-lg">EduMetrics</h1>
            <p class="text-lg text-center text-purple-100 text-shadow">Measure. Improve. Thrive.</p>
        </div>

        <!-- Content Section -->
        <div class="flex-1 flex flex-col justify-center animate-fade-in-up animate-delay-100">
            {{-- <h2 class="text-4xl md:text-5xl font-bold mb-6 text-shadow-lg leading-tight">
                SISTEM PENJAMINAN MUTU INTERNAL
            </h2> --}}
            <p class="hidden lg:block text-lg md:text-xl text-purple-100 leading-relaxed mb-8 max-w-md">
               A system for continuous improvement in higher education quality at STKIP Pasundan Cimahi. EduMetrics is designed to ensure the effective and integrated implementation of quality assurance processes in alignment with the institution’s vision and mission. This platform supports the fulfillment of stakeholders’ needs by promoting high-quality, transparent, and accountable higher education.
            </p>
            
            <!-- Download Guide Button -->
            <a href="#" class="hidden lg:inline-flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl max-w-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Download Instruction</span>
            </a>
        </div>

        <!-- Copyright -->
        <div class="text-sm text-purple-200 animate-fade-in-up animate-delay-200">
            © {{ date('Y') }} EduMetrics
        </div>
    </div>
</div>

