<?php

declare(strict_types=1);

namespace Lakm\PersonName\Exceptions;

use Exception;

final class PartNotSupportException extends Exception
{
    public static function from(string $msg = 'Part not supported'): self
    {
        return new self($msg);
    }
}
