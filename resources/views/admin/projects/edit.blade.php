@extends('layouts.admin')

@section('title', 'Edit Project')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <a href="{{ route('projects.index') }}" class="hover:text-slate-200">Projects</a>
    </li>
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-100 font-semibold">Edit</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-white">Edit Project: {{ $project->name }}</h1>
        <p class="text-sm text-slate-400 mt-1">Ubah rincian karya atau aplikasi buatan member kelas.</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="text-sm font-semibold text-slate-200">Nama Project <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" required class="w-full bg-slate-950 border @error('name') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('name')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Developer/Member -->
                <div class="space-y-2">
                    <label for="member_id" class="text-sm font-semibold text-slate-200">Developer (Member) <span class="text-rose-500">*</span></label>
                    <select name="member_id" id="member_id" required class="w-full bg-slate-950 border @error('member_id') border-rose-500 @else border-slate-800 @enderror rounded-xl px-3 py-2.5 text-sm text-slate-350 focus:outline-none focus:border-indigo-500">
                        <option value="">Pilih Member...</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id', $project->member_id) == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label for="status" class="text-sm font-semibold text-slate-200">Status Project <span class="text-rose-500">*</span></label>
                    <select name="status" id="status" required class="w-full bg-slate-950 border @error('status') border-rose-500 @else border-slate-800 @enderror rounded-xl px-3 py-2.5 text-sm text-slate-350 focus:outline-none focus:border-indigo-500">
                        <option value="draft" {{ old('status', $project->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="ongoing" {{ old('status', $project->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="archived" {{ old('status', $project->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Thumbnail -->
                <x-photo-upload name="thumbnail" label="Thumbnail Image" :currentPhoto="$project->thumbnail" hint="JPG, PNG, WEBP. Max 2MB." />

                <!-- Repository URL -->
                <div class="space-y-2">
                    <label for="repository_url" class="text-sm font-semibold text-slate-200">Repository URL</label>
                    <input type="url" name="repository_url" id="repository_url" value="{{ old('repository_url', $project->repository_url) }}" class="w-full bg-slate-950 border @error('repository_url') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('repository_url')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Demo URL -->
                <div class="space-y-2">
                    <label for="demo_url" class="text-sm font-semibold text-slate-200">Demo Link / Live URL</label>
                    <input type="url" name="demo_url" id="demo_url" value="{{ old('demo_url', $project->demo_url) }}" class="w-full bg-slate-950 border @error('demo_url') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">
                    @error('demo_url')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="text-sm font-semibold text-slate-200">Deskripsi Project</label>
                <textarea name="description" id="description" rows="4" class="w-full bg-slate-950 border @error('description') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 bg-slate-800 hover:bg-slate-750 px-4 py-2 rounded-xl transition-colors border border-slate-700">
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
