<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Writing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class WritingController extends Controller
{
    public function index(): Response
    {
        $writings = Writing::with('collection')
            ->orderByDesc('created_at')
            ->paginate(9);

        return Inertia::render('Admin/Writings/Index', [
            'writings' => $writings,
        ]);
    }

    public function create(): Response
    {
        $collections = Collection::orderBy('title')->get(['id', 'title']);

        return Inertia::render('Admin/Writings/Form', [
            'collections' => $collections,
            'types' => Writing::types(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'collection_id' => 'required|exists:collections,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:writings,slug',
            'type' => 'required|string|in:'.implode(',', Writing::types()),
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'sort_order' => 'integer|min:0',
            'written_at' => 'nullable|date',
        ]);

        $validated['slug'] = $validated['slug']
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('writings', 'public');
        }

        Writing::create($validated);

        return redirect()->route('admin.writings.index')
            ->with('success', 'Tulisan berhasil dibuat.');
    }

    public function edit(Writing $writing): Response
    {
        $collections = Collection::orderBy('title')->get(['id', 'title']);

        return Inertia::render('Admin/Writings/Form', [
            'writing' => $writing,
            'collections' => $collections,
            'types' => Writing::types(),
        ]);
    }

    public function update(Request $request, Writing $writing): RedirectResponse
    {
        $validated = $request->validate([
            'collection_id' => 'required|exists:collections,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:writings,slug,'.$writing->id,
            'type' => 'required|string|in:'.implode(',', Writing::types()),
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'sort_order' => 'integer|min:0',
            'written_at' => 'nullable|date',
        ]);

        $validated['slug'] = $validated['slug']
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            if ($writing->thumbnail) {
                Storage::disk('public')->delete($writing->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('writings', 'public');
        }

        $writing->update($validated);

        return redirect()->route('admin.writings.index')
            ->with('success', 'Tulisan berhasil diperbarui.');
    }

    public function destroy(Writing $writing): RedirectResponse
    {
        if ($writing->thumbnail) {
            Storage::disk('public')->delete($writing->thumbnail);
        }

        $writing->delete();

        return redirect()->route('admin.writings.index')
            ->with('success', 'Tulisan berhasil dihapus.');
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|max:4096',
        ]);

        $path = (string) $request->file('image')->store('writings/images', 'public');

        return response()->json([
            'url' => Storage::disk('public')->url($path),
        ]);
    }
}
