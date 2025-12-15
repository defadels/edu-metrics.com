<div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 relative overflow-hidden min-h-screen">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <div class="relative z-10 flex flex-col justify-between h-full p-12 text-white">
        <!-- Logo Section -->
        <div class="flex flex-col items-center mb-8 animate-fade-in-up">
            <div class="w-32 h-32 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-6 shadow-2xl p-3">
                <img src="{{ asset('logo.jpeg') }}" alt="STKIP Pasundan Cimahi" class="w-full h-full object-contain rounded-full">
            </div>
            <h1 class="text-2xl font-bold text-center mb-2 text-shadow-lg">EduMetrics</h1>
            <p class="text-lg text-center text-purple-100 text-shadow">Measure. Improve. Thrive.</p>
        </div>

        <!-- Content Section -->
        <div class="flex-1 flex flex-col justify-center animate-fade-in-up animate-delay-100">
            <h2 class="text-4xl md:text-5xl font-bold mb-6 text-shadow-lg leading-tight">
                SISTEM PENJAMINAN MUTU INTERNAL
            </h2>
            <p class="text-lg md:text-xl text-purple-100 leading-relaxed mb-8 max-w-md">
                Sistem pemeliharaan dan peningkatan mutu pendidikan tinggi secara berkelanjutan di STKIP Pasundan Cimahi. EduMetrics dirancang untuk memastikan seluruh proses penjaminan mutu berjalan efektif, terintegrasi, dan sejalan dengan visi-misi institusi. Platform ini mendukung pemenuhan kebutuhan seluruh stakeholders melalui penyelenggaraan perguruan tinggi yang bermutu, transparan, dan akuntabel.
            </p>
            
            <!-- Download Guide Button -->
            <a href="#" class="inline-flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl max-w-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Download Panduan</span>
            </a>
        </div>

        <!-- Copyright -->
        <div class="text-sm text-purple-200 animate-fade-in-up animate-delay-200">
            © {{ date('Y') }} Sistem Penjaminan Mutu Internal
        </div>
    </div>
</div>

