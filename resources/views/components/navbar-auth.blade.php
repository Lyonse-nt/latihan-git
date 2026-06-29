<nav id="navbar" class="fixed top-0 left-0 right-0 z-40 bg-transparent transition-all duration-300">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="/" class="text-2xl font-bold font-['Sora'] gradient-text">
                A4A
            </a>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="/" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Beranda</a>
                <a href="/#about" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Tentang</a>
                <a href="/#members" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Anggota</a>
                <a href="/dashboard" class="nav-link text-white hover:text-[#6366F1] transition-colors py-2">Dashboard</a>
            </div>
            
            <!-- User Menu -->
            <div class="hidden md:flex items-center gap-4" x-data="{ open: false }">
                <div class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 glass rounded-full hover:bg-[#6366F1]/20 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#6366F1] to-[#8B5CF6] flex items-center justify-center">
                            <span class="text-sm font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 glass rounded-2xl py-2 shadow-xl">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-white hover:bg-[#6366F1]/20 transition-colors">
                            Profil Saya
                        </a>
                        <a href="/dashboard" class="block px-4 py-2 text-sm text-white hover:bg-[#6366F1]/20 transition-colors">
                            Dashboard
                        </a>
                        <div class="border-t border-white/10 my-2"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 transition-colors">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 space-y-4">
            <a href="/" class="block text-white hover:text-[#6366F1] transition-colors">Beranda</a>
            <a href="/#about" class="block text-white hover:text-[#6366F1] transition-colors">Tentang</a>
            <a href="/#members" class="block text-white hover:text-[#6366F1] transition-colors">Anggota</a>
            <a href="/dashboard" class="block text-white hover:text-[#6366F1] transition-colors">Dashboard</a>
            <div class="pt-4 border-t border-white/10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#6366F1] to-[#8B5CF6] flex items-center justify-center">
                        <span class="font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="block text-white hover:text-[#6366F1] transition-colors mb-2">Profil Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-400 hover:text-red-300 transition-colors">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
