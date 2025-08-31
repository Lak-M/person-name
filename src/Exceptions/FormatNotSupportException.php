<?php

declare(strict_types=1);

namespace Lakm\PersonName\Exceptions;

use Exception;

final class FormatNotSupportException extends Exception
{
    public static function from(string $msg = 'Format not supported'): self
    {
        return new self($msg);
    }
}
