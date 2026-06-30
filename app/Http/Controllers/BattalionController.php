<?php

namespace App\Http\Controllers;

use App\Models\Battalion;
use App\Models\Denomination;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BattalionController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Battalion::class);
        $battalions = Battalion::with(['denomination', 'zone'])->orderBy('name')->paginate(15)->withQueryString();
        $denominations = Denomination::orderBy('name')->get();
        $zones = Zone::orderBy('name')->get();
        return view('battalions.index', compact('battalions', 'denominations', 'zones'));
    }

    public function show(Battalion $battalion)
    {
        Gate::authorize('viewAny', Battalion::class);
        $battalion->load(['denomination', 'companies', 'companies.officers']);
        return view('battalions.show', compact('battalion'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Battalion::class);
        
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'denomination_id' => 'required|exists:denominations,id',
            'zone_id' => 'nullable|exists:zones,id',
        ]);

        if (!$user->hasRole('Super Admin')) {
            if ($request->denomination_id !== $user->denomination_id) {
                return back()->with('error', 'Unauthorized to assign this battalion to another denomination.');
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
            'denomination_id' => 'required|exists:denominations,id',
            'zone_id' => 'nullable|exists:zones,id',
        ]);

        if (!$user->hasRole('Super Admin')) {
            if ($request->denomination_id !== $user->denomination_id) {
                return back()->with('error', 'Unauthorized to assign this battalion to another denomination.');
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
