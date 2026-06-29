<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Project::class);

        $query = Project::with('member');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->has('member_id') && $request->input('member_id') !== '') {
            $query->where('member_id', $request->input('member_id'));
        }

        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('status', $request->input('status'));
        }

        // Sort
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('direction', 'desc');
        $allowedSorts = ['name', 'status', 'created_at'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder);
        }

        $projects = $query->paginate(10)->withQueryString();
        $members = Member::orderBy('name')->get();

        return view('admin.projects.index', compact('projects', 'members'));
    }

    public function create()
    {
        $this->authorize('create', Project::class);
        $members = Member::orderBy('name')->get();

        return view('admin.projects.create', compact('members'));
    }

    public function store(ProjectRequest $request)
    {
        $this->authorize('create', Project::class);
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        Project::create($data);

        return redirect()->route('projects.index')->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        $members = Member::orderBy('name')->get();

        return view('admin.projects.edit', compact('project', 'members'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        $project->update($data);

        return redirect()->route('projects.index')->with('success', 'Project berhasil diubah.');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', Project::class);

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('projects.index')->with('error', 'Pilih data yang ingin dihapus.');
        }

        $projects = Project::whereIn('id', $ids)->get();
        foreach ($projects as $project) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $project->delete();
        }

        return redirect()->route('projects.index')->with('success', 'Data terpilih berhasil dihapus.');
    }
}
