<section id="members" class="py-24 px-6">
    <div class="container mx-auto max-w-7xl">
        <h2 class="text-5xl font-bold font-['Sora'] text-center mb-6 gradient-text animate-fade-up">
            Kenali Tim Kami
        </h2>
        <p class="text-center text-gray-400 text-lg mb-16 animate-fade-up">
            16 individu, satu tim yang solid
        </p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @for($i = 1; $i <= 16; $i++)
            <div class="member-card glass p-6 rounded-3xl text-center hover-lift cursor-pointer animate-scale"
                 data-name="Member {{ $i }}"
                 data-nickname="Nickname {{ $i }}"
                 data-role="Full Stack Developer"
                 data-image="https://ui-avatars.com/api/?name=Member+{{ $i }}&size=200&background=6366F1&color=fff">
                <div class="relative mb-4">
                    <div class="absolute inset-0 bg-[#6366F1] rounded-full blur-xl opacity-30"></div>
                    <img src="https://ui-avatars.com/api/?name=Member+{{ $i }}&size=200&background=6366F1&color=fff" 
                         alt="Member {{ $i }}" 
                         class="relative w-24 h-24 rounded-full mx-auto object-cover border-4 border-[#6366F1]">
                </div>
                <h3 class="text-xl font-bold font-['Sora'] mb-2">Member {{ $i }}</h3>
                <p class="text-[#22D3EE] text-sm mb-2">"Nickname {{ $i }}"</p>
                <p class="text-gray-400 text-sm">Full Stack Developer</p>
            </div>
            @endfor
        </div>
    </div>
</section>
