<?php

namespace App\Http\Controllers;

use App\Models\Denomination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DenominationController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Denomination::class);
        $denominations = Denomination::orderBy('name')->paginate(15)->withQueryString();
        return view('denominations.index', compact('denominations'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Denomination::class);
        $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
        ]);

        Denomination::create($request->all());

        return back()->with('success', 'Denomination created successfully.');
    }

    public function update(Request $request, Denomination $denomination)
    {
        Gate::authorize('update', $denomination);
        $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
        ]);

        $denomination->update($request->all());

        return back()->with('success', 'Denomination updated successfully.');
    }

    public function destroy(Denomination $denomination)
    {
        Gate::authorize('delete', $denomination);
        $denomination->delete();
        return back()->with('success', 'Denomination deleted successfully.');
    }
}
