@props([
    'name'        => 'photo',
    'label'       => 'Foto',
    'currentPhoto' => null,
    'hint'        => 'JPG, PNG, WEBP. Max 5MB.',
    'required'    => false,
])

@php $inputId = $name . '_file_' . uniqid(); @endphp

<div class="space-y-3">
    <label class="text-sm font-semibold text-slate-200">
        {{ $label }} @if($required)<span class="text-rose-500">*</span>@endif
    </label>

    {{-- Current photo preview --}}
    @if($currentPhoto)
    <div class="relative inline-block">
        <img id="{{ $name }}_preview"
             src="{{ asset('storage/' . $currentPhoto) }}"
             alt="Current"
             class="w-24 h-24 object-cover rounded-xl border border-slate-700">
        <span class="absolute -top-1 -right-1 text-xs bg-indigo-600 text-white px-1.5 py-0.5 rounded-full">Saat ini</span>
    </div>
    @else
    <img id="{{ $name }}_preview"
         src=""
         alt="Preview"
         class="hidden w-24 h-24 object-cover rounded-xl border border-indigo-500">
    @endif

    {{-- File picker button --}}
    <div class="flex items-center gap-3">
        <label for="{{ $inputId }}"
               class="cursor-pointer flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all hover:opacity-90 select-none"
               style="background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.4); color: rgb(165,180,252);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="file-chosen-label">Pilih &amp; Crop Foto</span>
        </label>
        <span class="text-xs text-slate-500">{{ $hint }}</span>
    </div>

    <input type="file"
           id="{{ $inputId }}"
           accept="image/*"
           data-cropper="true"
           data-preview="{{ $name }}_preview"
           class="hidden">

    @error($name)
        <p class="text-xs text-rose-400">{{ $message }}</p>
    @enderror
</div>
