<section id="timeline" class="py-24 px-6">
    <div class="container mx-auto max-w-4xl">
        <h2 class="text-5xl font-bold font-['Sora'] text-center mb-16 gradient-text animate-fade-up">
            Perjalanan Kami
        </h2>
        
        <div class="relative">
            <!-- Vertical Line -->
            <div class="absolute left-8 md:left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-[#6366F1] via-[#8B5CF6] to-[#22D3EE]"></div>
            
            <!-- Timeline Items -->
            @php
            $events = [
                ['year' => '2024', 'title' => 'Awal Pertemuan', 'desc' => 'Pertama kali berkumpul sebagai kelas A4A'],
                ['year' => '2024', 'title' => 'First Project', 'desc' => 'Memulai project pertama bersama sebagai tim'],
                ['year' => '2024', 'title' => 'Hackathon Victory', 'desc' => 'Meraih juara dalam kompetisi hackathon'],
                ['year' => '2024', 'title' => 'Community Growth', 'desc' => 'Berkembang menjadi komunitas yang solid']
            ];
            @endphp
            
            @foreach($events as $index => $event)
            <div class="relative mb-12 animate-fade-up">
                <div class="flex items-center {{ $index % 2 == 0 ? 'md:flex-row' : 'md:flex-row-reverse' }}">
                    <!-- Content -->
                    <div class="w-full md:w-5/12 {{ $index % 2 == 0 ? 'md:pr-12 md:text-right' : 'md:pl-12' }} ml-16 md:ml-0">
                        <div class="glass p-6 rounded-2xl hover-lift">
                            <span class="text-[#22D3EE] font-bold text-sm">{{ $event['year'] }}</span>
                            <h3 class="text-2xl font-bold font-['Sora'] mt-2 mb-3">{{ $event['title'] }}</h3>
                            <p class="text-gray-400">{{ $event['desc'] }}</p>
                        </div>
                    </div>
                    
                    <!-- Dot -->
                    <div class="absolute left-8 md:left-1/2 transform md:-translate-x-1/2 w-4 h-4 bg-[#6366F1] rounded-full border-4 border-[#09090B]"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
