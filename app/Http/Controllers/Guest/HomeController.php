<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\AuthorProfile;
use App\Models\Collection;
use App\Models\Writing;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $latestWritings = Writing::with('collection')
            ->published()
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        $latestCollections = Collection::published()
            ->withCount('publishedWritings')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        $author = AuthorProfile::first();

        return Inertia::render('Guest/Home', [
            'latestWritings'    => $latestWritings,
            'latestCollections' => $latestCollections,
            'author'            => $author,
        ]);
    }
}
