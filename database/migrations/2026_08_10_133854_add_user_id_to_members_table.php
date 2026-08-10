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
        Schema::table('members', function (Blueprint $table) {
            $table->uuid('user_id')->nullable()->after('id');
            // We don't add foreign constraint immediately to avoid issues with existing data,
            // but ideally we could: $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // Backfill existing members
        $members = DB::table('members')->get();
        foreach ($members as $member) {
            $user = DB::table('users')
                ->where('name', $member->name)
                ->where('company_id', $member->company_id)
                ->first();
            
            if ($user) {
                DB::table('members')
                    ->where('id', $member->id)
                    ->update(['user_id' => $user->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
