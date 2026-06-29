<section id="guestbook" class="py-24 px-6">
    <div class="container mx-auto max-w-3xl">
        <h2 class="text-5xl font-bold font-['Sora'] text-center mb-6 gradient-text animate-fade-up">
            Buku Tamu
        </h2>
        <p class="text-center text-gray-400 text-lg mb-12 animate-fade-up">
            Tinggalkan jejak dan bagikan pemikiranmu
        </p>
        
        <form id="guestbook-form" class="glass p-8 rounded-3xl animate-scale">
            <div class="mb-6">
                <label for="guest-name" class="block text-sm font-semibold mb-2">Nama Anda</label>
                <input 
                    type="text" 
                    id="guest-name" 
                    name="name" 
                    required
                    class="w-full px-4 py-3 bg-[#09090B] border border-white/10 rounded-xl focus:outline-none focus:border-[#6366F1] transition-colors"
                    placeholder="Nama Lengkap">
            </div>
            
            <div class="mb-6">
                <label for="guest-message" class="block text-sm font-semibold mb-2">Pesan Anda</label>
                <textarea 
                    id="guest-message" 
                    name="message" 
                    rows="5" 
                    required
                    class="w-full px-4 py-3 bg-[#09090B] border border-white/10 rounded-xl focus:outline-none focus:border-[#6366F1] transition-colors resize-none"
                    placeholder="Tulis sesuatu yang menarik..."></textarea>
            </div>
            
            <button 
                type="submit" 
                class="w-full px-6 py-4 bg-gradient-to-r from-[#6366F1] to-[#8B5CF6] hover:from-[#8B5CF6] hover:to-[#22D3EE] rounded-xl font-semibold text-lg transition-all duration-300 btn-ripple">
                Kirim Pesan 🚀
            </button>
        </form>
    </div>
</section>
