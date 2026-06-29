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
            <div class="glass p-8 rounded-3xl text-center hover-lift animate-scale">
                <div class="text-6xl mb-4">{{ $award['icon'] }}</div>
                <h3 class="text-2xl font-bold font-['Sora'] mb-2">{{ $award['title'] }}</h3>
                <p class="text-[#22D3EE] text-lg">{{ $award['winner'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
