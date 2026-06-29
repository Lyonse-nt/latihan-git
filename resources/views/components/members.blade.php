<section id="members" class="py-24 px-6">
    <div class="container mx-auto max-w-7xl">
        <h2 class="text-5xl font-bold font-['Sora'] text-center mb-6 gradient-text animate-fade-up">
            Kenali Tim Kami
        </h2>
        <p class="text-center text-gray-400 text-lg mb-16 animate-fade-up">
            16 individu, satu tim yang solid
        </p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @for($i = 1; $i <= 16; $i++)
            <div class="member-card group relative overflow-hidden rounded-3xl cursor-pointer animate-scale transition-all duration-500"
                 data-name="Member {{ $i }}"
                 data-nickname="Nickname {{ $i }}"
                 data-role="Full Stack Developer"
                 data-image="https://ui-avatars.com/api/?name=Member+{{ $i }}&size=400&background=6366F1&color=fff">
                
                <!-- Glass Card Background -->
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl border border-white/20 rounded-3xl"></div>
                
                <!-- Glow Effect on Hover -->
                <div class="absolute inset-0 bg-gradient-to-br from-[#6366F1]/0 to-[#8B5CF6]/0 group-hover:from-[#6366F1]/20 group-hover:to-[#8B5CF6]/20 rounded-3xl transition-all duration-500"></div>
                
                <!-- Content -->
                <div class="relative p-8">
                    <!-- Avatar with Glow -->
                    <div class="relative mb-6 mx-auto w-32 h-32">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#6366F1] to-[#8B5CF6] rounded-2xl blur-2xl opacity-50 group-hover:opacity-70 transition-opacity duration-500"></div>
                        <div class="relative w-full h-full rounded-2xl overflow-hidden border-2 border-white/20 group-hover:border-[#6366F1] transition-all duration-500 group-hover:scale-110">
                            <img src="https://ui-avatars.com/api/?name=Member+{{ $i }}&size=400&background=6366F1&color=fff" 
                                 alt="Member {{ $i }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div class="text-center">
                        <h3 class="text-xl font-bold font-['Sora'] mb-2 group-hover:text-[#6366F1] transition-colors duration-300">
                            Member {{ $i }}
                        </h3>
                        <p class="text-[#22D3EE] text-sm font-medium mb-3">"Nickname {{ $i }}"</p>
                        <p class="text-gray-400 text-sm">Full Stack Developer</p>
                    </div>
                    
                    <!-- Hover Indicator -->
                    <div class="mt-4 pt-4 border-t border-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <p class="text-xs text-gray-500 text-center">Klik untuk detail</p>
                    </div>
                </div>
                
                <!-- Border Shine Effect -->
                <div class="absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                     style="background: linear-gradient(135deg, rgba(99,102,241,0.3) 0%, transparent 50%, rgba(139,92,246,0.3) 100%); 
                            background-size: 200% 200%; 
                            animation: shine 3s ease-in-out infinite;">
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>
