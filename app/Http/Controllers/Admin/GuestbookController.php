<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guestbook;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class GuestbookController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Guestbook::class);

        $query = Guestbook::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter
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

        $messages = $query->paginate(10)->withQueryString();

        return view('admin.guestbook.index', compact('messages'));
    }

    public function approve(Guestbook $guestbook)
    {
        $this->authorize('approve', $guestbook);

        $guestbook->update(['status' => 'approved']);

        return redirect()->route('guestbook.index')->with('success', 'Pesan guestbook berhasil disetujui.');
    }

    public function reject(Guestbook $guestbook)
    {
        $this->authorize('approve', $guestbook);

        $guestbook->update(['status' => 'rejected']);

        return redirect()->route('guestbook.index')->with('success', 'Pesan guestbook ditolak.');
    }

    public function destroy(Guestbook $guestbook)
    {
        $this->authorize('delete', $guestbook);
        $guestbook->delete();

        return redirect()->route('guestbook.index')->with('success', 'Pesan guestbook berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', Guestbook::class);

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('guestbook.index')->with('error', 'Pilih data yang ingin dihapus.');
        }

        Guestbook::whereIn('id', $ids)->delete();

        return redirect()->route('guestbook.index')->with('success', 'Data terpilih berhasil dihapus.');
    }
}
