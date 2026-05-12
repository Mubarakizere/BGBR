<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Domination;
use App\Models\Battalion;
use App\Models\Company;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserApprovalController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('is_approved', false)->latest()->get();
        $roles = Role::where('name', '!=', 'Super Admin')->get(); // Don't allow assigning Super Admin via this UI
        $dominations = Domination::orderBy('name')->get();
        $battalions = Battalion::with('domination')->orderBy('name')->get();
        $companies = Company::with('battalion')->orderBy('name')->get();

        return view('admin.users.pending', compact('pendingUsers', 'roles', 'dominations', 'battalions', 'companies'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'domination_id' => 'nullable|exists:dominations,id',
            'battalion_id' => 'nullable|exists:battalions,id',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        $user->syncRoles([$request->role]);
        $user->is_approved = true;
        
        // Reset IDs first, then set based on input
        $user->domination_id = null;
        $user->battalion_id = null;
        $user->company_id = null;

        if ($request->domination_id) $user->domination_id = $request->domination_id;
        if ($request->battalion_id) $user->battalion_id = $request->battalion_id;
        if ($request->company_id) $user->company_id = $request->company_id;

        $user->save();

        return back()->with('success', "User {$user->name} has been approved and assigned to the {$request->role} role.");
    }
}
