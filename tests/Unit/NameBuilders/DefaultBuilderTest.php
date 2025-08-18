<?php

declare(strict_types=1);

use Lakm\PersonName\Contracts\NameBuilderContract;
use Lakm\PersonName\NameBuilders\DefaultBuilder;

require_once __DIR__ . '/../../Data/DefaultNameList.php';

it('extends NameBuilderContract', function (): void {
    expect(DefaultBuilder::class)->toExtend(NameBuilderContract::class);
});

it('can create a person name from constructor', function (): void {
    $firstName = 'david';
    $middleName = 'volt';
    $lastName = 'henry';

    $pn = new DefaultBuilder($firstName, $middleName, $lastName);

    expect($pn->first())->toBe($firstName)
        ->and($pn->middle())->toBe($middleName)
        ->and($pn->last())->toBe($lastName);
});

it('can create a person name from full name', function (
    string $fullName,
    string $firstName,
    ?string $middleName,
    ?string $lastName,
    ?string $prefix,
    ?string $suffix,
    array $formats,
): void {
    $n1 = DefaultBuilder::fromFullName($fullName);

    if ($prefix) {
        $prefix = explode(' ', $prefix);
        sort($prefix, SORT_STRING);

        $prefix = implode(' ', $prefix);
    }

    if ($suffix) {
        $suffix = explode(' ', $suffix);
        sort($suffix, SORT_STRING);

        $suffix = implode(' ', $suffix);
    }

    expect($n1)->toBeInstanceOf(DefaultBuilder::class)
        ->and($n1->fullName())->toBe(preg_replace('/\s{2,}/', ' ', $fullName))
        ->and($n1->middle())->toBe($middleName)
        ->and($n1->last())->toBe($lastName)
        ->and($n1->prefix())->toBe($prefix)
        ->and($n1->suffix())->toBe($suffix)
        ->and($n1->sorted())->toBe($formats['sorted']);

})->with(DEFAULT_PERSON_NAMES);

it('can abbreviate a name', function () {
    expect(
        DefaultBuilder::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')
        ->abbreviated()
    )->toBe('M. A. d. l. V.');
});
