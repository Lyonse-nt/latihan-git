@extends('layouts.admin')

@section('title', 'Manage Gallery')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-400">Gallery</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Kelola Gallery Foto</h1>
            <p class="text-sm text-slate-400 mt-1">Daftar album foto, memori kelas, dan dokumentasi kegiatan A4A.</p>
        </div>
        <div class="flex items-center gap-3">
            <form id="bulk-delete-form" action="{{ route('gallery.bulkDestroy') }}" method="POST">
                @csrf
                <button type="submit" id="bulk-delete-btn" class="hidden text-sm font-semibold text-rose-400 hover:text-rose-300 bg-rose-950/30 hover:bg-rose-950/50 border border-rose-900/50 px-4 py-2 rounded-xl transition-colors">
                    🗑️ Hapus Terpilih
                </button>
            </form>
            <a href="{{ route('gallery.create') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-xl transition-colors">
                ➕ Tambah Foto
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4">
        <form method="GET" action="{{ route('gallery.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari caption..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
            </div>

            <!-- Filter Category -->
            <div>
                <select name="category" onchange="this.form.submit()" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-355 focus:outline-none focus:border-indigo-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Visibility -->
            <div>
                <select name="visibility" onchange="this.form.submit()" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-355 focus:outline-none focus:border-indigo-500">
                    <option value="">Semua Visibilitas</option>
                    <option value="public" {{ request('visibility') === 'public' ? 'selected' : '' }}>Public</option>
                    <option value="private" {{ request('visibility') === 'private' ? 'selected' : '' }}>Private</option>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-2">
                <button type="submit" class="bg-indigo-650 hover:bg-indigo-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors flex-1">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'category', 'visibility']))
                    <a href="{{ route('gallery.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-slate-200 text-sm font-semibold px-4 py-2 rounded-xl transition-colors flex items-center justify-center">
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
                        <th class="p-4">Foto-foto</th>
                        <th class="p-4">Uploader (Member)</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Caption</th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Tanggal Foto {!! request('sort') === 'date' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4 text-center">Visibilitas</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($galleries as $gallery)
                        <tr class="hover:bg-slate-850/30 transition-colors text-sm text-slate-300">
                            <td class="p-4 text-center">
                                <input type="checkbox" value="{{ $gallery->id }}" class="row-checkbox rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0">
                            </td>
                            <td class="p-4">
                                <div class="flex gap-1.5 flex-wrap max-w-xs">
                                    @if(is_array($gallery->photos))
                                        @foreach(array_slice($gallery->photos, 0, 3) as $photo)
                                            <div class="w-10 h-10 rounded-lg overflow-hidden border border-slate-800 bg-slate-950">
                                                <img src="{{ asset('storage/' . $photo) }}" alt="Gallery" class="w-full h-full object-cover">
                                            </div>
                                        @endforeach
                                        @if(count($gallery->photos) > 3)
                                            <div class="w-10 h-10 rounded-lg bg-slate-800 text-slate-400 text-xs font-bold flex items-center justify-center border border-slate-750">
                                                +{{ count($gallery->photos) - 3 }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-slate-500">Kosong</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 text-slate-300 font-medium">
                                @if($gallery->member)
                                    <a href="{{ route('members.show', $gallery->member) }}" class="hover:underline text-indigo-400">
                                        {{ $gallery->member->name }}
                                    </a>
                                @else
                                    <span class="text-slate-500">Umum</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300 border border-slate-700 text-xs font-semibold">
                                    {{ $gallery->category }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="truncate max-w-xs text-slate-355" title="{{ $gallery->caption }}">
                                    {{ $gallery->caption ?? '-' }}
                                </div>
                            </td>
                            <td class="p-4 text-slate-400">
                                {{ $gallery->date ? $gallery->date->format('d M Y') : '-' }}
                            </td>
                            <td class="p-4 text-center">
                                @if($gallery->visibility === 'public')
                                    <span class="px-2 py-0.5 rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 text-xs font-medium">
                                        🔓 Public
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-500 border border-slate-750 text-xs font-medium">
                                        🔒 Private
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('gallery.edit', $gallery) }}" class="text-xs font-medium text-indigo-400 hover:text-indigo-300 bg-indigo-950/20 hover:bg-indigo-950/40 px-2.5 py-1.5 rounded-lg border border-indigo-900/50 transition-colors inline-block">
                                    Edit
                                </a>
                                <form action="{{ route('gallery.destroy', $gallery) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus album gallery ini?')">
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
                                Belum ada data gallery foto.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($galleries->hasPages())
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
