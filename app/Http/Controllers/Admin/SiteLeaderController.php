<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteLeader;
use Illuminate\Http\Request;

class SiteLeaderController extends Controller
{
    public function index()
    {
        $leaders = SiteLeader::ordered()->get();
        return view('admin.website.leaders.index', compact('leaders'));
    }

    public function create()
    {
        return view('admin.website.leaders.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('site/leaders', 'public');
        }

        unset($validated['photo']);
        SiteLeader::create($validated);

        return redirect()->route('admin.website.leaders.index')
            ->with('success', 'Leader added successfully.');
    }

    public function edit(SiteLeader $leader)
    {
        return view('admin.website.leaders.form', compact('leader'));
    }

    public function update(Request $request, SiteLeader $leader)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($leader->photo_path) {
                \Storage::disk('public')->delete($leader->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('site/leaders', 'public');
        }

        unset($validated['photo']);
        $leader->update($validated);

        return redirect()->route('admin.website.leaders.index')
            ->with('success', 'Leader updated successfully.');
    }

    public function destroy(SiteLeader $leader)
    {
        if ($leader->photo_path) {
            \Storage::disk('public')->delete($leader->photo_path);
        }
        $leader->delete();

        return redirect()->route('admin.website.leaders.index')
            ->with('success', 'Leader deleted successfully.');
    }
}
