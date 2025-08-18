<?php

declare(strict_types=1);

namespace Lakm\PersonName\Abbreviator\Strategies;

use Lakm\PersonName\Contracts\AbbreviatorContract;

class FirstLastInitial extends AbbreviatorContract
{
    public function abbreviate(): string
    {
        if ( ! $this->lastName) {
            return $this->firstName;
        }

        $lastInitial = $this->getInitials($this->lastName);

        return $this->finalAbbreviation($this->firstName . ' ' . $lastInitial);
    }
}
