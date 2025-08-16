<?php

declare(strict_types=1);

namespace Lakm\PersonName\Enums;

enum Country: string
{
    case Spain = 'Spain';

    public function code(): string
    {
        return match ($this) {
            self::Spain => 'ES',
        };
    }
}
