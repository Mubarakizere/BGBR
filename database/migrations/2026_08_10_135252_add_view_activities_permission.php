<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the new permission
        $permission = Permission::findOrCreate('view activities', 'web');

        // Assign to Member role
        $member = Role::findByName('Member', 'web');
        if ($member && !$member->hasPermissionTo('view activities')) {
            $member->givePermissionTo($permission);
        }

        // Also assign to roles that already have higher activity permissions
        foreach (['Company Captain', 'Company Officer', 'Battalion Commander', 'Denomination Admin', 'Super Admin'] as $roleName) {
            $role = Role::findByName($roleName, 'web');
            if ($role && !$role->hasPermissionTo('view activities')) {
                $role->givePermissionTo($permission);
            }
        }

        // Clear cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permission = Permission::findByName('view activities', 'web');
        if ($permission) {
            $permission->delete();
        }
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
