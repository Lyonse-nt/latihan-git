<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>A4A Admin Panel - @yield('title', 'Dashboard')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col">

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 border-r border-slate-800 flex-shrink-0 flex flex-col hidden md:flex">
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-6 border-b border-slate-800 bg-slate-950">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-wider text-indigo-400 flex items-center gap-2">
                    <span class="text-2xl">🔥</span> A4A BACKEND
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    📊 Dashboard
                </a>
                
                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Modul Data</div>
                
                <a href="{{ route('members.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('members.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    👥 Members
                </a>
                <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('projects.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    💻 Projects
                </a>
                <a href="{{ route('gallery.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('gallery.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    🖼️ Gallery
                </a>
                <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('events.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    📅 Events
                </a>
                <a href="{{ route('timeline.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('timeline.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    ⏳ Timeline
                </a>
                <a href="{{ route('hall-of-fame.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('hall-of-fame.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    🏆 Hall of Fame
                </a>
                <a href="{{ route('quotes.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('quotes.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    💬 Quotes
                </a>
                <a href="{{ route('guestbook.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('guestbook.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    📖 Guestbook
                </a>
                <a href="{{ route('announcements.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('announcements.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    📢 Announcements
                </a>

                @if(auth()->user()->isSuperAdmin())
                    <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengaturan Sistem</div>
                    <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('users.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                        🛡️ Manage Users
                    </a>
                @endif
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-800 bg-slate-950 flex flex-col gap-2">
                <div class="text-xs text-slate-500">Logged in as:</div>
                <div class="font-medium text-slate-300 truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-indigo-400 uppercase font-semibold">{{ auth()->user()->role }}</div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="h-16 bg-slate-900 border-b border-slate-800 flex items-center justify-between px-6 z-10">
                <div class="flex items-center gap-4">
                    <!-- Mobile Hamburger -->
                    <button class="text-slate-400 hover:text-slate-200 md:hidden" onclick="toggleMobileMenu()">
                        🍔
                    </button>
                    <!-- Breadcrumbs -->
                    <nav class="flex text-sm text-slate-400" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('dashboard') }}" class="hover:text-slate-200">Admin</a>
                            </li>
                            @yield('breadcrumbs')
                        </ol>
                    </nav>
                </div>

                <!-- User Dropdown & Profile Actions -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 px-3.5 py-1.5 rounded-lg transition-colors border border-slate-700">
                        ⚙️ Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-rose-400 hover:text-rose-300 bg-rose-950/30 hover:bg-rose-950/50 px-3.5 py-1.5 rounded-lg transition-colors border border-rose-900/50">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Scrollable Section -->
            <main class="flex-1 overflow-y-auto p-6 bg-slate-950">
                <!-- Session Alerts -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-950/40 border border-emerald-500/30 rounded-xl text-emerald-300 flex items-center gap-3">
                        <span>✅</span>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-950/40 border border-rose-500/30 rounded-xl text-rose-300 flex items-center gap-3">
                        <span>⚠️</span>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Navigation Overlay (Toggleable) -->
    <div id="mobile-menu" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden md:hidden">
        <div class="w-64 bg-slate-900 h-full flex flex-col border-r border-slate-800">
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800 bg-slate-950">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-wider text-indigo-400">🔥 A4A BACKEND</a>
                <button class="text-slate-400 text-xl" onclick="toggleMobileMenu()">✕</button>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300" onclick="toggleMobileMenu()">📊 Dashboard</a>
                <a href="{{ route('members.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300" onclick="toggleMobileMenu()">👥 Members</a>
                <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300" onclick="toggleMobileMenu()">💻 Projects</a>
                <a href="{{ route('gallery.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300" onclick="toggleMobileMenu()">🖼️ Gallery</a>
                <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300" onclick="toggleMobileMenu()">📅 Events</a>
                <a href="{{ route('timeline.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300" onclick="toggleMobileMenu()">⏳ Timeline</a>
                <a href="{{ route('hall-of-fame.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300" onclick="toggleMobileMenu()">🏆 Hall of Fame</a>
                <a href="{{ route('quotes.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300" onclick="toggleMobileMenu()">💬 Quotes</a>
                <a href="{{ route('guestbook.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300" onclick="toggleMobileMenu()">📖 Guestbook</a>
                <a href="{{ route('announcements.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300" onclick="toggleMobileMenu()">📢 Announcements</a>
                @if(auth()->user()->isSuperAdmin())
                    <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-300" onclick="toggleMobileMenu()">🛡️ Manage Users</a>
                @endif
            </nav>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Bulk Delete Helper Script
        document.addEventListener('DOMContentLoaded', () => {
            const selectAllCheckbox = document.getElementById('select-all');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const bulkForm = document.getElementById('bulk-delete-form');

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', () => {
                    rowCheckboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
                    toggleBulkDeleteButton();
                });
            }

            rowCheckboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                    if (!cb.checked && selectAllCheckbox) selectAllCheckbox.checked = false;
                    if (document.querySelectorAll('.row-checkbox:checked').length === rowCheckboxes.length && selectAllCheckbox) {
                        selectAllCheckbox.checked = true;
                    }
                    toggleBulkDeleteButton();
                });
            });

            function toggleBulkDeleteButton() {
                if (bulkDeleteBtn) {
                    const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
                    if (checkedCount > 0) {
                        bulkDeleteBtn.classList.remove('hidden');
                    } else {
                        bulkDeleteBtn.classList.add('hidden');
                    }
                }
            }

            if (bulkForm) {
                bulkForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin menghapus data terpilih?')) {
                        // Append checked IDs to form
                        const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
                        checkedCheckboxes.forEach(cb => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = cb.value;
                            bulkForm.appendChild(input);
                        });
                        bulkForm.submit();
                    }
                });
            }
        });
    </script>
</body>
</html>
