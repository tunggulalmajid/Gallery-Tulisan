<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Writing;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $collections = Collection::published()
            ->orderByDesc('updated_at')
            ->get(['slug', 'updated_at']);

        $writings = Writing::published()
            ->with('collection:id,slug')
            ->orderByDesc('updated_at')
            ->get(['slug', 'collection_id', 'updated_at']);

        $content = view('sitemap', compact('collections', 'writings'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
