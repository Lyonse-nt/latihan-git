<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\Member;
use App\Traits\HandlesBase64Image;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    use AuthorizesRequests, HandlesBase64Image;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Member::class);

        $query = Member::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nickname', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter
        if ($request->has('is_active') && $request->input('is_active') !== '') {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Sort
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('direction', 'desc');
        $allowedSorts = ['name', 'nickname', 'role', 'date_of_birth', 'created_at'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder);
        }

        $members = $query->paginate(10)->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        $this->authorize('create', Member::class);

        return view('admin.members.create');
    }

    public function store(MemberRequest $request)
    {
        $this->authorize('create', Member::class);
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', 'public');
        } elseif ($request->filled('photo') && str_contains($request->input('photo'), 'base64,')) {
            $data['photo'] = $this->storeBase64Image($request->input('photo'), 'members');
        } else {
            unset($data['photo']);
        }

        $data['is_active'] = $request->has('is_active');

        Member::create($data);

        return redirect()->route('members.index')->with('success', 'Member berhasil ditambahkan.');
    }

    public function show(Member $member)
    {
        $this->authorize('view', $member);

        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $this->authorize('update', $member);

        return view('admin.members.edit', compact('member'));
    }

    public function update(MemberRequest $request, Member $member)
    {
        $this->authorize('update', $member);
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($member->photo) Storage::disk('public')->delete($member->photo);
            $data['photo'] = $request->file('photo')->store('members', 'public');
        } elseif ($request->filled('photo') && str_contains($request->input('photo'), 'base64,')) {
            $data['photo'] = $this->replaceBase64Image($request->input('photo'), $member->photo, 'members');
        } else {
            unset($data['photo']);
        }

        $data['is_active'] = $request->has('is_active');

        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Member berhasil diubah.');
    }

    public function destroy(Member $member)
    {
        $this->authorize('delete', $member);

        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', Member::class);

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('members.index')->with('error', 'Pilih data yang ingin dihapus.');
        }

        $members = Member::whereIn('id', $ids)->get();
        foreach ($members as $member) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $member->delete();
        }

        return redirect()->route('members.index')->with('success', 'Data terpilih berhasil dihapus.');
    }
}
