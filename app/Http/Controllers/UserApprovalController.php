<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Denomination;
use App\Models\Battalion;
use App\Models\Company;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_approved', false);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pendingUsers = $query->latest()->paginate(15)->withQueryString();
        $roles = Role::where('name', '!=', 'Super Admin')->get(); // Don't allow assigning Super Admin via this UI
        $denominations = Denomination::orderBy('name')->get();
        $battalions = Battalion::with('denomination')->orderBy('name')->get();
        $companies = Company::with('battalion')->orderBy('name')->get();

        return view('admin.users.pending', compact('pendingUsers', 'roles', 'denominations', 'battalions', 'companies'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'denomination_id' => 'nullable|exists:denominations,id',
            'battalion_id' => 'nullable|exists:battalions,id',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        $user->syncRoles([$request->role]);
        $user->is_approved = true;
        
        // Reset IDs first, then set based on input
        $user->denomination_id = null;
        $user->battalion_id = null;
        $user->company_id = null;

        if ($request->denomination_id) $user->denomination_id = $request->denomination_id;
        if ($request->battalion_id) $user->battalion_id = $request->battalion_id;
        if ($request->company_id) $user->company_id = $request->company_id;

        $user->save();

        return back()->with('success', "User {$user->name} has been approved and assigned to the {$request->role} role.");
    }

    public function reject(User $user)
    {
        $name = $user->name;
        $user->delete();

        return back()->with('success', "User {$name} has been rejected and removed from the system.");
    }
}
