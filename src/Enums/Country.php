<?php

declare(strict_types=1);

namespace Lakm\PersonName\Enums;

enum Country: string
{
    case SRI_LANKA = 'sri lanka';
    case CHINA = 'china';
    case RUSSIA = 'russia';

    public function code(): string
    {
        return match ($this) {
            self::SRI_LANKA => 'LK',
            self::CHINA => 'CN',
            self::RUSSIA => 'RU',

        };
    }
}
