<?php

namespace banditconsult\DbSync\Models;

use banditconsult\DbSync\Enums\SyncDirection;
use banditconsult\DbSync\Enums\SyncStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DbSyncBackups extends Model
{
    use HasUuids;

    protected $table = 'db_sync_backups';

    protected $guarded = [];

    protected $cats = [
        'direction' => SyncDirection::class,
        'status' => SyncStatus::class,
        'metadata' => 'json',
        'last_synced_at' => 'datetime',
        'sync_started_at' => 'datetime',
    ];
}

