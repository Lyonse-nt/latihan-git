<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimelineRequest;
use App\Models\Timeline;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Timeline::class);

        $query = Timeline::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortField = $request->input('sort', 'sort_order');
        $sortOrder = $request->input('direction', 'asc');
        $allowedSorts = ['title', 'date', 'sort_order', 'created_at'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder);
        }

        $timelines = $query->paginate(10)->withQueryString();

        return view('admin.timeline.index', compact('timelines'));
    }

    public function create()
    {
        $this->authorize('create', Timeline::class);

        return view('admin.timeline.create');
    }

    public function store(TimelineRequest $request)
    {
        $this->authorize('create', Timeline::class);
        $data = $request->validated();

        Timeline::create($data);

        return redirect()->route('timeline.index')->with('success', 'Timeline berhasil ditambahkan.');
    }

    public function edit(Timeline $timeline)
    {
        $this->authorize('update', $timeline);

        return view('admin.timeline.edit', compact('timeline'));
    }

    public function update(TimelineRequest $request, Timeline $timeline)
    {
        $this->authorize('update', $timeline);
        $data = $request->validated();

        $timeline->update($data);

        return redirect()->route('timeline.index')->with('success', 'Timeline berhasil diubah.');
    }

    public function destroy(Timeline $timeline)
    {
        $this->authorize('delete', $timeline);
        $timeline->delete();

        return redirect()->route('timeline.index')->with('success', 'Timeline berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', Timeline::class);

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('timeline.index')->with('error', 'Pilih data yang ingin dihapus.');
        }

        Timeline::whereIn('id', $ids)->delete();

        return redirect()->route('timeline.index')->with('success', 'Data terpilih berhasil dihapus.');
    }
}
