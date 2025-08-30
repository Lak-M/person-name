<?php

namespace Lakm\PersonName\Exceptions;

final class InvalidNameException extends \Exception
{
    public static function from(string $msg = 'Invalid name'): static
    {
        return new self($msg);
    }
}
