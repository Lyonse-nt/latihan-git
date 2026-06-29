@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <li class="inline-flex items-center text-slate-100 font-semibold">
        <span class="mx-2 text-slate-600">/</span> Dashboard
    </li>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-white">Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p class="text-slate-400 mt-1">Gunakan panel ini untuk mengelola seluruh data website komunitas kelas A4A (Antek Antek Akey).</p>
        </div>
        <div class="px-4 py-2 bg-slate-900 border border-slate-800 rounded-xl text-indigo-400 text-sm font-semibold">
            📅 {{ date('d F Y') }}
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Members Card -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 transition-all hover:border-slate-700">
            <div class="flex items-center justify-between">
                <span class="text-3xl">👥</span>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Data</span>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl font-bold text-white tracking-tight">{{ $stats['members'] }}</h3>
                <p class="text-sm text-slate-400 mt-1">Jumlah Member</p>
            </div>
            <a href="{{ route('members.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium inline-flex items-center gap-1 mt-4">
                Kelola Member ➔
            </a>
        </div>

        <!-- Projects Card -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 transition-all hover:border-slate-700">
            <div class="flex items-center justify-between">
                <span class="text-3xl">💻</span>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Karya</span>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl font-bold text-white tracking-tight">{{ $stats['projects'] }}</h3>
                <p class="text-sm text-slate-400 mt-1">Jumlah Project</p>
            </div>
            <a href="{{ route('projects.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium inline-flex items-center gap-1 mt-4">
                Kelola Project ➔
            </a>
        </div>

        <!-- Galleries Card -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 transition-all hover:border-slate-700">
            <div class="flex items-center justify-between">
                <span class="text-3xl">🖼️</span>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Memori</span>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl font-bold text-white tracking-tight">{{ $stats['galleries'] }}</h3>
                <p class="text-sm text-slate-400 mt-1">Foto Gallery</p>
            </div>
            <a href="{{ route('gallery.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium inline-flex items-center gap-1 mt-4">
                Kelola Gallery ➔
            </a>
        </div>

        <!-- Guestbook Card -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 transition-all hover:border-slate-700">
            <div class="flex items-center justify-between">
                <span class="text-3xl">📖</span>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Pesan</span>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl font-bold text-white tracking-tight">{{ $stats['guestbook'] }}</h3>
                <p class="text-sm text-slate-400 mt-1">Isi Guestbook</p>
            </div>
            <a href="{{ route('guestbook.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium inline-flex items-center gap-1 mt-4">
                Review Guestbook ➔
            </a>
        </div>

        <!-- Users Card - Only for Developer -->
        @if(auth()->user()->isDeveloper())
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 transition-all hover:border-slate-700">
            <div class="flex items-center justify-between">
                <span class="text-3xl">🛡️</span>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Staff</span>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl font-bold text-white tracking-tight">{{ $stats['users'] }}</h3>
                <p class="text-sm text-slate-400 mt-1">User Admin</p>
            </div>
            <a href="{{ route('users.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium inline-flex items-center gap-1 mt-4">
                Kelola User Admin ➔
            </a>
        </div>
        @endif
    </div>

    <!-- Recent Activity Section -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6">
        <h2 class="text-xl font-bold text-white mb-4">Aktivitas Terbaru</h2>
        <div class="flow-root">
            @if($recentActivities->isEmpty())
                <p class="text-slate-400 text-sm py-4">Belum ada aktivitas yang tercatat.</p>
            @else
                <ul role="list" class="-mb-8">
                    @foreach($recentActivities as $index => $activity)
                        <li>
                            <div class="relative pb-8">
                                @if($index < $recentActivities->count() - 1)
                                    <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-slate-800" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-between text-base bg-slate-800 border border-slate-700">
                                            @if($activity->action === 'create') ➕ 
                                            @elseif($activity->action === 'update') ✏️ 
                                            @elseif($activity->action === 'delete') 🗑️ 
                                            @else ℹ️ @endif
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-slate-300">
                                                <span class="font-semibold text-slate-100">{{ $activity->username }}</span> 
                                                {{ $activity->description }}
                                            </p>
                                        </div>
                                        <div class="text-right text-xs whitespace-nowrap text-slate-500">
                                            <time datetime="{{ $activity->created_at }}">{{ $activity->created_at->diffForHumans() }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
