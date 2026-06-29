<nav id="navbar" class="fixed top-0 left-0 right-0 z-40 bg-transparent transition-all duration-300">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="#hero" class="text-2xl font-bold font-['Sora'] gradient-text">
                A4A
            </a>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#hero" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Beranda</a>
                <a href="#about" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Tentang</a>
                <a href="#members" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Anggota</a>
                <a href="#memories" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Kenangan</a>
                <a href="#timeline" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Perjalanan</a>
                <a href="#guestbook" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Buku Tamu</a>
            </div>
            
            <!-- CTA Button -->
            <a href="#guestbook" class="hidden md:block px-6 py-2 bg-[#6366F1] hover:bg-[#8B5CF6] rounded-full transition-all duration-300 btn-ripple">
                Tinggalkan Pesan 👋
            </a>
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 space-y-4">
            <a href="#hero" class="block text-white hover:text-[#6366F1] transition-colors">Beranda</a>
            <a href="#about" class="block text-white hover:text-[#6366F1] transition-colors">Tentang</a>
            <a href="#members" class="block text-white hover:text-[#6366F1] transition-colors">Anggota</a>
            <a href="#memories" class="block text-white hover:text-[#6366F1] transition-colors">Kenangan</a>
            <a href="#timeline" class="block text-white hover:text-[#6366F1] transition-colors">Perjalanan</a>
            <a href="#guestbook" class="block text-white hover:text-[#6366F1] transition-colors">Buku Tamu</a>
        </div>
    </div>
</nav>
