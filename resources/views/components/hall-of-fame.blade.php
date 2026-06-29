<section id="hall-of-fame" class="py-24 px-6">
    <div class="container mx-auto max-w-7xl">
        <h2 class="text-5xl font-bold font-['Sora'] text-center mb-16 gradient-text animate-fade-up">
            Penghargaan
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $awards = [
                ['title' => 'Paling Lucu', 'winner' => 'Member 5', 'icon' => '😂'],
                ['title' => 'Paling Aktif', 'winner' => 'Member 3', 'icon' => '⚡'],
                ['title' => 'Paling Coding', 'winner' => 'Member 8', 'icon' => '💻'],
                ['title' => 'Paling Telat', 'winner' => 'Member 12', 'icon' => '⏰'],
                ['title' => 'Paling Random', 'winner' => 'Member 7', 'icon' => '🎲'],
                ['title' => 'Paling Kreatif', 'winner' => 'Member 10', 'icon' => '🎨']
            ];
            @endphp
            
            @foreach($awards as $award)
            <div class="relative overflow-hidden rounded-3xl text-center hover-lift animate-scale transition-all duration-500 group">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl border border-white/20 rounded-3xl"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-[#6366F1]/0 to-[#8B5CF6]/0 group-hover:from-[#6366F1]/10 group-hover:to-[#8B5CF6]/10 rounded-3xl transition-all duration-500"></div>
                <div class="relative p-8">
                    <div class="text-6xl mb-4">{{ $award['icon'] }}</div>
                    <h3 class="text-2xl font-bold font-['Sora'] mb-2">{{ $award['title'] }}</h3>
                    <p class="text-[#22D3EE] text-lg">{{ $award['winner'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
