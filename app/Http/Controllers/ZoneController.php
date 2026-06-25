<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ZoneController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Zone::class);
        $zones = Zone::withCount('battalions')->orderBy('name')->paginate(15)->withQueryString();
        return view('zones.index', compact('zones'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Zone::class);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Zone::create($request->all());

        return back()->with('success', 'Zone created successfully.');
    }

    public function update(Request $request, Zone $zone)
    {
        Gate::authorize('update', $zone);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $zone->update($request->all());

        return back()->with('success', 'Zone updated successfully.');
    }

    public function destroy(Zone $zone)
    {
        Gate::authorize('delete', $zone);
        $zone->delete();
        return back()->with('success', 'Zone deleted successfully.');
    }
}
