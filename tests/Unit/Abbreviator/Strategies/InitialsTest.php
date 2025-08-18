<?php

declare(strict_types=1);

use Lakm\PersonName\Abbreviator\Strategies\Initials;
use Lakm\PersonName\Contracts\AbbreviatorContract;
use Lakm\PersonName\Enums\Abbreviate;

require_once __DIR__ . '/../../../Data/DefaultNameList.php';

it('extends AbbreviatorContract', function (): void {
    expect(Initials::class)->toExtend(AbbreviatorContract::class);
});

it('can abbreviate a name in initials format', function (
    string $fullName,
    string $firstName,
    ?string $middleName,
    ?string $lastName,
    ?string $prefix,
    ?string $suffix,
    array $formats,
): void {
    $initialAbbreviator = new Initials(
        firstName: $firstName,
        middleName: $middleName,
        lastName: $lastName,
        withDot: false,
    );
    expect($initialAbbreviator->abbreviate())->toBe($formats['abbreviate'][Abbreviate::Initials->value]);
})->with(DEFAULT_PERSON_NAMES);
