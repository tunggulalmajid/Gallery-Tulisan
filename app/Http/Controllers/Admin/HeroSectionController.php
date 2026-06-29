<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class HeroSectionController extends Controller
{
    public function edit(): Response
    {
        $hero = HeroSection::first();

        return Inertia::render('Admin/Hero/Edit', [
            'hero' => $hero,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'cta_label' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
            'is_active' => 'boolean',
        ]);

        $hero = HeroSection::first();

        if ($request->hasFile('image')) {
            if ($hero && $hero->image) {
                Storage::disk('public')->delete($hero->image);
            }
            $validated['image'] = $request->file('image')->store('hero', 'public');
        }

        if ($hero) {
            $hero->update($validated);
        } else {
            HeroSection::create($validated);
        }

        return redirect()->route('admin.hero.edit')
            ->with('success', 'Hero section berhasil diperbarui.');
    }
}
