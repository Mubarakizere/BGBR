<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('created_by');
            $table->uuid('approved_by')->nullable()->after('is_approved');
            $table->timestamp('approved_at')->nullable()->after('approved_by');

            // Optionally add foreign key constraint if users table uses UUIDs
            // $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });

        // Add the new permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permission = Permission::firstOrCreate(['name' => 'approve announcements', 'guard_name' => 'web']);
        
        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo($permission);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['is_approved', 'approved_by', 'approved_at']);
        });

        // We don't remove the permission in down() generally, but you could if needed
    }
};
