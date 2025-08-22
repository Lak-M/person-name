<?php

declare(strict_types=1);

use Lakm\PersonName\Abbreviator\Strategies\FirstInitialLast;
use Lakm\PersonName\Abbreviator\Strategies\Initials;
use Lakm\PersonName\Contracts\AbbreviatorContract;
use Lakm\PersonName\Enums\Abbreviate;
use Lakm\PersonName\Enums\Country;

require_once __DIR__ . '/../../../Data/DefaultNameList.php';

it('extends AbbreviatorContract', function (): void {
    expect(Initials::class)->toExtend(AbbreviatorContract::class);
});

it('can abbreviate a name in FirstInitialLast format', function (
    ?Country $country,
    string  $fullName,
    string  $firstName,
    ?string $middleName,
    ?string $lastName,
    ?string $prefix,
    ?string $suffix,
    array   $formats,
): void {
    $abbreviator = new FirstInitialLast(
        firstName: $firstName,
        middleName: $middleName,
        lastName: $lastName,
        strict: true,
    );
    expect($abbreviator->abbreviate())->toBe($formats['abbreviate'][Abbreviate::FirstInitial_LastName->value]);
})->with(DEFAULT_PERSON_NAMES);
