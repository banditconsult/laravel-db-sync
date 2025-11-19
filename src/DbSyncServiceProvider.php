<?php

namespace BanditConsult\DbSync;

use Illuminate\Support\ServiceProvider;

class DbSyncServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__.'/../config/db-sync.php', 'db-sync');
    }

    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/db-sync.php' => config_path('db-sync.php'),
        ], 'db-sync-config');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'db-sync');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\SyncCommand::class,
                Commands\BackupCommand::class,
            ]);
        }
    }
}