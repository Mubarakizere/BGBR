<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Battalion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Company::class);
        $companies = Company::with(['battalion', 'officers'])->orderBy('name')->paginate(15)->withQueryString();
        $battalions = Battalion::with('domination')->orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('companies.index', compact('companies', 'battalions', 'users'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Company::class);
        
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'battalion_id' => 'required|exists:battalions,id',
            'date_started' => 'nullable|date',
        ]);

        if (!$user->hasRole('Super Admin')) {
            if ($user->hasRole('Domination Admin') && $user->domination_id) {
                $battalion = Battalion::find($request->battalion_id);
                if (!$battalion || $battalion->domination_id !== $user->domination_id) {
                    return back()->with('error', 'Unauthorized to assign this company to a battalion outside your domination.');
                }
            } elseif ($user->hasRole('Battalion Commander') && $user->battalion_id) {
                if ($request->battalion_id !== $user->battalion_id) {
                    return back()->with('error', 'Unauthorized to assign this company to another battalion.');
                }
            } else {
                return back()->with('error', 'Unauthorized.');
            }
        }

        Company::create($request->all());

        return back()->with('success', 'Company created successfully.');
    }

    public function update(Request $request, Company $company)
    {
        Gate::authorize('update', $company);
        
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'battalion_id' => 'required|exists:battalions,id',
            'date_started' => 'nullable|date',
        ]);

        if (!$user->hasRole('Super Admin')) {
            if ($user->hasRole('Domination Admin') && $user->domination_id) {
                $battalion = Battalion::find($request->battalion_id);
                if (!$battalion || $battalion->domination_id !== $user->domination_id) {
                    return back()->with('error', 'Unauthorized to assign this company to a battalion outside your domination.');
                }
            } elseif ($user->hasRole('Battalion Commander') && $user->battalion_id) {
                if ($request->battalion_id !== $user->battalion_id) {
                    return back()->with('error', 'Unauthorized to assign this company to another battalion.');
                }
            } else {
                return back()->with('error', 'Unauthorized.');
            }
        }

        $company->update($request->all());

        return back()->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        Gate::authorize('delete', $company);
        $company->delete();
        return back()->with('success', 'Company deleted successfully.');
    }

    public function assignOfficer(Request $request, Company $company)
    {
        Gate::authorize('update', $company);
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rank' => 'required|in:NCO,W/O,Lt,Capt,Trainer',
        ]);

        // Sync without detaching, or attach. Since a user can have one rank per company:
        $company->officers()->syncWithoutDetaching([
            $request->user_id => ['rank' => $request->rank]
        ]);

        return back()->with('success', 'Officer assigned successfully.');
    }
    
    public function removeOfficer(Request $request, Company $company, User $user)
    {
        Gate::authorize('update', $company);
        $company->officers()->detach($user->id);
        return back()->with('success', 'Officer removed successfully.');
    }
}
