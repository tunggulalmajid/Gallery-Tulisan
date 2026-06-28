<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\AuthorProfile;
use Inertia\Inertia;
use Inertia\Response;

class AuthorController extends Controller
{
    public function index(): Response
    {
        $author = AuthorProfile::first();

        return Inertia::render('Guest/Author', [
            'author' => $author,
        ]);
    }
}
