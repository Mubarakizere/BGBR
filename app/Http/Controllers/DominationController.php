<?php

namespace App\Http\Controllers;

use App\Models\Domination;
use Illuminate\Http\Request;

class DominationController extends Controller
{
    public function index()
    {
        $dominations = Domination::orderBy('name')->get();
        return view('dominations.index', compact('dominations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
        ]);

        Domination::create($request->all());

        return back()->with('success', 'Domination created successfully.');
    }

    public function update(Request $request, Domination $domination)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
        ]);

        $domination->update($request->all());

        return back()->with('success', 'Domination updated successfully.');
    }

    public function destroy(Domination $domination)
    {
        $domination->delete();
        return back()->with('success', 'Domination deleted successfully.');
    }
}
