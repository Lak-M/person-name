<?php

declare(strict_types=1);

namespace Lakm\PersonName\Enums;

enum Country: string
{
    case SRI_LANKA = 'sri lanka';

    public function code(): string
    {
        return match ($this) {
            self::SRI_LANKA => 'LK',
        };
    }
}
