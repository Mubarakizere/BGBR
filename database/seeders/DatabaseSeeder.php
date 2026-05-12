<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'manage dominations', 'create battalions', 'view all reports', 'manage system settings', 'view audit logs', 'manage users',
            'manage battalions', 'approve battalion reports', 'create domination announcements',
            'manage companies', 'approve company reports', 'create battalion announcements',
            'register members', 'register company info', 'submit activity participation', 'generate company reports', 'create company announcements',
            'view members', 'update members', 'participate in activities', 'view company announcements',
            'view own profile', 'view announcements', 'view activity participation history'
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Roles
        $superAdmin = Role::findOrCreate('Super Admin');
        $superAdmin->givePermissionTo(Permission::all());

        $dominationAdmin = Role::findOrCreate('Domination Admin');
        $dominationAdmin->givePermissionTo([
            'manage battalions', 'approve battalion reports', 'create domination announcements', 'view all reports'
        ]);

        $battalionCommander = Role::findOrCreate('Battalion Commander');
        $battalionCommander->givePermissionTo([
            'manage companies', 'approve company reports', 'create battalion announcements'
        ]);

        $companyCaptain = Role::findOrCreate('Company Captain');
        $companyCaptain->givePermissionTo([
            'register members', 'register company info', 'submit activity participation', 'generate company reports', 'create company announcements', 'view members', 'update members', 'participate in activities', 'view company announcements'
        ]);

        $companyOfficer = Role::findOrCreate('Company Officer');
        $companyOfficer->givePermissionTo([
            'view members', 'update members', 'participate in activities', 'view company announcements'
        ]);

        $member = Role::findOrCreate('Member');
        $member->givePermissionTo([
            'view own profile', 'view announcements', 'view activity participation history'
        ]);

        // Create Super Admin User
        $admin = User::firstOrCreate([
            'email' => 'superadmin@bgbr.rw',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
        ]);

        if (!$admin->hasRole('Super Admin')) {
            $admin->assignRole('Super Admin');
        }
    }
}
