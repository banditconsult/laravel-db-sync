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
        Schema::create('db_sync_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type'); //sync,backup,restore
            $table->string('status');  // pending, running, completed, failed
            $table->string('from_connection');
            $table->string('to_connection');
            $table->json('tables');
            $table->string('conflict_strategy');
            $table->json('stats')->nullable(); // Records synced, conflicts, etc
            $table->text('error')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('db_sync_logs');
    }
};
