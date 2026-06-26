<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Denomination;
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
     * Denomination Admin: users within their denomination.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $query = User::with(['denomination', 'battalion', 'company', 'roles']);

        // Scope for Denomination Admin
        if ($currentUser->hasRole('Denomination Admin') && $currentUser->denomination_id) {
            $query->where('denomination_id', $currentUser->denomination_id);
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
        $denominations = Denomination::orderBy('name')->get();
        $battalions = Battalion::with('denomination')->orderBy('name')->get();
        $companies = Company::with('battalion')->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles', 'denominations', 'battalions', 'companies'));
    }

    /**
     * Toggle the is_approved status of a user (activate/deactivate).
     */
    public function toggleActive(User $user)
    {
        $currentUser = Auth::user();

        // Denomination Admin can only manage users in their denomination
        if ($currentUser->hasRole('Denomination Admin') && $user->denomination_id !== $currentUser->denomination_id) {
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

        // Denomination Admin scope check
        if ($currentUser->hasRole('Denomination Admin') && $user->denomination_id !== $currentUser->denomination_id) {
            abort(403);
        }

        $request->validate([
            'role' => 'required|exists:roles,name',
            'denomination_id' => 'nullable|exists:denominations,id',
            'battalion_id' => 'nullable|exists:battalions,id',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        // Prevent Denomination Admin from assigning Super Admin role
        if (!$currentUser->hasRole('Super Admin') && $request->role === 'Super Admin') {
            return back()->with('error', 'You cannot assign the Super Admin role.');
        }

        $user->syncRoles([$request->role]);

        // Reset hierarchy, then set
        $user->denomination_id = null;
        $user->battalion_id = null;
        $user->company_id = null;

        if ($request->denomination_id) $user->denomination_id = $request->denomination_id;
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
