@extends('layouts.admin')

@section('title', 'Manage Guestbook')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-400">Guestbook</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Review Guestbook Kelas</h1>
            <p class="text-sm text-slate-400 mt-1">Daftar ucapan, kritik, dan saran dari pengunjung luar.</p>
        </div>
        <div class="flex items-center gap-3">
            <form id="bulk-delete-form" action="{{ route('guestbook.bulkDestroy') }}" method="POST">
                @csrf
                <button type="submit" id="bulk-delete-btn" class="hidden text-sm font-semibold text-rose-400 hover:text-rose-300 bg-rose-950/30 hover:bg-rose-950/50 border border-rose-900/50 px-4 py-2 rounded-xl transition-colors">
                    🗑️ Hapus Terpilih
                </button>
            </form>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row gap-4 items-center justify-between">
        <form method="GET" action="{{ route('guestbook.index') }}" class="w-full flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau isi pesan..." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
            </div>

            <!-- Filter Status -->
            <div class="w-full md:w-48">
                <select name="status" onchange="this.form.submit()" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-355 focus:outline-none focus:border-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-2">
                <button type="submit" class="bg-slate-850 hover:bg-slate-800 border border-slate-700 text-slate-300 text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('guestbook.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-slate-200 text-sm font-semibold px-4 py-2 rounded-xl transition-colors flex items-center justify-center">
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
                        <th class="p-4 w-48">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center gap-1">
                                Pengirim {!! request('sort') === 'name' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4">Pesan</th>
                        <th class="p-4 w-32 text-center">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-white flex items-center justify-center gap-1">
                                Status {!! request('sort') === 'status' ? (request('direction') === 'asc' ? '▲' : '▼') : '↕' !!}
                            </a>
                        </th>
                        <th class="p-4 w-48 text-right">Moderasi / Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-850/30 transition-colors text-sm text-slate-300">
                            <td class="p-4 text-center">
                                <input type="checkbox" value="{{ $msg->id }}" class="row-checkbox rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0">
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-white">{{ $msg->name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $msg->email ?? '-' }}</div>
                            </td>
                            <td class="p-4 leading-relaxed text-slate-300">
                                {{ $msg->message }}
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                                    @if($msg->status === 'approved') bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                                    @elseif($msg->status === 'rejected') bg-rose-500/10 text-rose-400 border border-rose-500/20
                                    @else bg-amber-500/10 text-amber-400 border border-amber-500/20 @endif">
                                    {{ ucfirst($msg->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                                @if($msg->status !== 'approved')
                                    <form action="{{ route('guestbook.approve', $msg) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 bg-emerald-950/20 hover:bg-emerald-950/40 px-2.5 py-1.5 rounded-lg border border-emerald-900/50 transition-colors">
                                            Approve
                                        </button>
                                    </form>
                                @endif
                                @if($msg->status !== 'rejected')
                                    <form action="{{ route('guestbook.reject', $msg) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-xs font-semibold text-amber-400 hover:text-amber-300 bg-amber-950/20 hover:bg-amber-950/40 px-2.5 py-1.5 rounded-lg border border-amber-900/50 transition-colors">
                                            Reject
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('guestbook.destroy', $msg) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-rose-400 hover:text-rose-300 bg-rose-950/20 hover:bg-rose-950/40 px-2.5 py-1.5 rounded-lg border border-rose-900/50 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                Belum ada pesan guestbook.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
