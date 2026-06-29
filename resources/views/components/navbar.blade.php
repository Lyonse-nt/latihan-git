<nav id="navbar" class="fixed top-0 left-0 right-0 z-40 bg-transparent transition-all duration-300">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="text-2xl font-bold font-['Sora'] gradient-text">A4A</a>

            @auth
                <!-- Desktop Nav - Authenticated -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="/" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Beranda</a>
                    <a href="/#about" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Tentang</a>
                    <a href="/#members" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Anggota</a>
                    <a href="/#memories" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Kenangan</a>
                    <a href="/#timeline" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Perjalanan</a>
                    <a href="/#guestbook" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Buku Tamu</a>
                    <a href="/dashboard" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Dashboard</a>
                </div>

                <!-- User Dropdown -->
                <div class="hidden md:flex items-center" x-data="{ open: false }">
                    <div class="relative">
                        <button @click="open = !open"
                            class="flex items-center gap-2 px-4 py-2 glass rounded-full hover:bg-[#6366F1]/20 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#6366F1] to-[#8B5CF6] flex items-center justify-center text-sm font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 glass rounded-2xl py-2 shadow-xl"
                             style="display:none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-white hover:bg-[#6366F1]/20 transition-colors rounded-xl">
                                Profil Saya
                            </a>
                            <a href="/dashboard" class="block px-4 py-2 text-sm text-white hover:bg-[#6366F1]/20 transition-colors rounded-xl">
                                Dashboard
                            </a>
                            <div class="border-t border-white/10 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 transition-colors rounded-xl">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Desktop Nav - Guest -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#hero" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Beranda</a>
                    <a href="#about" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Tentang</a>
                    <a href="#members" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Anggota</a>
                    <a href="#memories" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Kenangan</a>
                    <a href="#timeline" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Perjalanan</a>
                    <a href="#guestbook" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Buku Tamu</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-white hover:text-[#6366F1] transition-colors font-semibold">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-[#6366F1] hover:bg-[#8B5CF6] rounded-full transition-all duration-300 btn-ripple font-semibold">
                        Daftar
                    </a>
                </div>
            @endauth

            <!-- Mobile Hamburger -->
            <button id="mobile-menu-btn" class="md:hidden text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 space-y-3">
            @auth
                <a href="/" class="block text-white hover:text-[#6366F1] transition-colors">Beranda</a>
                <a href="/#about" class="block text-white hover:text-[#6366F1] transition-colors">Tentang</a>
                <a href="/#members" class="block text-white hover:text-[#6366F1] transition-colors">Anggota</a>
                <a href="/#memories" class="block text-white hover:text-[#6366F1] transition-colors">Kenangan</a>
                <a href="/#timeline" class="block text-white hover:text-[#6366F1] transition-colors">Perjalanan</a>
                <a href="/#guestbook" class="block text-white hover:text-[#6366F1] transition-colors">Buku Tamu</a>
                <a href="/dashboard" class="block text-white hover:text-[#6366F1] transition-colors">Dashboard</a>
                <div class="pt-4 border-t border-white/10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#6366F1] to-[#8B5CF6] flex items-center justify-center font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="block text-white hover:text-[#6366F1] transition-colors mb-3">Profil Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-400 hover:text-red-300 transition-colors">Keluar</button>
                    </form>
                </div>
            @else
                <a href="#hero" class="block text-white hover:text-[#6366F1] transition-colors">Beranda</a>
                <a href="#about" class="block text-white hover:text-[#6366F1] transition-colors">Tentang</a>
                <a href="#members" class="block text-white hover:text-[#6366F1] transition-colors">Anggota</a>
                <a href="#memories" class="block text-white hover:text-[#6366F1] transition-colors">Kenangan</a>
                <a href="#timeline" class="block text-white hover:text-[#6366F1] transition-colors">Perjalanan</a>
                <a href="#guestbook" class="block text-white hover:text-[#6366F1] transition-colors">Buku Tamu</a>
                <div class="pt-4 border-t border-white/10 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="text-white hover:text-[#6366F1] transition-colors font-semibold">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-[#6366F1] hover:bg-[#8B5CF6] rounded-full text-center transition-colors font-semibold">Daftar</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
