<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteEvent;
use Illuminate\Http\Request;

class SiteEventController extends Controller
{
    public function index()
    {
        $events = SiteEvent::orderByDesc('event_date')->get();
        return view('admin.website.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.website.events.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:event_date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('site/events', 'public');
        }

        unset($validated['image']);
        SiteEvent::create($validated);

        return redirect()->route('admin.website.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function edit(SiteEvent $event)
    {
        return view('admin.website.events.form', compact('event'));
    }

    public function update(Request $request, SiteEvent $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:event_date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image_path) {
                \Storage::disk('public')->delete($event->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('site/events', 'public');
        }

        unset($validated['image']);
        $event->update($validated);

        return redirect()->route('admin.website.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(SiteEvent $event)
    {
        if ($event->image_path) {
            \Storage::disk('public')->delete($event->image_path);
        }
        $event->delete();

        return redirect()->route('admin.website.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
