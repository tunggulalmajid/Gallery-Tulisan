<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AuthorProfileController extends Controller
{
    public function edit(): Response
    {
        $profile = AuthorProfile::first();

        return Inertia::render('Admin/Profile/Edit', [
            'profile' => $profile,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'bio' => 'nullable|string',
            'tagline' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:100',
            'twitter' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
        ]);

        $profile = AuthorProfile::first();

        if ($request->hasFile('photo')) {
            if ($profile && $profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $validated['photo'] = $request->file('photo')
                ->store('profile', 'public');
        }

        if ($profile) {
            $profile->update($validated);
        } else {
            AuthorProfile::create($validated);
        }

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
