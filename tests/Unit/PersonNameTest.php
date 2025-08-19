<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Country;
use Lakm\PersonName\PersonName;

it('can create a person name', function (): void {
    $firstName = 'david';
    $middleName = 'volt';
    $lastName = 'henry';

    $pn = new PersonName($firstName, $middleName, $lastName);

    expect($pn->firstName())->toBe($firstName)
        ->and($pn->middleName())->toBe($middleName)
        ->and($pn->lastName())->toBe($lastName);
    //        ->and($pn->country())->toBe($country);
});

it('can create a person name without a country', function (): void {
    $firstName = 'david';
    $middleName = 'volt';
    $lastName = 'henry';

    $pn = new PersonName($firstName, $middleName, $lastName);

    expect($pn->firstName())->toBe($firstName)
        ->and($pn->middleName())->toBe($middleName)
        ->and($pn->lastName())->toBe($lastName);
});
