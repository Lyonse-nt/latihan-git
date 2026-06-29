@extends('layouts.admin')

@section('title', 'Edit Staff')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <a href="{{ route('users.index') }}" class="hover:text-slate-200">Users</a>
    </li>
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-100 font-semibold">Edit</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-white">Edit Akun Staff: {{ $user->name }}</h1>
        <p class="text-sm text-slate-400 mt-1">Ubah peran, status, atau reset password akun staff ini.</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="text-sm font-semibold text-slate-200">Nama Staff <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-950 border @error('name') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('name')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-sm font-semibold text-slate-200">Alamat Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-950 border @error('email') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('email')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label for="role" class="text-sm font-semibold text-slate-200">Hak Akses / Role <span class="text-rose-500">*</span></label>
                    <select name="role" id="role" required class="w-full bg-slate-950 border @error('role') border-rose-500 @else border-slate-800 @enderror rounded-xl px-3 py-2.5 text-sm text-slate-350 focus:outline-none focus:border-indigo-500">
                        <option value="moderator" {{ old('role', $user->role) == 'moderator' ? 'selected' : '' }}>Moderator (Bisa kelola data, dilarang hapus)</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Akses penuh, dilarang kelola user)</option>
                        <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin (Akses penuh penuh)</option>
                    </select>
                    @error('role')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label for="status" class="text-sm font-semibold text-slate-200">Status Akun <span class="text-rose-500">*</span></label>
                    <select name="status" id="status" required class="w-full bg-slate-950 border @error('status') border-rose-500 @else border-slate-800 @enderror rounded-xl px-3 py-2.5 text-sm text-slate-350 focus:outline-none focus:border-indigo-500" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Nonaktif / Ditangguhkan</option>
                    </select>
                    @if(auth()->id() === $user->id)
                        <input type="hidden" name="status" value="active">
                        <p class="text-xs text-slate-500 mt-1">Anda tidak bisa menonaktifkan akun Anda sendiri.</p>
                    @endif
                    @error('status')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="text-sm font-semibold text-slate-200">Password Baru (Kosongkan jika tidak ingin merubah)</label>
                    <input type="password" name="password" id="password" class="w-full bg-slate-950 border @error('password') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('password')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-semibold text-slate-200">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('users.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 bg-slate-800 hover:bg-slate-750 px-4 py-2 rounded-xl transition-colors border border-slate-700">
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
