<?php

namespace banditconsult\DbSync\Models;

use banditconsult\DbSync\Enums\SyncDirection;
use banditconsult\DbSync\Enums\SyncStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DbSyncTracking extends Model
{
    use HasUuids;

    protected $table = 'db_sync_tracking';

    protected $fillable = [
        'connection',
        'table_name',
        'direction',
        'last_synced_at',
        'sync_started_at',
        'metadata',
        'status',
        'error_message',
    ];

    protected $casts = [
        'direction' => SyncDirection::class,
        'status' => SyncStatus::class,
        'metadata' => 'json',
        'last_synced_at' => 'datetime',
        'sync_started_at' => 'datetime',
    ];

    /**
     * Scope to get failed syncs
     */
    public function scopeFailed($query)
    {
        return $query->where('status', SyncStatus::Failed);
    }

    /**
     * Scope to get active syncs
     */
    public function scopeActive($query)
    {
        return $query->where('status', SyncStatus::Syncing);
    }

    /**
     * Scope to get completed syncs
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', SyncStatus::Completed);
    }

    /**
     * Check if sync is in progress
     */
    public function isInProgress(): bool
    {
        return $this->status === SyncStatus::Syncing;
    }

    /**
     * Check if sync failed
     */
    public function hasFailed(): bool
    {
        return $this->status === SyncStatus::Failed;
    }

    /**
     * Check if sync is complete
     */
    public function isComplete(): bool
    {
        return $this->status === SyncStatus::Completed;
    }

    /**
     * Mark sync as started
     */
    public function markAsStarted(): void
    {
        $this->update([
            'status' => SyncStatus::Syncing,
            'sync_started_at' => now(),
            'error_message' => null,
        ]);
    }

    /**
     * Mark sync as completed with metadata
     */
    public function markAsCompleted(array $metadata = []): void
    {
        $this->update([
            'status' => SyncStatus::Completed,
            'last_synced_at' => now(),
            'sync_started_at' => null,
            'metadata' => $metadata,
            'error_message' => null,
        ]);
    }

    /**
     * Mark sync as failed with error message
     */
    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => SyncStatus::Failed,
            'sync_started_at' => null,
            'error_message' => $errorMessage,
        ]);
    }
}
