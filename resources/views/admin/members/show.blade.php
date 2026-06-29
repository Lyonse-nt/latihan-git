@extends('layouts.admin')

@section('title', 'Detail Member')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <a href="{{ route('members.index') }}" class="hover:text-slate-200">Members</a>
    </li>
    <li class="inline-flex items-center">
        <span class="mx-2 text-slate-600">/</span>
        <span class="text-slate-100 font-semibold">Detail</span>
    </li>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Back to List -->
    <div>
        <a href="{{ route('members.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 inline-flex items-center gap-2">
            ⬅️ Kembali ke Daftar Member
        </a>
    </div>

    <!-- Profile Header Card -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center md:items-start gap-8 shadow-xl">
        <!-- Photo -->
        <div class="w-32 h-32 rounded-full overflow-hidden border border-slate-700 bg-slate-850 flex-shrink-0 flex items-center justify-center shadow-lg">
            @if($member->photo)
                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
            @else
                <span class="text-6xl">👤</span>
            @endif
        </div>

        <!-- Info -->
        <div class="flex-1 text-center md:text-left space-y-4">
            <div>
                <div class="flex flex-col md:flex-row md:items-center gap-3 justify-center md:justify-start">
                    <h1 class="text-3xl font-bold text-white tracking-tight">{{ $member->name }}</h1>
                    @if($member->is_active)
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 max-w-max self-center">
                            Aktif
                        </span>
                    @else
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700 max-w-max self-center">
                            Nonaktif
                        </span>
                    @endif
                </div>
                <p class="text-slate-400 font-medium text-lg mt-1">{{ $member->nickname ? '"' . $member->nickname . '"' : '' }} — <span class="text-indigo-400 font-semibold">{{ $member->role }}</span></p>
            </div>

            <!-- Social Links & Metadata -->
            <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm text-slate-300">
                @if($member->email)
                    <span class="flex items-center gap-1.5 bg-slate-950 border border-slate-800 px-3 py-1.5 rounded-xl">
                        📧 {{ $member->email }}
                    </span>
                @endif
                @if($member->date_of_birth)
                    <span class="flex items-center gap-1.5 bg-slate-950 border border-slate-800 px-3 py-1.5 rounded-xl">
                        🎂 {{ $member->date_of_birth->format('d M Y') }}
                    </span>
                @endif
                @if($member->instagram)
                    <a href="https://instagram.com/{{ $member->instagram }}" target="_blank" class="flex items-center gap-1.5 bg-slate-950 border border-slate-800 hover:border-slate-750 hover:text-white px-3 py-1.5 rounded-xl transition-colors">
                        📸 @{{ $member->instagram }}
                    </a>
                @endif
                @if($member->github)
                    <a href="https://github.com/{{ $member->github }}" target="_blank" class="flex items-center gap-1.5 bg-slate-950 border border-slate-800 hover:border-slate-750 hover:text-white px-3 py-1.5 rounded-xl transition-colors">
                        🐙 {{ $member->github }}
                    </a>
                @endif
            </div>

            <!-- Bio -->
            @if($member->bio)
                <div class="bg-slate-950 border border-slate-800/80 rounded-xl p-4 text-slate-300 text-sm italic leading-relaxed">
                    " {{ $member->bio }} "
                </div>
            @endif
        </div>

        <!-- Edit/Actions -->
        <div class="flex-shrink-0 flex gap-2">
            <a href="{{ route('members.edit', $member) }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-xl transition-colors">
                ✏️ Edit Profil
            </a>
        </div>
    </div>

    <!-- Related Modules Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Projects Section -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <h2 class="text-xl font-bold text-white border-b border-slate-850 pb-3">💻 Project Karya ({{ $member->projects->count() }})</h2>
            
            <div class="space-y-4">
                @forelse($member->projects as $project)
                    <div class="bg-slate-950 border border-slate-850 rounded-xl p-4 flex gap-4 items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-white text-sm">{{ $project->name }}</h4>
                            <p class="text-xs text-slate-400 mt-1 truncate max-w-xs">{{ $project->description }}</p>
                        </div>
                        <a href="{{ route('projects.edit', $project) }}" class="text-xs font-semibold text-indigo-400 hover:underline">
                            Edit ➔
                        </a>
                    </div>
                @empty
                    <p class="text-slate-500 text-sm">Belum membuat project apapun.</p>
                @forelseend
            </div>
        </div>

        <!-- Gallery Memories Section -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <h2 class="text-xl font-bold text-white border-b border-slate-850 pb-3">🖼️ Foto Gallery ({{ $member->galleries->count() }})</h2>
            
            <div class="grid grid-cols-3 gap-3">
                @php $photoCount = 0; @endphp
                @forelse($member->galleries as $gallery)
                    @if(is_array($gallery->photos))
                        @foreach($gallery->photos as $photo)
                            @php $photoCount++; @endphp
                            <div class="aspect-square rounded-xl bg-slate-950 border border-slate-850 overflow-hidden">
                                <img src="{{ asset('storage/' . $photo) }}" alt="Gallery" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    @endif
                @empty
                    <p class="text-slate-500 text-sm col-span-3">Belum mengupload foto gallery apapun.</p>
                @endforelse
                
                @if($photoCount === 0 && $member->galleries->count() > 0)
                    <p class="text-slate-500 text-sm col-span-3">Foto gallery kosong.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
