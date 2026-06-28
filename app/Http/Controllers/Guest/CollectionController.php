<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Writing;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CollectionController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search')->toString();

        $collections = Collection::published()
            ->withCount('publishedWritings')
            ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"))
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Guest/Collections', [
            'collections' => $collections,
            'search'      => $search,
        ]);
    }

    public function show(string $slug): Response
    {
        $collection = Collection::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $writings = Writing::published()
            ->where('collection_id', $collection->id)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'slug', 'type', 'excerpt', 'thumbnail', 'written_at', 'created_at']);

        return Inertia::render('Guest/CollectionDetail', [
            'collection' => $collection,
            'writings'   => $writings,
        ]);
    }

    public function showWriting(string $collectionSlug, string $writingSlug): Response
    {
        $collection = Collection::published()
            ->where('slug', $collectionSlug)
            ->firstOrFail();

        $writing = Writing::published()
            ->where('collection_id', $collection->id)
            ->where('slug', $writingSlug)
            ->firstOrFail();

        return Inertia::render('Guest/WritingDetail', [
            'collection' => $collection,
            'writing'    => $writing,
        ]);
    }
}
