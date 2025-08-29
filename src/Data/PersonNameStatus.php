<?php

namespace Lakm\PersonName\Data;

final readonly class PersonNameStatus
{
    /**
     * @param bool $isValid
     * @param string[]|null $illegalChars
     */
    public function __construct(
        public readonly bool $isValid,
        public readonly ?array $illegalChars = null,
    )
    {
    }
}
