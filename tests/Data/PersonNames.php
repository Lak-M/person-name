<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Country;

require_once __DIR__ . "/DefaultNameList.php";

const PERSON_NAMES = [
    ...DEFAULT_PERSON_NAMES,
    Country::SRI_LANKA->value => [
        'country' => Country::SRI_LANKA,
        'fullName' => 'Chriss sen tomas',
        'firstName' => 'Chriss',
        'middleName' => 'sen',
        'lastName' => 'tomas',
    ],
];
