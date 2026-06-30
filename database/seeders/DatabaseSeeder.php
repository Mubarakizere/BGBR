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
            'manage denominations', 'create battalions', 'view all reports', 'manage system settings', 'view audit logs', 'manage users',
            'manage battalions', 'approve battalion reports', 'create denomination announcements', 'approve announcements',
            'manage companies', 'approve company reports', 'create battalion announcements',
            'register members', 'register company info', 'submit activity participation', 'generate company reports', 'create company announcements',
            'view members', 'update members', 'participate in activities', 'view company announcements',
            'view own profile', 'view announcements', 'view activity participation history',
            'manage activities',
            'manage website',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Roles
        $superAdmin = Role::findOrCreate('Super Admin');
        $superAdmin->givePermissionTo(Permission::all());

        $denominationAdmin = Role::findOrCreate('Denomination Admin');
        $denominationAdmin->givePermissionTo([
            'manage battalions', 'approve battalion reports', 'create denomination announcements', 'view all reports', 'manage users'
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
            'view members', 'update members', 'participate in activities', 'view company announcements', 'submit activity participation'
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

        // Seed default website content (public site pages & FAQs)
        $this->call(WebsiteContentSeeder::class);
    }
}
