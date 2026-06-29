<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Announcement::class);

        $query = Announcement::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter
        if ($request->has('is_pinned') && $request->input('is_pinned') !== '') {
            $query->where('is_pinned', $request->boolean('is_pinned'));
        }

        // Sort
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('direction', 'desc');
        $allowedSorts = ['title', 'published_at', 'created_at'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder);
        }

        $announcements = $query->paginate(10)->withQueryString();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $this->authorize('create', Announcement::class);

        return view('admin.announcements.create');
    }

    public function store(AnnouncementRequest $request)
    {
        $this->authorize('create', Announcement::class);
        $data = $request->validated();

        $data['is_pinned'] = $request->has('is_pinned');
        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Announcement::create($data);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement);

        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        $data = $request->validated();

        $data['is_pinned'] = $request->has('is_pinned');
        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $announcement->update($data);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diubah.');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorize('delete', $announcement);
        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', Announcement::class);

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('announcements.index')->with('error', 'Pilih data yang ingin dihapus.');
        }

        Announcement::whereIn('id', $ids)->delete();

        return redirect()->route('announcements.index')->with('success', 'Data terpilih berhasil dihapus.');
    }
}
