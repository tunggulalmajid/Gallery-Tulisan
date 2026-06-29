<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CollectionController extends Controller
{
    public function index(): Response
    {
        $collections = Collection::withCount('writings')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Admin/Collections/Index', [
            'collections' => $collections,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Collections/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:collections,slug',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['slug'] = $validated['slug']
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('collections', 'public');
        }

        Collection::create($validated);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Koleksi berhasil dibuat.');
    }

    public function edit(Collection $collection): Response
    {
        return Inertia::render('Admin/Collections/Form', [
            'collection' => $collection,
        ]);
    }

    public function update(Request $request, Collection $collection): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:collections,slug,'.$collection->id,
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['slug'] = $validated['slug']
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            if ($collection->thumbnail) {
                Storage::disk('public')->delete($collection->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('collections', 'public');
        }

        $collection->update($validated);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Koleksi berhasil diperbarui.');
    }

    public function destroy(Collection $collection): RedirectResponse
    {
        if ($collection->thumbnail) {
            Storage::disk('public')->delete($collection->thumbnail);
        }

        $collection->delete();

        return redirect()->route('admin.collections.index')
            ->with('success', 'Koleksi berhasil dihapus.');
    }
}
