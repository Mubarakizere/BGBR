<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of roles and permissions.
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->paginate(15)->withQueryString();
        $permissions = Permission::orderBy('name')->get();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
        ]);

        Role::create(['name' => $request->name]);

        return back()->with('success', "Role '{$request->name}' created successfully.");
    }

    /**
     * Update the specified role's permissions.
     */
    public function updatePermissions(Request $request, Role $role)
    {
        // Protect Super Admin from being edited to prevent system lockdown
        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Permissions for the Super Admin role cannot be modified.');
        }

        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return back()->with('success', "Permissions for role '{$role->name}' updated successfully.");
    }
}
