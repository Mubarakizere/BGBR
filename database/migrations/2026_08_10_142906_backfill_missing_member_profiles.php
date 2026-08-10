<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Find all users who don't have a Member profile
        $users = \App\Models\User::whereDoesntHave('member')->get();
        
        foreach ($users as $user) {
            // Only backfill for users who aren't super admins
            if (!$user->hasRole('Super Admin')) {
                \App\Models\Member::create([
                    'name' => $user->name,
                    'rank' => 'Member',
                    'user_id' => $user->id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse operation needed for a data backfill
    }
};
