@extends('layouts.admin')

@section('title', 'Manage System Users')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-400">Users</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Kelola Akun Admin / Moderator</h1>
            <p class="text-sm text-slate-400 mt-1">Daftar staf administrator dengan hak akses ke panel ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <form id="bulk-delete-form" action="{{ route('users.bulkDestroy') }}" method="POST">
                @csrf
                <button type="submit" id="bulk-delete-btn" class="hidden text-sm font-semibold text-rose-400 hover:text-rose-300 bg-rose-950/30 hover:bg-rose-950/50 border border-rose-900/50 px-4 py-2 rounded-xl transition-colors">
                    🗑️ Hapus Terpilih
                </button>
            </form>
            <a href="{{ route('users.create') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-xl transition-colors">
                ➕ Tambah Staff
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row gap-4 items-center justify-between">
        <form method="GET" action="{{ route('users.index') }}" class="w-full flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email..." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
            </div>

            <!-- Filter Role -->
            <div class="w-full md:w-48">
                <select name="role" onchange="this.form.submit()" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-355 focus:outline-none focus:border-indigo-500">
                    <option value="">Semua Hak Akses</option>
                    <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="moderator" {{ request('role') === 'moderator' ? 'selected' : '' }}>Moderator</option>
                </select>
            </div>

            <!-- Filter Status -->
            <div class="w-full md:w-48">
                <select name="status" onchange="this.form.submit()" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-355 focus:outline-none focus:border-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-2">
                <button type="submit" class="bg-slate-850 hover:bg-slate-800 border border-slate-700 text-slate-300 text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'role', 'status']))
                    <a href="{{ route('users.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-slate-200 text-sm font-semibold px-4 py-2 rounded-xl transition-colors flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 bg-slate-950 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                        <th class="p-4 w-12 text-center">
                            <input type="checkbox" id="select-all" class="rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0">
                        </th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Nama Staff {!! request('sort') === 'name' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Email {!! request('sort') === 'email' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">Hak Akses / Role</th>
                        <th class="p-4 text-center">Status Akun</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($users as $usr)
                        <tr class="hover:bg-slate-850/30 transition-colors text-sm text-slate-300">
                            <td class="p-4 text-center">
                                <!-- Prevent self-select for deletion -->
                                @if(auth()->id() !== $usr->id)
                                    <input type="checkbox" value="{{ $usr->id }}" class="row-checkbox rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0">
                                @else
                                    <span class="text-xs text-slate-600 block text-center" title="Akun Anda Sendiri">🔒</span>
                                @endif
                            </td>
                            <td class="p-4 font-semibold text-white">
                                {{ $usr->name }}
                                @if(auth()->id() === $usr->id)
                                    <span class="ml-1 text-xs text-indigo-400 font-normal italic bg-indigo-950/40 border border-indigo-900/50 px-2 py-0.5 rounded-md">(Anda)</span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-400">{{ $usr->email }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold 
                                    @if($usr->role === 'super_admin') bg-rose-500/10 text-rose-455 border border-rose-500/20
                                    @elseif($usr->role === 'admin') bg-indigo-500/10 text-indigo-400 border border-indigo-500/20
                                    @else bg-slate-800 text-slate-400 border border-slate-700 @endif">
                                    {{ strtoupper(str_replace('_', ' ', $usr->role)) }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                @if($usr->status === 'active')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        ● Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                        ● Ditangguhkan
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('users.edit', $usr) }}" class="text-xs font-medium text-indigo-400 hover:text-indigo-300 bg-indigo-950/20 hover:bg-indigo-950/40 px-2.5 py-1.5 rounded-lg border border-indigo-900/50 transition-colors inline-block">
                                    Edit / Reset
                                </a>
                                @if(auth()->id() !== $usr->id)
                                    <form action="{{ route('users.destroy', $usr) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun staff ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-rose-400 hover:text-rose-300 bg-rose-950/20 hover:bg-rose-950/40 px-2.5 py-1.5 rounded-lg border border-rose-900/50 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-655 font-medium select-none px-2.5 py-1.5 opacity-50">Hapus</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                Belum ada data user staff.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
