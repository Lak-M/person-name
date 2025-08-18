<?php

declare(strict_types=1);

namespace Lakm\PersonName\Enums;

enum Abbreviate: int
{
    case FirstInitial_LastName = 1;
    case FirstInitial_MiddleInitial_LastName = 2;
    case FirstName_LastInitial = 3;
    case FirstName_MiddleInitial_LastName = 4;
    case Initials = 5;
}
