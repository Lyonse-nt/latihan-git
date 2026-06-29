@extends('layouts.admin')

@section('title', 'Tambah Penghargaan')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <a href="{{ route('hall-of-fame.index') }}" class="hover:text-slate-200">Hall of Fame</a>
    </li>
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-100 font-semibold">Tambah</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-white">Tambah Penghargaan Baru</h1>
        <p class="text-sm text-slate-400 mt-1">Masukkan rincian pencapaian Hall of Fame baru.</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <form action="{{ route('hall-of-fame.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div class="space-y-2">
                    <label for="category" class="text-sm font-semibold text-slate-200">Kategori Penghargaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="category" id="category" value="{{ old('category') }}" required placeholder="Contoh: Ter-rajin, Programmer Handal, Pemalas Kelas..." class="w-full bg-slate-950 border @error('category') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('category')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Member (Pemenang) -->
                <div class="space-y-2">
                    <label for="member_id" class="text-sm font-semibold text-slate-200">Pilih Member Pemenang</label>
                    <select name="member_id" id="member_id" class="w-full bg-slate-950 border @error('member_id') border-rose-500 @else border-slate-800 @enderror rounded-xl px-3 py-2.5 text-sm text-slate-350 focus:outline-none focus:border-indigo-500">
                        <option value="">-- Hubungkan dengan Member --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fallback Winner Name (if not in member database) -->
                <div class="space-y-2">
                    <label for="winner_name" class="text-sm font-semibold text-slate-200">Atau Tulis Nama Manual (Jika Member tidak ada di list)</label>
                    <input type="text" name="winner_name" id="winner_name" value="{{ old('winner_name') }}" placeholder="Tulis nama pemenang..." class="w-full bg-slate-950 border @error('winner_name') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('winner_name')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Year -->
                <div class="space-y-2">
                    <label for="year" class="text-sm font-semibold text-slate-200">Tahun Penghargaan <span class="text-rose-500">*</span></label>
                    <input type="number" name="year" id="year" value="{{ old('year', date('Y')) }}" required placeholder="Contoh: 2025" class="w-full bg-slate-950 border @error('year') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('year')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo (Poster/Reward Photo) -->
                <div class="space-y-2 md:col-span-2">
                    <label for="photo" class="text-sm font-semibold text-slate-200 block">Upload Foto Penyerahan / Trophy (Max 2MB)</label>
                    <input type="file" name="photo" id="photo" accept="image/*" class="w-full bg-slate-950 border @error('photo') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2 text-sm text-slate-300 focus:outline-none focus:border-indigo-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
                    @error('photo')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('hall-of-fame.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 bg-slate-800 hover:bg-slate-750 px-4 py-2 rounded-xl transition-colors border border-slate-700">
                    Batal
                </a>
                <button type="submit" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl transition-colors">
                    Simpan Penghargaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
