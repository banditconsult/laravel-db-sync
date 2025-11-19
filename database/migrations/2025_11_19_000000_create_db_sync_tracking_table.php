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
        Schema::create('db_sync_tracking', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Which database connection this tracking record belongs to
            $table->string('connection');
            
            // The table that was synced
            $table->string('table_name');
            
            // The sync direction (down, up, bidirectional)
            $table->string('direction')->default('down');
            
            // When this table was last successfully synced
            $table->timestamp('last_synced_at')->nullable();
            
            // When the sync started (for ongoing syncs)
            $table->timestamp('sync_started_at')->nullable();
            
            // Sync metadata: stats, conflicts count, rows affected, etc
            $table->json('metadata')->nullable();
            
            // Status: pending, syncing, completed, failed
            $table->string('status')->default('pending');
            
            // Error message if sync failed
            $table->text('error_message')->nullable();
            
            $table->timestamps();
            
            // Ensure we don't have duplicate tracking for same connection/table
            $table->unique(['connection', 'table_name']);
            
            // Indexes for common queries
            $table->index('status');
            $table->index('last_synced_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('db_sync_tracking');
    }
};
