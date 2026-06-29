@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <a href="{{ route('announcements.index') }}" class="hover:text-slate-200">Announcements</a>
    </li>
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-100 font-semibold">Tambah</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-white">Buat Pengumuman Baru</h1>
        <p class="text-sm text-slate-400 mt-1">Buat info rilis penting atau agenda kelas A4A.</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <form action="{{ route('announcements.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Title -->
            <div class="space-y-2">
                <label for="title" class="text-sm font-semibold text-slate-200">Judul Pengumuman <span class="text-rose-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Contoh: Perubahan Jadwal Iuran Kas..." class="w-full bg-slate-950 border @error('title') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                @error('title')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Published At -->
            <div class="space-y-2">
                <label for="published_at" class="text-sm font-semibold text-slate-200">Tanggal & Jam Rilis (Kosongkan jika ingin langsung publish)</label>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}" class="w-full bg-slate-950 border @error('published_at') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                @error('published_at')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="space-y-2">
                <label for="content" class="text-sm font-semibold text-slate-200">Isi Pengumuman <span class="text-rose-500">*</span></label>
                <textarea name="content" id="content" rows="6" required placeholder="Tuliskan detail pengumuman kelas di sini..." class="w-full bg-slate-950 border @error('content') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pinned Status -->
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_pinned" id="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }} class="rounded bg-slate-950 border-slate-850 text-indigo-600 focus:ring-0">
                <label for="is_pinned" class="text-sm font-semibold text-slate-200">Pin pengumuman ini (Ditampilkan sebagai pengumuman prioritas)</label>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('announcements.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 bg-slate-800 hover:bg-slate-750 px-4 py-2 rounded-xl transition-colors border border-slate-700">
                    Batal
                </a>
                <button type="submit" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl transition-colors">
                    Simpan Pengumuman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
