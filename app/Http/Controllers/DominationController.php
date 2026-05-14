<?php

namespace App\Http\Controllers;

use App\Models\Domination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DominationController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Domination::class);
        $dominations = Domination::orderBy('name')->get();
        return view('dominations.index', compact('dominations'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Domination::class);
        $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
        ]);

        Domination::create($request->all());

        return back()->with('success', 'Domination created successfully.');
    }

    public function update(Request $request, Domination $domination)
    {
        Gate::authorize('update', $domination);
        $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
        ]);

        $domination->update($request->all());

        return back()->with('success', 'Domination updated successfully.');
    }

    public function destroy(Domination $domination)
    {
        Gate::authorize('delete', $domination);
        $domination->delete();
        return back()->with('success', 'Domination deleted successfully.');
    }
}
