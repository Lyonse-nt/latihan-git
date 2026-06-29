@extends('layouts.admin')

@section('title', 'Upload Gallery')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <a href="{{ route('gallery.index') }}" class="hover:text-slate-200">Gallery</a>
    </li>
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-100 font-semibold">Upload</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-white">Upload Gallery Foto Baru</h1>
        <p class="text-sm text-slate-400 mt-1">Unggah dokumentasi foto kegiatan kelas atau memori A4A.</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Uploader Member -->
                <div class="space-y-2">
                    <label for="member_id" class="text-sm font-semibold text-slate-200">Uploader (Member) <span class="text-rose-500">*</span></label>
                    <select name="member_id" id="member_id" required class="w-full bg-slate-950 border @error('member_id') border-rose-500 @else border-slate-800 @enderror rounded-xl px-3 py-2.5 text-sm text-slate-350 focus:outline-none focus:border-indigo-500">
                        <option value="">Pilih Member...</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="space-y-2">
                    <label for="category" class="text-sm font-semibold text-slate-200">Kategori Album <span class="text-rose-500">*</span></label>
                    <input type="text" name="category" id="category" value="{{ old('category', 'Umum') }}" required placeholder="Contoh: Kegiatan Kelas, Refreshing, Makrab..." class="w-full bg-slate-950 border @error('category') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('category')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div class="space-y-2">
                    <label for="date" class="text-sm font-semibold text-slate-200">Tanggal Foto</label>
                    <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full bg-slate-950 border @error('date') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('date')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Visibility -->
                <div class="space-y-2">
                    <label for="visibility" class="text-sm font-semibold text-slate-200">Visibilitas <span class="text-rose-500">*</span></label>
                    <select name="visibility" id="visibility" required class="w-full bg-slate-950 border @error('visibility') border-rose-500 @else border-slate-800 @enderror rounded-xl px-3 py-2.5 text-sm text-slate-350 focus:outline-none focus:border-indigo-500">
                        <option value="public" {{ old('visibility', 'public') == 'public' ? 'selected' : '' }}>Public (Terlihat di Landing)</option>
                        <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Private (Hanya Admin Panel)</option>
                    </select>
                    @error('visibility')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Photos multiple -->
            <div class="space-y-2">
                <label for="photos" class="text-sm font-semibold text-slate-200 block">Pilih File Foto (Bisa pilih banyak sekaligus, Max 5MB per file) <span class="text-rose-500">*</span></label>
                <input type="file" name="photos[]" id="photos" multiple required accept="image/*" class="w-full bg-slate-950 border @error('photos') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2 text-sm text-slate-300 focus:outline-none focus:border-indigo-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
                @error('photos')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
                @error('photos.*')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Caption -->
            <div class="space-y-2">
                <label for="caption" class="text-sm font-semibold text-slate-200">Caption / Keterangan Foto</label>
                <textarea name="caption" id="caption" rows="4" placeholder="Tuliskan keterangan mengenai foto-foto ini..." class="w-full bg-slate-950 border @error('caption') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">{{ old('caption') }}</textarea>
                @error('caption')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('gallery.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 bg-slate-800 hover:bg-slate-750 px-4 py-2 rounded-xl transition-colors border border-slate-700">
                    Batal
                </a>
                <button type="submit" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl transition-colors">
                    Upload Album
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
