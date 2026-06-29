@extends('layouts.admin')

@section('title', 'Edit Event')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <a href="{{ route('events.index') }}" class="hover:text-slate-200">Events</a>
    </li>
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-100 font-semibold">Edit</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-white">Edit Event: {{ $event->name }}</h1>
        <p class="text-sm text-slate-400 mt-1">Ubah rincian kegiatan untuk agenda kelas A4A.</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="text-sm font-semibold text-slate-200">Nama Event <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}" required class="w-full bg-slate-950 border @error('name') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('name')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="space-y-2">
                    <label for="location" class="text-sm font-semibold text-slate-200">Lokasi / Tempat</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" class="w-full bg-slate-950 border @error('location') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('location')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div class="space-y-2">
                    <label for="date" class="text-sm font-semibold text-slate-200">Tanggal Kegiatan</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $event->date ? $event->date->format('Y-m-d') : '') }}" class="w-full bg-slate-950 border @error('date') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('date')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time -->
                <div class="space-y-2">
                    <label for="time" class="text-sm font-semibold text-slate-200">Jam Mulai</label>
                    <input type="time" name="time" id="time" value="{{ old('time', $event->time ? date('H:i', strtotime($event->time)) : '') }}" class="w-full bg-slate-950 border @error('time') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('time')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Poster -->
                <div class="md:col-span-2">
                    <x-photo-upload name="poster" label="Poster Event" :currentPhoto="$event->poster" hint="JPG, PNG, WEBP. Max 2MB." />
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="text-sm font-semibold text-slate-200">Deskripsi / Detail Acara</label>
                <textarea name="description" id="description" rows="4" class="w-full bg-slate-950 border @error('description') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('events.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 bg-slate-800 hover:bg-slate-750 px-4 py-2 rounded-xl transition-colors border border-slate-700">
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

@push('scripts')
@vite('resources/js/cropper.js')
@endpush
