<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Country;
use Lakm\PersonName\PersonNameFactory;

it('can build a person name object from a full name', function (
    Country|null $country,
    string $fullName,
    string $firstName,
    string $middleName,
    string $lastName,
): void {

    PersonNameFactory::fromFullName($fullName, $country);
})->with('personNames');
