@extends('layouts.admin')

@section('title', 'Manage Events')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-400">Events</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Kelola Event Kelas</h1>
            <p class="text-sm text-slate-400 mt-1">Agenda kegiatan, rapat, dies natalis, atau kumpul-kumpul kelas A4A.</p>
        </div>
        <div class="flex items-center gap-3">
            <form id="bulk-delete-form" action="{{ route('events.bulkDestroy') }}" method="POST">
                @csrf
                <button type="submit" id="bulk-delete-btn" class="hidden text-sm font-semibold text-rose-400 hover:text-rose-300 bg-rose-950/30 hover:bg-rose-950/50 border border-rose-900/50 px-4 py-2 rounded-xl transition-colors">
                    🗑️ Hapus Terpilih
                </button>
            </form>
            <a href="{{ route('events.create') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-xl transition-colors">
                ➕ Tambah Event
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex gap-4 items-center justify-between">
        <form method="GET" action="{{ route('events.index') }}" class="w-full flex gap-4">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama event, lokasi, atau deskripsi..." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
            </div>
            <button type="submit" class="bg-slate-850 hover:bg-slate-800 border border-slate-700 text-slate-300 text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('events.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-slate-200 text-sm font-semibold px-4 py-2 rounded-xl transition-colors flex items-center justify-center">
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
                        <th class="p-4">Poster</th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Nama Event {!! request('sort') === 'name' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">Lokasi</th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Tanggal {!! request('sort') === 'date' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'time', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Jam {!! request('sort') === 'time' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($events as $event)
                        <tr class="hover:bg-slate-850/30 transition-colors text-sm text-slate-300">
                            <td class="p-4 text-center">
                                <input type="checkbox" value="{{ $event->id }}" class="row-checkbox rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0">
                            </td>
                            <td class="p-4">
                                <div class="w-12 h-16 rounded bg-slate-850 border border-slate-800 overflow-hidden flex items-center justify-center">
                                    @if($event->poster)
                                        <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xl">📅</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-white">{{ $event->name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5 truncate max-w-xs">{{ $event->description }}</div>
                            </td>
                            <td class="p-4 text-slate-300">{{ $event->location ?? '-' }}</td>
                            <td class="p-4 text-slate-455 font-semibold">{{ $event->date ? $event->date->format('d M Y') : '-' }}</td>
                            <td class="p-4 text-slate-400">
                                {{ $event->time ? date('H:i', strtotime($event->time)) : '-' }} WIB
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('events.edit', $event) }}" class="text-xs font-medium text-indigo-400 hover:text-indigo-300 bg-indigo-950/20 hover:bg-indigo-950/40 px-2.5 py-1.5 rounded-lg border border-indigo-900/50 transition-colors inline-block">
                                    Edit
                                </a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
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
                                Belum ada data event kelas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($events->hasPages())
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
