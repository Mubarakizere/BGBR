<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivityController extends Controller
{
    /**
     * Display a listing of activities.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Activity::class);

        $query = Activity::withCount('members');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $activities = $query->latest('date')->paginate(12);

        return view('activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create()
    {
        Gate::authorize('create', Activity::class);

        return view('activities.create');
    }

    /**
     * Store a newly created activity.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Activity::class);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'participation_fee' => 'required|numeric|min:0',
            'requirements' => 'nullable|string',
            'date' => 'required|date',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'location' => 'nullable|string|max:255',
        ]);

        Activity::create($data);

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    /**
     * Display the specified activity with participants.
     */
    public function show(Activity $activity)
    {
        Gate::authorize('view', $activity);

        $activity->load(['members.company']);

        return view('activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(Activity $activity)
    {
        Gate::authorize('update', $activity);

        return view('activities.edit', compact('activity'));
    }

    /**
     * Update the specified activity.
     */
    public function update(Request $request, Activity $activity)
    {
        Gate::authorize('update', $activity);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'participation_fee' => 'required|numeric|min:0',
            'requirements' => 'nullable|string',
            'date' => 'required|date',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'location' => 'nullable|string|max:255',
        ]);

        $activity->update($data);

        return redirect()->route('activities.show', $activity)->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified activity.
     */
    public function destroy(Activity $activity)
    {
        Gate::authorize('delete', $activity);

        $activity->members()->detach();
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }
}
