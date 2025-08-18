<?php

declare(strict_types=1);

use Lakm\PersonName\Abbreviator\Strategies\FirstInitialMiddleInitialLast;
use Lakm\PersonName\Enums\Abbreviate;

require_once __DIR__ . '/../../../Data/DefaultNameList.php';

it('extends AbbreviatorContract', function (): void {
    expect(FirstInitialMiddleInitialLast::class)->toExtend(Lakm\PersonName\Contracts\AbbreviatorContract::class);
});

it('can abbreviate a name in FirstInitialMiddleInitialLast format', function (
    string $fullName,
    string $firstName,
    ?string $middleName,
    ?string $lastName,
    ?string $prefix,
    ?string $suffix,
    array $formats,
): void {
    $abbreviator = new FirstInitialMiddleInitialLast(
        firstName: $firstName,
        middleName: $middleName,
        lastName: $lastName,
        strict: false,
    );
    expect($abbreviator->abbreviate())->toBe($formats['abbreviate'][Abbreviate::FirstInitial_MiddleInitial_LastName->value]);
})->with(DEFAULT_PERSON_NAMES);
