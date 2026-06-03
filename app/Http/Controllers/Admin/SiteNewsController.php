<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteNews;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SiteNewsController extends Controller
{
    public function index()
    {
        $articles = SiteNews::orderByDesc('created_at')->get();
        return view('admin.website.news.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.website.news.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:site_news,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'author_name' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('site/news', 'public');
        }

        if (!empty($validated['is_published'])) {
            $validated['published_at'] = now();
        }

        unset($validated['image']);
        SiteNews::create($validated);

        return redirect()->route('admin.website.news.index')
            ->with('success', 'Article created successfully.');
    }

    public function edit(SiteNews $news)
    {
        return view('admin.website.news.form', ['article' => $news]);
    }

    public function update(Request $request, SiteNews $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:site_news,slug,' . $news->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'author_name' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            if ($news->image_path) {
                \Storage::disk('public')->delete($news->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('site/news', 'public');
        }

        if (!empty($validated['is_published']) && !$news->published_at) {
            $validated['published_at'] = now();
        }

        unset($validated['image']);
        $news->update($validated);

        return redirect()->route('admin.website.news.index')
            ->with('success', 'Article updated successfully.');
    }

    public function destroy(SiteNews $news)
    {
        if ($news->image_path) {
            \Storage::disk('public')->delete($news->image_path);
        }
        $news->delete();

        return redirect()->route('admin.website.news.index')
            ->with('success', 'Article deleted successfully.');
    }
}
