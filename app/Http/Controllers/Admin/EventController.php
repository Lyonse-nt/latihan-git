<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Event::class);

        $query = Event::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortField = $request->input('sort', 'date');
        $sortOrder = $request->input('direction', 'asc');
        $allowedSorts = ['name', 'date', 'time', 'created_at'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder);
        }

        $events = $query->paginate(10)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $this->authorize('create', Event::class);

        return view('admin.events.create');
    }

    public function store(EventRequest $request)
    {
        $this->authorize('create', Event::class);
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('events', 'public');
        }

        Event::create($data);

        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return view('admin.events.edit', compact('event'));
    }

    public function update(EventRequest $request, Event $event)
    {
        $this->authorize('update', $event);
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $data['poster'] = $request->file('poster')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Event berhasil diubah.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', Event::class);

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('events.index')->with('error', 'Pilih data yang ingin dihapus.');
        }

        $events = Event::whereIn('id', $ids)->get();
        foreach ($events as $event) {
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $event->delete();
        }

        return redirect()->route('events.index')->with('success', 'Data terpilih berhasil dihapus.');
    }
}
