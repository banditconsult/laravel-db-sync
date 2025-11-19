<?php

namespace banditconsult\DbSync\Models;

use banditconsult\DbSync\Enums\SyncDirection;
use banditconsult\DbSync\Enums\SyncStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DbSyncLogs extends Model
{
    use HasUuids;

    protected $table = 'db_sync_logs';

    protected $guarded = [];

    protected $casts = [
        'direction' => SyncDirection::class,
        'status' => SyncStatus::class,
        'metadata' => 'json',
        'last_synced_at' => 'datetime',
        'sync_started_at' => 'datetime',
    ];

}
