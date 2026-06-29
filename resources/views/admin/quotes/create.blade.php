@extends('layouts.admin')

@section('title', 'Tambah Quote')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <a href="{{ route('quotes.index') }}" class="hover:text-slate-200">Quotes</a>
    </li>
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-100 font-semibold">Tambah</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-white">Tambah Quote Baru</h1>
        <p class="text-sm text-slate-400 mt-1">Masukkan kutipan candaan, quotes bijak, atau motivasi kelas A4A.</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <form action="{{ route('quotes.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Quote Text -->
            <div class="space-y-2">
                <label for="quote" class="text-sm font-semibold text-slate-200">Kutipan / Quote <span class="text-rose-500">*</span></label>
                <textarea name="quote" id="quote" rows="4" required placeholder="Tulis kutipan kata-kata di sini..." class="w-full bg-slate-950 border @error('quote') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">{{ old('quote') }}</textarea>
                @error('quote')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Author -->
            <div class="space-y-2">
                <label for="author" class="text-sm font-semibold text-slate-200">Penulis <span class="text-rose-500">*</span></label>
                <input type="text" name="author" id="author" value="{{ old('author', 'Anonim') }}" required placeholder="Contoh: Akey Maulana, Pak Budi, Anonim..." class="w-full bg-slate-950 border @error('author') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                @error('author')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Publish Status -->
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="rounded bg-slate-950 border-slate-850 text-indigo-600 focus:ring-0">
                <label for="is_published" class="text-sm font-semibold text-slate-200">Tampilkan langsung di halaman utama (Publish)</label>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('quotes.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 bg-slate-800 hover:bg-slate-750 px-4 py-2 rounded-xl transition-colors border border-slate-700">
                    Batal
                </a>
                <button type="submit" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl transition-colors">
                    Simpan Quote
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
