@extends('layouts.admin')

@section('title', 'Manage Members')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-400">Members</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Kelola Member Kelas</h1>
            <p class="text-sm text-slate-400 mt-1">Daftar murid dan kepengurusan di dalam komunitas A4A.</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Bulk Delete Form -->
            <form id="bulk-delete-form" action="{{ route('members.bulkDestroy') }}" method="POST">
                @csrf
                <button type="submit" id="bulk-delete-btn" class="hidden text-sm font-semibold text-rose-400 hover:text-rose-300 bg-rose-950/30 hover:bg-rose-950/50 border border-rose-900/50 px-4 py-2 rounded-xl transition-colors">
                    🗑️ Hapus Terpilih
                </button>
            </form>
            
            <a href="{{ route('members.create') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-xl transition-colors shadow-lg shadow-indigo-600/20">
                ➕ Tambah Member
            </a>
        </div>
    </div>

    <!-- Filters and Search Bar -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row gap-4 items-center justify-between">
        <form method="GET" action="{{ route('members.index') }}" class="w-full flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, nickname, email, atau peran..." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <!-- Filter Status -->
            <div class="w-full md:w-48">
                <select name="is_active" onchange="this.form.submit()" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-300 focus:outline-none focus:border-indigo-500 transition-colors">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- Reset & Submit -->
            <div class="flex gap-2">
                <button type="submit" class="bg-slate-850 hover:bg-slate-800 border border-slate-700 text-slate-300 text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'is_active']))
                    <a href="{{ route('members.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-slate-200 text-sm font-semibold px-4 py-2 rounded-xl transition-colors flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Responsive Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 bg-slate-950 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                        <th class="p-4 w-12 text-center">
                            <input type="checkbox" id="select-all" class="rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0 focus:ring-offset-0">
                        </th>
                        <th class="p-4">Foto</th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Nama Lengkap {!! request('sort') === 'name' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'nickname', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Nickname {!! request('sort') === 'nickname' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'role', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Peran Kelas {!! request('sort') === 'role' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">Email</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($members as $member)
                        <tr class="hover:bg-slate-850/30 transition-colors text-sm text-slate-300">
                            <!-- Checkbox -->
                            <td class="p-4 text-center">
                                <input type="checkbox" value="{{ $member->id }}" class="row-checkbox rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0 focus:ring-offset-0">
                            </td>
                            
                            <!-- Photo -->
                            <td class="p-4">
                                <div class="w-10 h-10 rounded-full bg-slate-850 border border-slate-700 overflow-hidden flex items-center justify-center">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-lg">👤</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Name -->
                            <td class="p-4 font-semibold text-white">
                                <a href="{{ route('members.show', $member) }}" class="hover:underline hover:text-indigo-400">
                                    {{ $member->name }}
                                </a>
                            </td>

                            <!-- Nickname -->
                            <td class="p-4">{{ $member->nickname ?? '-' }}</td>

                            <!-- Class Role -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                    {{ $member->role }}
                                </span>
                            </td>

                            <!-- Email -->
                            <td class="p-4 text-slate-400">{{ $member->email ?? '-' }}</td>

                            <!-- Active -->
                            <td class="p-4 text-center">
                                @if($member->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        ● Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-800 text-slate-400 border border-slate-700">
                                        ● Nonaktif
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('members.show', $member) }}" class="text-xs font-medium text-slate-400 hover:text-white bg-slate-800 hover:bg-slate-750 px-2.5 py-1.5 rounded-lg border border-slate-700 transition-colors inline-block">
                                    Detail
                                </a>
                                <a href="{{ route('members.edit', $member) }}" class="text-xs font-medium text-indigo-400 hover:text-indigo-300 bg-indigo-950/20 hover:bg-indigo-950/40 px-2.5 py-1.5 rounded-lg border border-indigo-900/50 transition-colors inline-block">
                                    Edit
                                </a>
                                <form action="{{ route('members.destroy', $member) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus member ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-rose-400 hover:text-rose-300 bg-rose-950/20 hover:bg-rose-950/40 px-2.5 py-1.5 rounded-lg border border-rose-900/50 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-500">
                                Belum ada data member kelas yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($members->hasPages())
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
