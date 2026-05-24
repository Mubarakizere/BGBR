<?php

namespace App\Http\Controllers;

use App\Models\Battalion;
use App\Models\Domination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BattalionController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Battalion::class);
        $battalions = Battalion::with('domination')->orderBy('name')->paginate(15)->withQueryString();
        $dominations = Domination::orderBy('name')->get();
        return view('battalions.index', compact('battalions', 'dominations'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Battalion::class);
        
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'domination_id' => 'required|exists:dominations,id',
        ]);

        if (!$user->hasRole('Super Admin')) {
            if ($request->domination_id !== $user->domination_id) {
                return back()->with('error', 'Unauthorized to assign this battalion to another domination.');
            }
        }

        Battalion::create($request->all());

        return back()->with('success', 'Battalion created successfully.');
    }

    public function update(Request $request, Battalion $battalion)
    {
        Gate::authorize('update', $battalion);
        
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'domination_id' => 'required|exists:dominations,id',
        ]);

        if (!$user->hasRole('Super Admin')) {
            if ($request->domination_id !== $user->domination_id) {
                return back()->with('error', 'Unauthorized to assign this battalion to another domination.');
            }
        }

        $battalion->update($request->all());

        return back()->with('success', 'Battalion updated successfully.');
    }

    public function destroy(Battalion $battalion)
    {
        Gate::authorize('delete', $battalion);
        $battalion->delete();
        return back()->with('success', 'Battalion deleted successfully.');
    }
}
