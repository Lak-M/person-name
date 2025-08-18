<?php

declare(strict_types=1);

namespace Lakm\PersonName\Abbreviator\Strategies;

use Lakm\PersonName\Contracts\AbbreviatorContract;

class FirstInitialLast extends AbbreviatorContract
{
    public function abbreviate(): string
    {
        $firstInitial = $this->getInitials($this->firstName);

        //        $separator = $this->withDot ? '. ' : ' ';

        if ($this->lastName) {
            return $firstInitial . ' ' . $this->lastName;
        }


        return $this->finalAbbreviation($firstInitial);
    }
}
