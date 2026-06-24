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
        if (!Schema::hasColumn('announcements', 'entity_ids')) {
            Schema::table('announcements', function (Blueprint $table) {
                // Add new JSON array column for multiple entity targets
                $table->json('entity_ids')->nullable()->after('entity_id');
            });
        }

        // Migrate existing single entity_id values into entity_ids arrays
        DB::table('announcements')
            ->whereNotNull('entity_id')
            ->orderBy('id')
            ->each(function ($announcement) {
                DB::table('announcements')
                    ->where('id', $announcement->id)
                    ->update(['entity_ids' => json_encode([$announcement->entity_id])]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('entity_ids');
        });
    }
};
