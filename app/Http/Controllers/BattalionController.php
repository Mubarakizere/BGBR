<?php

namespace App\Http\Controllers;

use App\Models\Battalion;
use App\Models\Domination;
use Illuminate\Http\Request;

class BattalionController extends Controller
{
    public function index()
    {
        $battalions = Battalion::with('domination')->orderBy('name')->get();
        $dominations = Domination::orderBy('name')->get();
        return view('battalions.index', compact('battalions', 'dominations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domination_id' => 'required|exists:dominations,id',
        ]);

        Battalion::create($request->all());

        return back()->with('success', 'Battalion created successfully.');
    }

    public function update(Request $request, Battalion $battalion)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domination_id' => 'required|exists:dominations,id',
        ]);

        $battalion->update($request->all());

        return back()->with('success', 'Battalion updated successfully.');
    }

    public function destroy(Battalion $battalion)
    {
        $battalion->delete();
        return back()->with('success', 'Battalion deleted successfully.');
    }
}
