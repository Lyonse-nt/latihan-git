<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Member Dashboard - A4A</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
    
    <!-- Navbar -->
    <nav class="border-b border-slate-800 bg-slate-900 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="text-2xl font-bold gradient-text">A4A</a>
                
                <div class="flex items-center gap-4">
                    <a href="/" class="text-slate-400 hover:text-white transition-colors text-sm">Beranda</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-rose-400 hover:text-rose-300 bg-rose-950/30 hover:bg-rose-950/50 px-4 py-2 rounded-xl transition-colors border border-rose-900/50">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-12 max-w-4xl">
        
        @if($member)
        <!-- Profile Card (IG Style) -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Profile Photo -->
                <div class="flex-shrink-0">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 p-1">
                        <div class="w-full h-full rounded-full bg-slate-900 flex items-center justify-center overflow-hidden">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl font-bold text-indigo-400">{{ substr($member->name, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1">
                    <div class="flex items-center gap-4 mb-4">
                        <h1 class="text-3xl font-bold text-white">{{ $member->name }}</h1>
                        @if($member->is_active)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Active</span>
                        @endif
                    </div>

                    <div class="space-y-3 text-slate-300">
                        <div class="flex items-center gap-2">
                            <span class="text-indigo-400 font-semibold">@</span>
                            <span>{{ $member->nickname ?? 'No nickname' }}</span>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <span class="text-indigo-400">🎯</span>
                            <span>{{ $member->role }}</span>
                        </div>

                        @if($member->date_of_birth)
                        <div class="flex items-center gap-2">
                            <span class="text-indigo-400">🎂</span>
                            <span>{{ \Carbon\Carbon::parse($member->date_of_birth)->format('d F Y') }}</span>
                        </div>
                        @endif

                        @if($member->email)
                        <div class="flex items-center gap-2">
                            <span class="text-indigo-400">📧</span>
                            <span>{{ $member->email }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Social Links -->
                    <div class="flex items-center gap-4 mt-6">
                        @if($member->instagram)
                        <a href="https://instagram.com/{{ $member->instagram }}" target="_blank" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity">
                            Instagram
                        </a>
                        @endif
                        
                        @if($member->github)
                        <a href="https://github.com/{{ $member->github }}" target="_blank" class="px-4 py-2 bg-slate-800 rounded-xl text-sm font-semibold hover:bg-slate-700 transition-colors">
                            GitHub
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bio Section -->
            @if($member->bio)
            <div class="mt-8 pt-8 border-t border-slate-800">
                <h3 class="text-lg font-semibold text-white mb-3">Bio</h3>
                <p class="text-slate-400 leading-relaxed">{{ $member->bio }}</p>
            </div>
            @endif
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4 mt-6">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 text-center">
                <div class="text-3xl font-bold text-indigo-400">{{ $member->projects()->count() }}</div>
                <div class="text-sm text-slate-400 mt-1">Projects</div>
            </div>
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 text-center">
                <div class="text-3xl font-bold text-indigo-400">{{ $member->galleries()->count() }}</div>
                <div class="text-sm text-slate-400 mt-1">Galleries</div>
            </div>
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 text-center">
                <div class="text-3xl font-bold text-indigo-400">{{ $member->hallOfFames()->count() }}</div>
                <div class="text-sm text-slate-400 mt-1">Awards</div>
            </div>
        </div>

        @else
        <!-- No Member Profile Found -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-12 text-center">
            <div class="text-6xl mb-4">👤</div>
            <h2 class="text-2xl font-bold text-white mb-2">Profile Belum Dibuat</h2>
            <p class="text-slate-400 mb-6">
                Akun kamu belum terhubung dengan data member. <br>
                Hubungi admin atau developer untuk membuat profile member.
            </p>
            <div class="text-sm text-slate-500">
                Email: {{ $user->email }}
            </div>
        </div>
        @endif

    </div>

</body>
</html>
