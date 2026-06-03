<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SitePage;
use Illuminate\Http\Request;

class SitePageController extends Controller
{
    public function index()
    {
        $pages = SitePage::ordered()->get();
        return view('admin.website.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.website.pages.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:site_pages,slug',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('site/pages', 'public');
        }

        unset($validated['image']);
        SitePage::create($validated);

        return redirect()->route('admin.website.pages.index')
            ->with('success', 'Page section created successfully.');
    }

    public function edit(SitePage $page)
    {
        return view('admin.website.pages.form', compact('page'));
    }

    public function update(Request $request, SitePage $page)
    {
        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:site_pages,slug,' . $page->id,
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            if ($page->image_path) {
                \Storage::disk('public')->delete($page->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('site/pages', 'public');
        }

        unset($validated['image']);
        $page->update($validated);

        return redirect()->route('admin.website.pages.index')
            ->with('success', 'Page section updated successfully.');
    }

    public function destroy(SitePage $page)
    {
        if ($page->image_path) {
            \Storage::disk('public')->delete($page->image_path);
        }
        $page->delete();

        return redirect()->route('admin.website.pages.index')
            ->with('success', 'Page section deleted successfully.');
    }
}
