<?php

use Illuminate\Support\Str;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Connections
    |--------------------------------------------------------------------------
    */
    'connections' => [
        'source' => env('DB_SYNC_SOURCE', 'production'),
        'target' => env('DB_SYNC_TARGET', 'local'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sync Direction
    |--------------------------------------------------------------------------
    | Options: 'down' (source -> target), 'up' (target -> source), 
    |          'bidirectional' (both ways)
    */
    'direction' => env('DB_SYNC_DIRECTION', 'down'),

    /*
    |--------------------------------------------------------------------------
    | Conflict Resolution Strategy
    |--------------------------------------------------------------------------
    | Options: 'last-write-wins', 'production-wins', 'local-wins', 
    |          'source-wins', 'target-wins', 'manual'
    */
    'conflict_strategy' => env('DB_SYNC_CONFLICT_STRATEGY', 'last-write-wins'),

    /*
    |--------------------------------------------------------------------------
    | Tables Configuration
    |--------------------------------------------------------------------------
    */
    'tables' => [
        // Tables to always exclude
        'exclude' => [
            'migrations',
            'sessions',
            'cache',
            'jobs',
            'failed_jobs',
        ],
        
        // Specific tables to include (empty = all except excluded)
        'include' => [],
        
        // Per-table overrides
        'overrides' => [
            'users' => [
                'conflict_strategy' => 'production-wins',
                'sanitize' => ['password', 'remember_token'],
            ],
            'posts' => [
                'conflict_strategy' => 'last-write-wins',
                'handle_deletes' => true,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sync Tracking
    |--------------------------------------------------------------------------
    */
    'track_changes' => true,
    'track_table' => 'db_sync_tracking',

    /*
    |--------------------------------------------------------------------------
    | Backup Settings
    |--------------------------------------------------------------------------
    */
    'auto_backup' => true,
    'backup_before_sync' => true,
    'backup_retention_days' => 7,
    'backup_path' => storage_path('db-backups'),

    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    */
    'chunk_size' => 1000,
    'timeout' => 3600, // seconds

    /*
    |--------------------------------------------------------------------------
    | Scheduling (for real-time/periodic sync)
    |--------------------------------------------------------------------------
    */
    'schedule' => [
        'enabled' => false,
        'frequency' => 'hourly', // hourly, daily, weekly
        'time' => '02:00', // For daily/weekly syncs
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    */
    'require_confirmation' => true,
    'allowed_environments' => ['local', 'staging'],

    /*
    |--------------------------------------------------------------------------
    | Sanitization Rules
    |--------------------------------------------------------------------------
    | Define how to sanitize sensitive data when syncing to non-production
    */
    'sanitizers' => [
        'email' => fn($value) => 'user_' . uniqid() . '@example.com',
        'password' => fn() => bcrypt('password'),
        'remember_token' => fn() => null,
        'api_token' => fn() => Str::random(60),
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Settings
    |--------------------------------------------------------------------------
    */
    'ui' => [
        'enabled' => true,
        'route_prefix' => 'db-sync',
        'middleware' => ['web', 'auth'], // Add your auth middleware
    ],
];
