<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Domination;
use App\Models\Battalion;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     * Super Admin: all users.
     * Domination Admin: users within their domination.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $query = User::with(['domination', 'battalion', 'company', 'roles']);

        // Scope for Domination Admin
        if ($currentUser->hasRole('Domination Admin') && $currentUser->domination_id) {
            $query->where('domination_id', $currentUser->domination_id);
        } elseif (!$currentUser->hasRole('Super Admin')) {
            abort(403);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_approved', $request->status === 'active');
        }

        $users = $query->latest()->paginate(20);
        $roles = Role::orderBy('name')->get();
        $dominations = Domination::orderBy('name')->get();
        $battalions = Battalion::with('domination')->orderBy('name')->get();
        $companies = Company::with('battalion')->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles', 'dominations', 'battalions', 'companies'));
    }

    /**
     * Toggle the is_approved status of a user (activate/deactivate).
     */
    public function toggleActive(User $user)
    {
        $currentUser = Auth::user();

        // Domination Admin can only manage users in their domination
        if ($currentUser->hasRole('Domination Admin') && $user->domination_id !== $currentUser->domination_id) {
            abort(403);
        }

        // Prevent deactivating yourself or a Super Admin
        if ($user->id === $currentUser->id) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }
        if ($user->hasRole('Super Admin') && !$currentUser->hasRole('Super Admin')) {
            return back()->with('error', 'You cannot modify a Super Admin account.');
        }

        $user->is_approved = !$user->is_approved;
        $user->save();

        $status = $user->is_approved ? 'activated' : 'deactivated';
        return back()->with('success', "User {$user->name} has been {$status}.");
    }

    /**
     * Update the role and hierarchy assignment for a user.
     */
    public function updateRole(Request $request, User $user)
    {
        $currentUser = Auth::user();

        // Domination Admin scope check
        if ($currentUser->hasRole('Domination Admin') && $user->domination_id !== $currentUser->domination_id) {
            abort(403);
        }

        $request->validate([
            'role' => 'required|exists:roles,name',
            'domination_id' => 'nullable|exists:dominations,id',
            'battalion_id' => 'nullable|exists:battalions,id',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        // Prevent Domination Admin from assigning Super Admin role
        if (!$currentUser->hasRole('Super Admin') && $request->role === 'Super Admin') {
            return back()->with('error', 'You cannot assign the Super Admin role.');
        }

        $user->syncRoles([$request->role]);

        // Reset hierarchy, then set
        $user->domination_id = null;
        $user->battalion_id = null;
        $user->company_id = null;

        if ($request->domination_id) $user->domination_id = $request->domination_id;
        if ($request->battalion_id) $user->battalion_id = $request->battalion_id;
        if ($request->company_id) $user->company_id = $request->company_id;

        // Auto-approve if not already
        if (!$user->is_approved) {
            $user->is_approved = true;
        }

        $user->save();

        return back()->with('success', "User {$user->name} updated to {$request->role} role.");
    }
}
