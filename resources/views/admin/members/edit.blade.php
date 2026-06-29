@extends('layouts.admin')

@section('title', 'Edit Member')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <a href="{{ route('members.index') }}" class="hover:text-slate-200">Members</a>
    </li>
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-100 font-semibold">Edit</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-white">Edit Member Kelas: {{ $member->name }}</h1>
        <p class="text-sm text-slate-400 mt-1">Ubah informasi profil untuk member kelas ini.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <form action="{{ route('members.update', $member) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="text-sm font-semibold text-slate-200">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $member->name) }}" required class="w-full bg-slate-950 border @error('name') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors">
                    @error('name')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nickname -->
                <div class="space-y-2">
                    <label for="nickname" class="text-sm font-semibold text-slate-200">Nickname / Nama Panggilan</label>
                    <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $member->nickname) }}" class="w-full bg-slate-950 border @error('nickname') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors">
                    @error('nickname')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label for="role" class="text-sm font-semibold text-slate-200">Peran Kelas <span class="text-rose-500">*</span></label>
                    <input type="text" name="role" id="role" value="{{ old('role', $member->role) }}" required class="w-full bg-slate-950 border @error('role') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors">
                    @error('role')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <!-- Date of Birth -->
                <div class="space-y-2">
                    <label for="date_of_birth" class="text-sm font-semibold text-slate-200">Tanggal Lahir</label>
                    <div class="relative">
                        <input type="text" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $member->date_of_birth ? $member->date_of_birth->format('Y-m-d') : '') }}" 
                            class="datepicker w-full bg-slate-950 border @error('date_of_birth') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors"
                            placeholder="Pilih tanggal lahir" readonly>
                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @error('date_of_birth')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-sm font-semibold text-slate-200">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $member->email) }}" class="w-full bg-slate-950 border @error('email') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors">
                    @error('email')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-200 block">Foto Profil (Max 2MB)</label>
                    @if($member->photo)
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-12 h-12 rounded-full overflow-hidden border border-slate-700 bg-slate-800">
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="Preview" class="w-full h-full object-cover">
                            </div>
                            <span class="text-xs text-slate-400">Ganti foto dengan mengupload file baru.</span>
                        </div>
                    @endif
                    <input type="file" name="photo" id="photo" accept="image/*" class="w-full bg-slate-950 border @error('photo') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2 text-sm text-slate-300 focus:outline-none focus:border-indigo-500 transition-colors file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
                    @error('photo')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instagram -->
                <div class="space-y-2">
                    <label for="instagram" class="text-sm font-semibold text-slate-200">Username Instagram</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500">@</span>
                        <input type="text" name="instagram" id="instagram" value="{{ old('instagram', $member->instagram) }}" class="w-full bg-slate-950 border @error('instagram') border-rose-500 @else border-slate-800 @enderror rounded-xl pl-8 pr-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors">
                    </div>
                    @error('instagram')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- GitHub -->
                <div class="space-y-2">
                    <label for="github" class="text-sm font-semibold text-slate-200">Username GitHub</label>
                    <input type="text" name="github" id="github" value="{{ old('github', $member->github) }}" class="w-full bg-slate-950 border @error('github') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors">
                    @error('github')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Bio -->
            <div class="space-y-2">
                <label for="bio" class="text-sm font-semibold text-slate-200">Bio / Deskripsi Singkat</label>
                <textarea name="bio" id="bio" rows="4" class="w-full bg-slate-950 border @error('bio') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors">{{ old('bio', $member->bio) }}</textarea>
                @error('bio')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }} class="rounded bg-slate-950 border-slate-850 text-indigo-600 focus:ring-0 focus:ring-offset-0">
                <label for="is_active" class="text-sm font-semibold text-slate-200">Set sebagai Member Aktif</label>
            </div>

            <!-- Submit buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('members.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 bg-slate-800 hover:bg-slate-750 px-4 py-2 rounded-xl transition-colors border border-slate-700">
                    Batal
                </a>
                <button type="submit" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl transition-colors shadow-lg shadow-indigo-600/20">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .flatpickr-calendar {
        background: rgb(15, 23, 42) !important;
        border: 1px solid rgb(51, 65, 85) !important;
        border-radius: 1rem !important;
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.3) !important;
    }
    .flatpickr-months { background: rgb(15, 23, 42) !important; border-radius: 1rem 1rem 0 0 !important; }
    .flatpickr-month, .flatpickr-current-month { color: rgb(226, 232, 240) !important; }
    .flatpickr-weekdays, .flatpickr-days { background: rgb(15, 23, 42) !important; }
    .flatpickr-weekday { color: rgb(148, 163, 184) !important; }
    .flatpickr-day { color: rgb(226, 232, 240) !important; border-radius: 0.5rem !important; }
    .flatpickr-day:hover { background: rgb(99, 102, 241) !important; border-color: rgb(99, 102, 241) !important; color: white !important; }
    .flatpickr-day.selected, .flatpickr-day.selected:hover { background: rgb(99, 102, 241) !important; border-color: rgb(99, 102, 241) !important; color: white !important; }
    .flatpickr-day.today { border-color: rgb(99, 102, 241) !important; color: rgb(99, 102, 241) !important; }
    .flatpickr-day.disabled, .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay { color: rgb(51, 65, 85) !important; }
    .flatpickr-months .flatpickr-prev-month svg, .flatpickr-months .flatpickr-next-month svg { fill: rgb(226, 232, 240) !important; }
    .flatpickr-months .flatpickr-prev-month:hover svg, .flatpickr-months .flatpickr-next-month:hover svg { fill: rgb(99, 102, 241) !important; }
    .flatpickr-current-month input.cur-year { color: rgb(226, 232, 240) !important; }
    .flatpickr-current-month .flatpickr-monthDropdown-months { background: rgb(15, 23, 42) !important; color: rgb(226, 232, 240) !important; }
    .flatpickr-current-month .flatpickr-monthDropdown-months option { background: rgb(15, 23, 42) !important; }
    input.flatpickr-input[readonly] { display: none; }
</style>

@endsection

@push('scripts')
@vite('resources/js/datepicker.js')
@endpush
