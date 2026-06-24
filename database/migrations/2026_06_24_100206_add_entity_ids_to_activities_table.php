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
        if (!Schema::hasColumn('activities', 'entity_ids')) {
            Schema::table('activities', function (Blueprint $table) {
                // Add new JSON array column for multiple entity targets
                $table->json('entity_ids')->nullable()->after('entity_id');
            });
        }

        // Migrate existing single entity_id values into entity_ids arrays
        DB::table('activities')
            ->whereNotNull('entity_id')
            ->orderBy('id')
            ->each(function ($activity) {
                DB::table('activities')
                    ->where('id', $activity->id)
                    ->update(['entity_ids' => json_encode([$activity->entity_id])]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('entity_ids');
        });
    }
};
