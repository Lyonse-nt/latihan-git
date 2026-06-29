<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HallOfFameRequest;
use App\Models\HallOfFame;
use App\Models\Member;
use App\Traits\HandlesBase64Image;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HallOfFameController extends Controller
{
    use AuthorizesRequests, HandlesBase64Image;

    public function index(Request $request)
    {
        $this->authorize('viewAny', HallOfFame::class);

        $query = HallOfFame::with('member');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('category', 'like', "%{$search}%")
                    ->orWhere('winner_name', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->has('member_id') && $request->input('member_id') !== '') {
            $query->where('member_id', $request->input('member_id'));
        }

        if ($request->has('year') && $request->input('year') !== '') {
            $query->where('year', $request->input('year'));
        }

        // Sort
        $sortField = $request->input('sort', 'year');
        $sortOrder = $request->input('direction', 'desc');
        $allowedSorts = ['category', 'winner_name', 'year', 'created_at'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder);
        }

        $records = $query->paginate(10)->withQueryString();
        $members = Member::orderBy('name')->get();
        $years = HallOfFame::distinct()->pluck('year')->filter()->toArray();

        return view('admin.hall-of-fame.index', compact('records', 'members', 'years'));
    }

    public function create()
    {
        $this->authorize('create', HallOfFame::class);
        $members = Member::orderBy('name')->get();

        return view('admin.hall-of-fame.create', compact('members'));
    }

    public function store(HallOfFameRequest $request)
    {
        $this->authorize('create', HallOfFame::class);
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('hall_of_fames', 'public');
        } elseif ($request->filled('photo') && str_contains($request->input('photo'), 'base64,')) {
            $data['photo'] = $this->storeBase64Image($request->input('photo'), 'hall_of_fames');
        } else {
            unset($data['photo']);
        }

        // If member_id is selected, retrieve and save the member name as winner_name
        if ($request->input('member_id')) {
            $member = Member::find($request->input('member_id'));
            if ($member) {
                $data['winner_name'] = $member->name;
            }
        }

        HallOfFame::create($data);

        return redirect()->route('hall-of-fame.index')->with('success', 'Hall of Fame berhasil ditambahkan.');
    }

    public function edit(HallOfFame $hallOfFame)
    {
        $this->authorize('update', $hallOfFame);
        $members = Member::orderBy('name')->get();

        return view('admin.hall-of-fame.edit', compact('hallOfFame', 'members'));
    }

    public function update(HallOfFameRequest $request, HallOfFame $hallOfFame)
    {
        $this->authorize('update', $hallOfFame);
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($hallOfFame->photo) Storage::disk('public')->delete($hallOfFame->photo);
            $data['photo'] = $request->file('photo')->store('hall_of_fames', 'public');
        } elseif ($request->filled('photo') && str_contains($request->input('photo'), 'base64,')) {
            $data['photo'] = $this->replaceBase64Image($request->input('photo'), $hallOfFame->photo, 'hall_of_fames');
        } else {
            unset($data['photo']);
        }

        if ($request->input('member_id')) {
            $member = Member::find($request->input('member_id'));
            if ($member) {
                $data['winner_name'] = $member->name;
            }
        }

        $hallOfFame->update($data);

        return redirect()->route('hall-of-fame.index')->with('success', 'Hall of Fame berhasil diubah.');
    }

    public function destroy(HallOfFame $hallOfFame)
    {
        $this->authorize('delete', $hallOfFame);

        if ($hallOfFame->photo) {
            Storage::disk('public')->delete($hallOfFame->photo);
        }

        $hallOfFame->delete();

        return redirect()->route('hall-of-fame.index')->with('success', 'Hall of Fame berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', HallOfFame::class);

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('hall-of-fame.index')->with('error', 'Pilih data yang ingin dihapus.');
        }

        $records = HallOfFame::whereIn('id', $ids)->get();
        foreach ($records as $record) {
            if ($record->photo) {
                Storage::disk('public')->delete($record->photo);
            }
            $record->delete();
        }

        return redirect()->route('hall-of-fame.index')->with('success', 'Data terpilih berhasil dihapus.');
    }
}
