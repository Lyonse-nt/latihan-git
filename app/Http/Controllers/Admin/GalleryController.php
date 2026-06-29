<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use App\Models\Member;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Gallery::class);

        $query = Gallery::with('member');

        // Search
        if ($search = $request->input('search')) {
            $query->where('caption', 'like', "%{$search}%");
        }

        // Filters
        if ($request->has('member_id') && $request->input('member_id') !== '') {
            $query->where('member_id', $request->input('member_id'));
        }

        if ($request->has('category') && $request->input('category') !== '') {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('visibility') && $request->input('visibility') !== '') {
            $query->where('visibility', $request->input('visibility'));
        }

        // Sort
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('direction', 'desc');
        $allowedSorts = ['date', 'created_at'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder);
        }

        $galleries = $query->paginate(10)->withQueryString();
        $members = Member::orderBy('name')->get();

        // Fetch unique categories for filters
        $categories = Gallery::distinct()->pluck('category')->filter()->toArray();

        return view('admin.gallery.index', compact('galleries', 'members', 'categories'));
    }

    public function create()
    {
        $this->authorize('create', Gallery::class);
        $members = Member::orderBy('name')->get();

        return view('admin.gallery.create', compact('members'));
    }

    public function store(GalleryRequest $request)
    {
        $this->authorize('create', Gallery::class);
        $data = $request->validated();

        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoPaths[] = $photo->store('galleries', 'public');
            }
        }
        $data['photos'] = $photoPaths;

        Gallery::create($data);

        return redirect()->route('gallery.index')->with('success', 'Gallery berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        $this->authorize('update', $gallery);
        $members = Member::orderBy('name')->get();

        return view('admin.gallery.edit', compact('gallery', 'members'));
    }

    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $this->authorize('update', $gallery);
        $data = $request->validated();

        if ($request->hasFile('photos')) {
            // Delete old photos
            if (is_array($gallery->photos)) {
                foreach ($gallery->photos as $oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }

            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $photoPaths[] = $photo->store('galleries', 'public');
            }
            $data['photos'] = $photoPaths;
        } else {
            // Keep old photos
            unset($data['photos']);
        }

        $gallery->update($data);

        return redirect()->route('gallery.index')->with('success', 'Gallery berhasil diubah.');
    }

    public function destroy(Gallery $gallery)
    {
        $this->authorize('delete', $gallery);

        if (is_array($gallery->photos)) {
            foreach ($gallery->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gallery berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', Gallery::class);

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('gallery.index')->with('error', 'Pilih data yang ingin dihapus.');
        }

        $galleries = Gallery::whereIn('id', $ids)->get();
        foreach ($galleries as $gallery) {
            if (is_array($gallery->photos)) {
                foreach ($gallery->photos as $photo) {
                    Storage::disk('public')->delete($photo);
                }
            }
            $gallery->delete();
        }

        return redirect()->route('gallery.index')->with('success', 'Data terpilih berhasil dihapus.');
    }
}
