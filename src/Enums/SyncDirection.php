<?php

namespace banditconsult\DbSync\Enums;

enum SyncDirection: string
{
    case Down = 'down';
    case Up = 'up';
    case Bidirectional = 'bidirectional';

    public function label(): string
    {
        return match ($this) {
            self::Down => 'Download (source → target)',
            self::Up => 'Upload (target → source)',
            self::Bidirectional => 'Bidirectional (both ways)',
        };
    }

    public function isBidirectional(): bool
    {
        return $this === self::Bidirectional;
    }
}
