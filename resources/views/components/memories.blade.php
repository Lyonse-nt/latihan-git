<section id="memories" class="py-24 px-6 bg-gradient-to-b from-[#18181B]/50 to-transparent">
    <div class="container mx-auto max-w-7xl">
        <h2 class="text-5xl font-bold font-['Sora'] text-center mb-6 gradient-text animate-fade-up">
            Kenangan
        </h2>
        <p class="text-center text-gray-400 text-lg mb-12 animate-fade-up">
            Momen yang berharga
        </p>
        
        <!-- Filter Buttons -->
        <div class="flex flex-wrap justify-center gap-4 mb-12 animate-fade-up">
            <button class="filter-btn px-6 py-2 rounded-full bg-[#6366F1] text-white transition-all duration-300" data-filter="all">Semua</button>
            <button class="filter-btn px-6 py-2 rounded-full glass hover:bg-[#6366F1]/20 transition-all duration-300" data-filter="events">Kegiatan</button>
            <button class="filter-btn px-6 py-2 rounded-full glass hover:bg-[#6366F1]/20 transition-all duration-300" data-filter="projects">Proyek</button>
            <button class="filter-btn px-6 py-2 rounded-full glass hover:bg-[#6366F1]/20 transition-all duration-300" data-filter="fun">Santai</button>
        </div>
        
        <!-- Masonry Gallery -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach(['events', 'projects', 'fun', 'events', 'fun', 'projects', 'events', 'fun'] as $index => $category)
            <div class="gallery-item animate-scale cursor-pointer overflow-hidden rounded-2xl hover-lift" data-category="{{ $category }}">
                <img data-src="https://source.unsplash.com/random/400x{{ 300 + ($index % 3) * 100 }}?sig={{ $index }}" 
                     class="lazy w-full h-full object-cover" 
                     alt="Memory {{ $index + 1 }}">
            </div>
            @endforeach
        </div>
    </div>
</section>
