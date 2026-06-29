@extends('layouts.admin')

@section('title', 'Manage Hall of Fame')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-400">Hall of Fame</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Kelola Hall of Fame</h1>
            <p class="text-sm text-slate-400 mt-1">Daftar penghargaan dan pencapaian terhormat para member A4A.</p>
        </div>
        <div class="flex items-center gap-3">
            <form id="bulk-delete-form" action="{{ route('hall-of-fame.bulkDestroy') }}" method="POST">
                @csrf
                <button type="submit" id="bulk-delete-btn" class="hidden text-sm font-semibold text-rose-400 hover:text-rose-300 bg-rose-950/30 hover:bg-rose-950/50 border border-rose-900/50 px-4 py-2 rounded-xl transition-colors">
                    🗑️ Hapus Terpilih
                </button>
            </form>
            <a href="{{ route('hall-of-fame.create') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-xl transition-colors">
                ➕ Tambah Penghargaan
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4">
        <form method="GET" action="{{ route('hall-of-fame.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori atau pemenang..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
            </div>

            <!-- Filter Member -->
            <div>
                <select name="member_id" onchange="this.form.submit()" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-355 focus:outline-none focus:border-indigo-500">
                    <option value="">Pilih Member...</option>
                    @foreach($members as $m)
                        <option value="{{ $m->id }}" {{ request('member_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Year -->
            <div>
                <select name="year" onchange="this.form.submit()" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-355 focus:outline-none focus:border-indigo-500">
                    <option value="">Pilih Tahun...</option>
                    @foreach($years as $yr)
                        <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-2">
                <button type="submit" class="bg-indigo-650 hover:bg-indigo-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors flex-1">
                    Cari
                </button>
                @if(request()->anyFilled(['search', 'member_id', 'year']))
                    <a href="{{ route('hall-of-fame.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-slate-200 text-sm font-semibold px-4 py-2 rounded-xl transition-colors flex items-center justify-center">
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
                        <th class="p-4">Foto</th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'category', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Kategori Penghargaan {!! request('sort') === 'category' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'winner_name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Pemenang {!! request('sort') === 'winner_name' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'year', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Tahun {!! request('sort') === 'year' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($records as $record)
                        <tr class="hover:bg-slate-850/30 transition-colors text-sm text-slate-300">
                            <td class="p-4 text-center">
                                <input type="checkbox" value="{{ $record->id }}" class="row-checkbox rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0">
                            </td>
                            <td class="p-4">
                                <div class="w-10 h-10 rounded-full bg-slate-850 border border-slate-700 overflow-hidden flex items-center justify-center">
                                    @if($record->photo)
                                        <img src="{{ asset('storage/' . $record->photo) }}" alt="{{ $record->winner_name }}" class="w-full h-full object-cover">
                                    @elseif($record->member && $record->member->photo)
                                        <img src="{{ asset('storage/' . $record->member->photo) }}" alt="{{ $record->winner_name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-lg">🏆</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 font-semibold text-white">{{ $record->category }}</td>
                            <td class="p-4 font-medium">
                                @if($record->member)
                                    <a href="{{ route('members.show', $record->member) }}" class="hover:underline text-indigo-400">
                                        {{ $record->member->name }}
                                    </a>
                                @else
                                    <span class="text-slate-300">{{ $record->winner_name ?? '-' }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-indigo-400 font-bold">{{ $record->year }}</td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('hall-of-fame.edit', $record) }}" class="text-xs font-medium text-indigo-400 hover:text-indigo-300 bg-indigo-950/20 hover:bg-indigo-950/40 px-2.5 py-1.5 rounded-lg border border-indigo-900/50 transition-colors inline-block">
                                    Edit
                                </a>
                                <form action="{{ route('hall-of-fame.destroy', $record) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penghargaan ini?')">
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
                                Belum ada data pencapaian Hall of Fame.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                {{ $records->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
