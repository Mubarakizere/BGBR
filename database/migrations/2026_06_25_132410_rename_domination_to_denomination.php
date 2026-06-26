<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('dominations')) {
            // 1. Rename the dominations table
            Schema::rename('dominations', 'denominations');

            // 2. Rename domination_id column in battalions
            Schema::table('battalions', function (Blueprint $table) {
                $table->renameColumn('domination_id', 'denomination_id');
            });

            // 3. Rename domination_id column in users
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('domination_id', 'denomination_id');
            });

            // 4. Update enum values in announcements.visibility_level
            DB::table('announcements')
                ->where('visibility_level', 'domination')
                ->update(['visibility_level' => 'denomination']);

            // For MySQL, alter the enum column to include the new value
            if (config('database.default') === 'mysql') {
                DB::statement("ALTER TABLE announcements MODIFY visibility_level ENUM('national', 'denomination', 'battalion', 'company') NOT NULL");
            }

            // 5. Update enum values in activities.target_audience
            DB::table('activities')
                ->where('target_audience', 'domination')
                ->update(['target_audience' => 'denomination']);

            if (config('database.default') === 'mysql') {
                DB::statement("ALTER TABLE activities MODIFY target_audience ENUM('national', 'denomination', 'battalion', 'company') NOT NULL DEFAULT 'national'");
            }

            // 6. Update Spatie role name
            DB::table('roles')
                ->where('name', 'Domination Admin')
                ->update(['name' => 'Denomination Admin']);

            // 7. Update Spatie permission names
            DB::table('permissions')
                ->where('name', 'manage dominations')
                ->update(['name' => 'manage denominations']);

            DB::table('permissions')
                ->where('name', 'create domination announcements')
                ->update(['name' => 'create denomination announcements']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('denominations') && !Schema::hasTable('dominations')) {
            // Reverse permission names
            DB::table('permissions')
                ->where('name', 'create denomination announcements')
                ->update(['name' => 'create domination announcements']);

            DB::table('permissions')
                ->where('name', 'manage denominations')
                ->update(['name' => 'manage dominations']);

            // Reverse role name
            DB::table('roles')
                ->where('name', 'Denomination Admin')
                ->update(['name' => 'Domination Admin']);

            // Reverse enum values
            DB::table('activities')
                ->where('target_audience', 'denomination')
                ->update(['target_audience' => 'domination']);

            if (config('database.default') === 'mysql') {
                DB::statement("ALTER TABLE activities MODIFY target_audience ENUM('national', 'domination', 'battalion', 'company') NOT NULL DEFAULT 'national'");
            }

            DB::table('announcements')
                ->where('visibility_level', 'denomination')
                ->update(['visibility_level' => 'domination']);

            if (config('database.default') === 'mysql') {
                DB::statement("ALTER TABLE announcements MODIFY visibility_level ENUM('national', 'domination', 'battalion', 'company') NOT NULL");
            }

            // Reverse column renames
            if (Schema::hasColumn('users', 'denomination_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->renameColumn('denomination_id', 'domination_id');
                });
            }

            if (Schema::hasColumn('battalions', 'denomination_id')) {
                Schema::table('battalions', function (Blueprint $table) {
                    $table->renameColumn('denomination_id', 'domination_id');
                });
            }

            // Reverse table rename
            Schema::rename('denominations', 'dominations');
        }
    }
};
