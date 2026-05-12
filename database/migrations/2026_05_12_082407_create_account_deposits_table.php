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
        Schema::create('account_deposits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('amount', 12, 2);
            $table->enum('level', ['battalion', 'national']);
            $table->uuid('entity_id');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_deposits');
    }
};
