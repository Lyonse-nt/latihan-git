@extends('layouts.admin')

@section('title', 'Manage Timeline')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-400">Timeline</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Kelola Timeline Milestones</h1>
            <p class="text-sm text-slate-400 mt-1">Daftar momen bersejarah dan pencapaian faksi A4A.</p>
        </div>
        <div class="flex items-center gap-3">
            <form id="bulk-delete-form" action="{{ route('timeline.bulkDestroy') }}" method="POST">
                @csrf
                <button type="submit" id="bulk-delete-btn" class="hidden text-sm font-semibold text-rose-400 hover:text-rose-300 bg-rose-950/30 hover:bg-rose-950/50 border border-rose-900/50 px-4 py-2 rounded-xl transition-colors">
                    🗑️ Hapus Terpilih
                </button>
            </form>
            <a href="{{ route('timeline.create') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-xl transition-colors">
                ➕ Tambah Milestones
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex gap-4 items-center justify-between">
        <form method="GET" action="{{ route('timeline.index') }}" class="w-full flex gap-4">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul milestone atau deskripsi..." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
            </div>
            <button type="submit" class="bg-slate-850 hover:bg-slate-800 border border-slate-700 text-slate-300 text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('timeline.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-slate-200 text-sm font-semibold px-4 py-2 rounded-xl transition-colors flex items-center justify-center">
                    Reset
                </a>
            @endif
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
                        <th class="p-4 w-24">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'sort_order', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Urutan {!! request('sort') === 'sort_order' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4 w-16 text-center">Icon</th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Judul Milestone {!! request('sort') === 'title' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Tanggal {!! request('sort') === 'date' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($timelines as $timeline)
                        <tr class="hover:bg-slate-850/30 transition-colors text-sm text-slate-300">
                            <td class="p-4 text-center">
                                <input type="checkbox" value="{{ $timeline->id }}" class="row-checkbox rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0">
                            </td>
                            <td class="p-4 font-bold text-indigo-400 text-center">
                                {{ $timeline->sort_order }}
                            </td>
                            <td class="p-4 text-center text-lg">
                                @if($timeline->icon === 'trophy') 🏆
                                @elseif($timeline->icon === 'flag') 🚩
                                @elseif($timeline->icon === 'star') ⭐
                                @elseif($timeline->icon === 'heart') ❤️
                                @elseif($timeline->icon === 'fire') 🔥
                                @else 📅 @endif
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-white">{{ $timeline->title }}</div>
                                <div class="text-xs text-slate-500 mt-0.5 truncate max-w-sm">{{ $timeline->description }}</div>
                            </td>
                            <td class="p-4 text-slate-400">{{ $timeline->date ? $timeline->date->format('d M Y') : '-' }}</td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('timeline.edit', $timeline) }}" class="text-xs font-medium text-indigo-400 hover:text-indigo-300 bg-indigo-950/20 hover:bg-indigo-950/40 px-2.5 py-1.5 rounded-lg border border-indigo-900/50 transition-colors inline-block">
                                    Edit
                                </a>
                                <form action="{{ route('timeline.destroy', $timeline) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus milestone ini?')">
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
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                Belum ada data timeline milestone.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($timelines->hasPages())
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                {{ $timelines->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
