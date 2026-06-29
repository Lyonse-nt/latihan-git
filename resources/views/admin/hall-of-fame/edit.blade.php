@extends('layouts.admin')

@section('title', 'Edit Penghargaan')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <a href="{{ route('hall-of-fame.index') }}" class="hover:text-slate-200">Hall of Fame</a>
    </li>
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-100 font-semibold">Edit</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-white">Edit Penghargaan: {{ $hallOfFame->category }}</h1>
        <p class="text-sm text-slate-400 mt-1">Ubah rincian pencapaian Hall of Fame ini.</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <form action="{{ route('hall-of-fame.update', $hallOfFame) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div class="space-y-2">
                    <label for="category" class="text-sm font-semibold text-slate-200">Kategori Penghargaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="category" id="category" value="{{ old('category', $hallOfFame->category) }}" required class="w-full bg-slate-950 border @error('category') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
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
                            <option value="{{ $member->id }}" {{ old('member_id', $hallOfFame->member_id) == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fallback Winner Name (if not in member database) -->
                <div class="space-y-2">
                    <label for="winner_name" class="text-sm font-semibold text-slate-200">Atau Tulis Nama Manual (Jika Member tidak ada di list)</label>
                    <input type="text" name="winner_name" id="winner_name" value="{{ old('winner_name', $hallOfFame->winner_name) }}" class="w-full bg-slate-950 border @error('winner_name') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('winner_name')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Year -->
                <div class="space-y-2">
                    <label for="year" class="text-sm font-semibold text-slate-200">Tahun Penghargaan <span class="text-rose-500">*</span></label>
                    <input type="number" name="year" id="year" value="{{ old('year', $hallOfFame->year) }}" required class="w-full bg-slate-950 border @error('year') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('year')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo (Poster/Reward Photo) -->
                <div class="md:col-span-2">
                    <x-photo-upload name="photo" label="Foto Penghargaan" :currentPhoto="$hallOfFame->photo" hint="JPG, PNG, WEBP. Max 2MB." />
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('hall-of-fame.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 bg-slate-800 hover:bg-slate-750 px-4 py-2 rounded-xl transition-colors border border-slate-700">
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
