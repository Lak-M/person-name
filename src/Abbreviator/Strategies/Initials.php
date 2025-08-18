<?php

declare(strict_types=1);

namespace Lakm\PersonName\Abbreviator\Strategies;

use Lakm\PersonName\Contracts\AbbreviatorContract;

class Initials extends AbbreviatorContract
{
    public function abbreviate(): string
    {
        return $this->finalAbbreviation($this->getInitials($this->values()));
    }
}
