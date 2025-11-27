<?php

namespace banditconsult\DbSync\Enums;

enum SyncStatus: string
{
    case Pending = 'pending';
    case Syncing = 'syncing';
    case Completed = 'completed';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Syncing => 'Syncing...',
            self::Completed => 'Completed',
            self::Failed => 'Failed',
        };
    }

    public function isActive(): bool
    {
        return $this === self::Syncing;
    }

    public function isTerminal(): bool
    {
        return $this === self::Completed || $this === self::Failed;
    }
}
