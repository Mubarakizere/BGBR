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
        Schema::table('reports', function (Blueprint $table) {
            $table->string('level')->change();
            $table->string('type')->after('level');
            $table->string('status')->default('draft')->after('file_path');
            $table->uuid('submitted_by')->nullable()->after('status');
            $table->uuid('approved_by')->nullable()->after('submitted_by');
            $table->text('reviewer_notes')->nullable()->after('approved_by');

            $table->foreign('submitted_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['submitted_by']);
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['type', 'status', 'submitted_by', 'approved_by', 'reviewer_notes']);
        });
    }
};
