<?php

declare(strict_types=1);

namespace Lakm\PersonName\Abbreviator\Strategies;

use Lakm\PersonName\Contracts\AbbreviatorContract;

class FirstMiddleInitialLast extends AbbreviatorContract
{
    public function abbreviate(): string
    {
        if ( ! $this->middleName) {
            if ($this->lastName) {
                return $this->firstName . ' ' . $this->lastName;
            }
            return $this->firstName;
        }

        $middleInitials = $this->getInitials($this->middleName);

        return $this->firstName . ' ' . $middleInitials . ' ' . $this->lastName;
    }
}
