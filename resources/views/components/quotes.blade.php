<section id="quotes" class="py-24 px-6 bg-gradient-to-b from-transparent to-[#18181B]/50">
    <div class="container mx-auto max-w-4xl">
        <h2 class="text-5xl font-bold font-['Sora'] text-center mb-16 gradient-text animate-fade-up">
            Kata-kata Inspiratif
        </h2>
        
        <div class="relative h-64">
            @php
            $quotes = [
                ['text' => 'Code is poetry written in logic.', 'author' => 'Member 1'],
                ['text' => 'Together we code, together we grow.', 'author' => 'Member 5'],
                ['text' => 'Debugging is like being a detective.', 'author' => 'Member 8'],
                ['text' => 'In A4A, we trust in loops and functions.', 'author' => 'Member 12']
            ];
            @endphp
            
            @foreach($quotes as $index => $quote)
            <div class="quote-item absolute inset-0 flex items-center justify-center {{ $index === 0 ? 'active' : 'hidden' }} animate-fade-in">
                <div class="relative overflow-hidden rounded-3xl w-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl border border-white/20 rounded-3xl"></div>
                    <div class="relative p-12 text-center">
                        <svg class="w-12 h-12 text-[#6366F1] mb-4 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                        <p class="text-2xl md:text-3xl font-['Sora'] mb-6 text-white">
                            "{{ $quote['text'] }}"
                        </p>
                        <p class="text-[#22D3EE] text-lg">— {{ $quote['author'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
