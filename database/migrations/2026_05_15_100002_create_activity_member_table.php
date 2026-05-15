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
        Schema::create('activity_member', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('activity_id');
            $table->uuid('member_id');
            $table->boolean('fee_paid')->default(false);
            $table->date('payment_date')->nullable();
            $table->boolean('eligible')->default(true);
            $table->text('eligibility_notes')->nullable();
            $table->uuid('registered_by');
            $table->timestamps();

            $table->unique(['activity_id', 'member_id']);

            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('registered_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_member');
    }
};
