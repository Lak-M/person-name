<?php

namespace Lakm\PersonName\Exceptions;

class InvalidNameException extends \Exception
{
    public static function from(string $msg = 'Invalid name'): static
    {
        return new static($msg);
    }
}
