<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteGalleryImage;
use Illuminate\Http\Request;

class SiteGalleryController extends Controller
{
    public function index()
    {
        $images = SiteGalleryImage::ordered()->get();
        $albums = $images->pluck('album')->filter()->unique()->values();
        return view('admin.website.gallery.index', compact('images', 'albums'));
    }

    public function create()
    {
        return view('admin.website.gallery.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'album' => 'nullable|string|max:255',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['image_path'] = $request->file('image')->store('site/gallery', 'public');

        unset($validated['image']);
        SiteGalleryImage::create($validated);

        return redirect()->route('admin.website.gallery.index')
            ->with('success', 'Image uploaded successfully.');
    }

    public function edit(SiteGalleryImage $gallery)
    {
        return view('admin.website.gallery.form', ['image' => $gallery]);
    }

    public function update(Request $request, SiteGalleryImage $gallery)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'album' => 'nullable|string|max:255',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            \Storage::disk('public')->delete($gallery->image_path);
            $validated['image_path'] = $request->file('image')->store('site/gallery', 'public');
        }

        unset($validated['image']);
        $gallery->update($validated);

        return redirect()->route('admin.website.gallery.index')
            ->with('success', 'Image updated successfully.');
    }

    public function destroy(SiteGalleryImage $gallery)
    {
        \Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return redirect()->route('admin.website.gallery.index')
            ->with('success', 'Image deleted successfully.');
    }
}
