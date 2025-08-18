<?php

declare(strict_types=1);

namespace Lakm\PersonName\Abbreviator\Strategies;

use Lakm\PersonName\Contracts\AbbreviatorContract;

class FirstInitialMiddleInitialLast extends AbbreviatorContract
{
    public function abbreviate(): string
    {
        $initials = $this->getInitials([$this->firstName, $this->middleName]);

        if ($this->lastName) {
            return $initials . ' ' . $this->lastName;
        }

        return $this->finalAbbreviation($initials);
    }
}
