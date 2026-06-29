<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuoteRequest;
use App\Models\Quote;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Quote::class);

        $query = Quote::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('quote', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter
        if ($request->has('is_published') && $request->input('is_published') !== '') {
            $query->where('is_published', $request->boolean('is_published'));
        }

        // Sort
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('direction', 'desc');
        $allowedSorts = ['author', 'created_at'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder);
        }

        $quotes = $query->paginate(10)->withQueryString();

        return view('admin.quotes.index', compact('quotes'));
    }

    public function create()
    {
        $this->authorize('create', Quote::class);

        return view('admin.quotes.create');
    }

    public function store(QuoteRequest $request)
    {
        $this->authorize('create', Quote::class);
        $data = $request->validated();
        $data['is_published'] = $request->has('is_published');

        Quote::create($data);

        return redirect()->route('quotes.index')->with('success', 'Quote berhasil ditambahkan.');
    }

    public function edit(Quote $quote)
    {
        $this->authorize('update', $quote);

        return view('admin.quotes.edit', compact('quote'));
    }

    public function update(QuoteRequest $request, Quote $quote)
    {
        $this->authorize('update', $quote);
        $data = $request->validated();
        $data['is_published'] = $request->has('is_published');

        $quote->update($data);

        return redirect()->route('quotes.index')->with('success', 'Quote berhasil diubah.');
    }

    public function destroy(Quote $quote)
    {
        $this->authorize('delete', $quote);
        $quote->delete();

        return redirect()->route('quotes.index')->with('success', 'Quote berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', Quote::class);

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('quotes.index')->with('error', 'Pilih data yang ingin dihapus.');
        }

        Quote::whereIn('id', $ids)->delete();

        return redirect()->route('quotes.index')->with('success', 'Data terpilih berhasil dihapus.');
    }
}
