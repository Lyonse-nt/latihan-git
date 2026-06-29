<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->has('role') && $request->input('role') !== '') {
            $query->where('role', $request->input('role'));
        }

        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('status', $request->input('status'));
        }

        // Sort
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('direction', 'desc');
        $allowedSorts = ['name', 'email', 'status', 'created_at'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder);
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return view('admin.users.create');
    }

    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User Admin berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validated();

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User Admin berhasil diubah.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        // Prevent self deletion
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User Admin berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', User::class);

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('users.index')->with('error', 'Pilih data yang ingin dihapus.');
        }

        // Exclude self from deletion list
        $ids = array_diff($ids, [auth()->id()]);

        if (empty($ids)) {
            return redirect()->route('users.index')->with('error', 'Tidak ada data valid yang bisa dihapus (Anda tidak bisa menghapus diri sendiri).');
        }

        User::whereIn('id', $ids)->delete();

        return redirect()->route('users.index')->with('success', 'Data terpilih berhasil dihapus.');
    }
}
