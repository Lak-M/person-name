<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Country;
use Lakm\PersonName\PersonName;

it('can create a person name from full name', function (
    ?Country $country,
    string $fullName,
    string $firstName,
    ?string $middleName,
    ?string $lastName,
    ?string $prefix,
    ?string $suffix,
    array $formats,
): void {

    $n = PersonName::fromFullName($fullName, $country);

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

    expect($n)->toBeInstanceOf(Lakm\PersonName\Contracts\NameBuilderContract::class)
        ->and($n->fullName())->toBe(preg_replace('/\s{2,}/', ' ', $fullName))
        ->and($n->first())->toBe($firstName)
        ->and($n->middle())->toBe($middleName)
        ->and($n->last())->toBe($lastName)
        ->and($n->prefix())->toBe($prefix)
        ->and($n->suffix())->toBe($suffix)
        ->and($n->sorted())->toBe($formats['sorted']);
})->with('personNames');

it('can extract honours from a full name', function (): void {
    $h1 = PersonName::fromFullName('Sir Dr. Hon. John davs')->honours();
    $h2 = PersonName::fromFullName('Mr. Hon. Dr. John davs')->honours();
    $h3 = PersonName::fromFullName('Mr. Hon. Dr. John davs PhD')->honours();

    $h4 = PersonName::fromFullName('Hon John davs')->honours();
    $h5 = PersonName::fromFullName('John davs PhD')->honours();

    expect($h1)->toBe(['Dr.', 'Hon.', 'Sir',])
        ->and($h2)->toBe(['Dr.', 'Hon.',])
        ->and($h3)->toBe(['Dr.', 'Hon.', 'PhD',])
        ->and($h4)->toBe(['Hon'])
        ->and($h5)->toBe(['PhD']);
});

it('can create a person name', function (): void {
    $firstName = 'david';
    $middleName = 'volt';
    $lastName = 'henry';

    $pn = new PersonName($firstName, $middleName, $lastName);

    expect($pn->firstName())->toBe($firstName)
        ->and($pn->middleName())->toBe($middleName)
        ->and($pn->lastName())->toBe($lastName);
    //        ->and($pn->country())->toBe($country);
})->skip();

it('can create a person name without a country', function (): void {
    $firstName = 'david';
    $middleName = 'volt';
    $lastName = 'henry';

    $pn = new PersonName($firstName, $middleName, $lastName);

    expect($pn->firstName())->toBe($firstName)
        ->and($pn->middleName())->toBe($middleName)
        ->and($pn->lastName())->toBe($lastName);
})->skip();
