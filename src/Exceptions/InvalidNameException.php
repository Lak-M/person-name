<?php

declare(strict_types=1);

namespace Lakm\PersonName\Exceptions;

use Exception;

final class InvalidNameException extends Exception
{
    public static function from(string $msg = 'Invalid name'): static
    {
        return new self($msg);
    }
}
