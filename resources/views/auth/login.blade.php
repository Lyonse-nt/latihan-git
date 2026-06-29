<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - A4A Community">
    <title>Login - A4A</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#09090B] text-white font-['Poppins'] antialiased overflow-x-hidden">
    
    <!-- Background Effects -->
    <div class="fixed inset-0 bg-gradient-to-br from-[#6366F1]/10 via-[#09090B] to-[#8B5CF6]/10 -z-10"></div>
    <div class="fixed inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(99,102,241,0.1),transparent_50%)] -z-10"></div>
    
    <div class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <div class="animate-scale active">
            
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block mb-6">
                    <h1 class="text-5xl font-bold font-['Sora'] gradient-text">A4A</h1>
                </a>
                <h2 class="text-3xl font-bold font-['Sora'] mb-2">Selamat Datang Kembali</h2>
                <p class="text-gray-400">Masuk ke akun Anda untuk melanjutkan</p>
            </div>
            
            <!-- Login Form -->
            <div class="glass p-8 rounded-3xl">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email Field -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-semibold mb-2">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            autofocus
                            autocomplete="username"
                            class="w-full px-4 py-3 bg-[#09090B] border border-white/10 rounded-xl focus:outline-none focus:border-[#6366F1] transition-colors text-white placeholder-gray-500"
                            placeholder="nama@email.com">
                        @error('email')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password Field -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold mb-2">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 bg-[#09090B] border border-white/10 rounded-xl focus:outline-none focus:border-[#6366F1] transition-colors text-white placeholder-gray-500"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    
                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                id="remember"
                                class="w-4 h-4 rounded border-white/10 bg-[#09090B] text-[#6366F1] focus:ring-[#6366F1] focus:ring-offset-0">
                            <span class="ml-2 text-sm text-gray-300">Ingat saya</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#6366F1] hover:text-[#8B5CF6] transition-colors">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full px-6 py-4 bg-gradient-to-r from-[#6366F1] to-[#8B5CF6] hover:from-[#8B5CF6] hover:to-[#22D3EE] rounded-xl font-semibold text-lg transition-all duration-300 btn-ripple mb-6">
                        Masuk
                    </button>
                    
                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-gray-400">
                            Belum punya akun? 
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-[#6366F1] hover:text-[#8B5CF6] font-semibold transition-colors">
                                    Daftar sekarang
                                </a>
                            @endif
                        </p>
                    </div>
                </form>
            </div>
            
            <!-- Back to Home -->
            <div class="text-center mt-8">
                <a href="/" class="text-gray-400 hover:text-white transition-colors inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
            
        </div>
    </div>

        </div>
    </div>
    
</body>
</html>
