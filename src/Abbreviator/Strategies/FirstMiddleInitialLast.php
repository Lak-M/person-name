<?php

declare(strict_types=1);

namespace Lakm\PersonName\Abbreviator\Strategies;

use Exception;
use Lakm\PersonName\Contracts\AbbreviatorContract;

class FirstMiddleInitialLast extends AbbreviatorContract
{
    /**
     * @throws Exception
     */
    public function abbreviate(): string
    {
        if ( ! $this->middleName) {
            if ($this->lastName) {
                return $this->firstName . ' ' . $this->lastName;
            }
            return $this->firstName;
        }

        $middleInitials = $this->getInitials($this->middleName);

        return $this->finalAbbreviation($this->firstName . ' ' . $middleInitials . ' ' . $this->lastName);
    }
}
