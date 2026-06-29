<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Writing;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $stats = [
            'total_collections' => Collection::count(),
            'total_writings' => Writing::count(),
            'published_writings' => Writing::where('is_published', true)->count(),
            'draft_writings' => Writing::where('is_published', false)->count(),
        ];

        $recentWritings = Writing::with('collection')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $recentCollections = Collection::withCount('writings')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentWritings' => $recentWritings,
            'recentCollections' => $recentCollections,
        ]);
    }
}
