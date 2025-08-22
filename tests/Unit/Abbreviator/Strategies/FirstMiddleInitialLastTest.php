<?php

declare(strict_types=1);

use Lakm\PersonName\Abbreviator\Strategies\FirstMiddleInitialLast;
use Lakm\PersonName\Contracts\AbbreviatorContract;
use Lakm\PersonName\Enums\Abbreviate;
use Lakm\PersonName\Enums\Country;

require_once __DIR__ . '/../../../Data/DefaultNameList.php';

it('extends AbbreviatorContract', function (): void {
    expect(FirstMiddleInitialLast::class)->toExtend(AbbreviatorContract::class);
});

it('can abbreviate a name in FirstInitialLast format', function (
    ?Country $country,
    string $fullName,
    string $firstName,
    ?string $middleName,
    ?string $lastName,
    ?string $prefix,
    ?string $suffix,
    array $formats,
): void {
    $abbreviator = new FirstMiddleInitialLast(
        firstName: $firstName,
        middleName: $middleName,
        lastName: $lastName,
        withDot: true,
        strict: false,
        removeParticles: true,
    );
    expect($abbreviator->abbreviate())->toBe($formats['abbreviate'][Abbreviate::FirstName_MiddleInitial_LastName->value]);
})->with(DEFAULT_PERSON_NAMES);
