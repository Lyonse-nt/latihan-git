@extends('layouts.admin')

@section('title', 'Manage Projects')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-400">Projects</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Kelola Project Karya</h1>
            <p class="text-sm text-slate-400 mt-1">Daftar karya, website, atau tools buatan member A4A.</p>
        </div>
        <div class="flex items-center gap-3">
            <form id="bulk-delete-form" action="{{ route('projects.bulkDestroy') }}" method="POST">
                @csrf
                <button type="submit" id="bulk-delete-btn" class="hidden text-sm font-semibold text-rose-400 hover:text-rose-300 bg-rose-950/30 hover:bg-rose-950/50 border border-rose-900/50 px-4 py-2 rounded-xl transition-colors">
                    🗑️ Hapus Terpilih
                </button>
            </form>
            <a href="{{ route('projects.create') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-xl transition-colors">
                ➕ Tambah Project
            </a>
        </div>
    </div>

    <!-- Filters and Search Bar -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4">
        <form method="GET" action="{{ route('projects.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="relative md:col-span-2">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama project atau deskripsi..." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
            </div>

            <!-- Filter Status -->
            <div>
                <select name="status" onchange="this.form.submit()" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-350 focus:outline-none focus:border-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 justify-end">
                <button type="submit" class="bg-indigo-650 hover:bg-indigo-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors flex-1">
                    Cari
                </button>
                @if(request()->anyFilled(['search', 'status', 'member_id']))
                    <a href="{{ route('projects.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-slate-200 text-sm font-semibold px-4 py-2 rounded-xl transition-colors flex items-center justify-center">
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
                        <th class="p-4">Thumbnail</th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Nama Project {!! request('sort') === 'name' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">Developer (Member)</th>
                        <th class="p-4">Link Repository</th>
                        <th class="p-4 text-center">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1 justify-center">
                                Status {!! request('sort') === 'status' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($projects as $project)
                        <tr class="hover:bg-slate-850/30 transition-colors text-sm text-slate-300">
                            <td class="p-4 text-center">
                                <input type="checkbox" value="{{ $project->id }}" class="row-checkbox rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0">
                            </td>
                            <td class="p-4">
                                <div class="w-16 h-10 rounded-lg bg-slate-850 border border-slate-800 overflow-hidden flex items-center justify-center">
                                    @if($project->thumbnail)
                                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-lg">💻</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-white">{{ $project->name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5 truncate max-w-xs">{{ $project->description }}</div>
                            </td>
                            <td class="p-4 text-slate-300">
                                @if($project->member)
                                    <a href="{{ route('members.show', $project->member) }}" class="hover:underline text-indigo-400">
                                        {{ $project->member->name }}
                                    </a>
                                @else
                                    <span class="text-slate-500">Umum / Tanpa Member</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($project->repository_url)
                                    <a href="{{ $project->repository_url }}" target="_blank" class="text-indigo-400 hover:underline">
                                        GitHub ➔
                                    </a>
                                @else
                                    <span class="text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                                    @if($project->status === 'completed') bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                                    @elseif($project->status === 'ongoing') bg-amber-500/10 text-amber-400 border border-amber-500/20
                                    @elseif($project->status === 'draft') bg-slate-800 text-slate-400 border border-slate-700
                                    @else bg-rose-500/10 text-rose-400 border border-rose-500/20 @endif">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('projects.edit', $project) }}" class="text-xs font-medium text-indigo-400 hover:text-indigo-300 bg-indigo-950/20 hover:bg-indigo-950/40 px-2.5 py-1.5 rounded-lg border border-indigo-900/50 transition-colors inline-block">
                                    Edit
                                </a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus project ini?')">
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
                            <td colspan="7" class="p-8 text-center text-slate-500">
                                Belum ada data project karya.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($projects->hasPages())
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
