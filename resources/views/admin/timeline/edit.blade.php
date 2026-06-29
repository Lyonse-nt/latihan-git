@extends('layouts.admin')

@section('title', 'Edit Milestone')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <a href="{{ route('timeline.index') }}" class="hover:text-slate-200">Timeline</a>
    </li>
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-100 font-semibold">Edit</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-white">Edit Milestone: {{ $timeline->title }}</h1>
        <p class="text-sm text-slate-400 mt-1">Ubah informasi peristiwa bersejarah kelas.</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <form action="{{ route('timeline.update', $timeline) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="space-y-2">
                    <label for="title" class="text-sm font-semibold text-slate-200">Judul Milestone <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $timeline->title) }}" required class="w-full bg-slate-950 border @error('title') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('title')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div class="space-y-2">
                    <label for="date" class="text-sm font-semibold text-slate-200">Tanggal Peristiwa</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $timeline->date ? $timeline->date->format('Y-m-d') : '') }}" class="w-full bg-slate-950 border @error('date') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('date')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div class="space-y-2">
                    <label for="icon" class="text-sm font-semibold text-slate-200">Pilih Icon Penanda <span class="text-rose-500">*</span></label>
                    <select name="icon" id="icon" required class="w-full bg-slate-950 border @error('icon') border-rose-500 @else border-slate-800 @enderror rounded-xl px-3 py-2.5 text-sm text-slate-350 focus:outline-none focus:border-indigo-500">
                        <option value="calendar" {{ old('icon', $timeline->icon) == 'calendar' ? 'selected' : '' }}>📅 Kalender / Umum</option>
                        <option value="trophy" {{ old('icon', $timeline->icon) == 'trophy' ? 'selected' : '' }}>🏆 Trophy / Prestasi</option>
                        <option value="flag" {{ old('icon', $timeline->icon) == 'flag' ? 'selected' : '' }}>🚩 Bendera / Deklarasi</option>
                        <option value="star" {{ old('icon', $timeline->icon) == 'star' ? 'selected' : '' }}>⭐ Bintang / Spesial</option>
                        <option value="heart" {{ old('icon', $timeline->icon) == 'heart' ? 'selected' : '' }}>❤️ Hati / Solidaritas</option>
                        <option value="fire" {{ old('icon', $timeline->icon) == 'fire' ? 'selected' : '' }}>🔥 Api / Semangat</option>
                    </select>
                    @error('icon')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div class="space-y-2">
                    <label for="sort_order" class="text-sm font-semibold text-slate-200">Urutan Tampil <span class="text-rose-500">*</span></label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $timeline->sort_order) }}" required min="0" class="w-full bg-slate-950 border @error('sort_order') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('sort_order')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="text-sm font-semibold text-slate-200">Keterangan / Rincian Momen</label>
                <textarea name="description" id="description" rows="4" class="w-full bg-slate-950 border @error('description') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">{{ old('description', $timeline->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('timeline.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 bg-slate-800 hover:bg-slate-750 px-4 py-2 rounded-xl transition-colors border border-slate-700">
                    Batal
                </a>
                <button type="submit" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
