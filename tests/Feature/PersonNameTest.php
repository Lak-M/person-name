<?php

declare(strict_types=1);

use Lakm\PersonName\Contracts\NameBuilderContract;
use Lakm\PersonName\Data\PersonNameStatus;
use Lakm\PersonName\Enums\Country;
use Lakm\PersonName\Enums\Ethnicity;
use Lakm\PersonName\Exceptions\InvalidNameException;
use Lakm\PersonName\NameBuilders\Arab;
use Lakm\PersonName\NameBuilders\DefaultBuilder;
use Lakm\PersonName\NameBuilders\RU;
use Lakm\PersonName\PersonName;

it('can create a person name from full name', function (
    ?Country $country,
    string   $fullName,
    string   $firstName,
    ?string  $middleName,
    ?string  $lastName,
    ?string  $prefix,
    ?string  $suffix,
    array    $formats,
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

    expect($n)->toBeInstanceOf(NameBuilderContract::class)
        ->and($n->fullName())->toBe(preg_replace('/\s{2,}/', ' ', $fullName))
        ->and($n->first())->toBe($firstName)
        ->and($n->middle())->toBe($middleName)
        ->and($n->last())->toBe($lastName)
        ->and($n->prefix())->toBe($prefix);

    if ($country !== Country::CHINA) {
        expect($n->suffix())->toBe($suffix)
            ->and($n->sorted())->toBe($formats['sorted']);
    }
})->with('personNames');

it('can create a person name from full name with ethnicity', function (): void {
    $n = PersonName::fromFullName('Abu Abdullah Muhammad ibn Battuta al-Tanji', Ethnicity::Arab);

    expect($n)->toBeInstanceOf(Arab::class)
        ->and($n->first())->toBe('Abu')
        ->and($n->middle())->toBe('Abdullah Muhammad ibn')
        ->and($n->last())->toBe('Battuta al-Tanji');
});

it('can extract honours from a full name', function (): void {
    $n1 = PersonName::fromFullName('Sir Dr. Hon. John davs')->honours();
    $n2 = PersonName::fromFullName('Mr. Hon. Dr. John davs')->honours();
    $n3 = PersonName::fromFullName('Mr. Hon. Dr. John davs PhD')->honours();

    $n4 = PersonName::fromFullName('Hon John davs')->honours();
    $n5 = PersonName::fromFullName('John davs PhD')->honours();

    expect($n1)->toBe(['Dr.', 'Hon.', 'Sir',])
        ->and($n2)->toBe(['Dr.', 'Hon.',])
        ->and($n3)->toBe(['Dr.', 'Hon.', 'PhD',])
        ->and($n4)->toBe(['Hon'])
        ->and($n5)->toBe(['PhD']);
});

it('can create a person name', function (): void {
    $firstName = 'david';
    $middleName = 'volt';
    $lastName = 'henry';

    $pn = PersonName::build($firstName, $middleName, $lastName);

    expect($pn)->toBeInstanceOf(DefaultBuilder::class)
        ->and($pn->first())->toBe($firstName)
        ->and($pn->middle())->toBe($middleName)
        ->and($pn->last())->toBe($lastName);
});

it('can create a sanitizes person name', function (): void {
    $firstName = 'dimitry (d)';
    $middleName = 'volt  m';
    $lastName = '(h) henry';

    $pn = PersonName::build(
        firstName: $firstName,
        middleName: $middleName,
        lastName: $lastName,
        country: Country::RUSSIA,
        shouldSanitize: true,
    );

    expect($pn)->toBeInstanceOf(RU::class)
        ->and($pn->first())->toBe('dimitry')
        ->and($pn->middle())->toBe('volt m')
        ->and($pn->last())->toBe('henry');
});

it('can detect valid names', function (string $name, array $expected): void {
    $validity = PersonName::checkValidity($name);

    expect($validity)->toBeInstanceOf(PersonNameStatus::class)
        ->and($validity->isValid)->toBeFalse()
        ->and($validity->illegalChars)->toMatchArray($expected);
})->with([
    ['name' => 'david@', 'expected' => ['@']],
    ['name' => '#david@', 'expected' => ['#', '@']],
    ['name' => '"david', 'expected' => ['"']],
    ['name' => "?david", 'expected' => ['?']],
]);

it('throws exception for illegal names', function (): void {
    expect(fn() => PersonName::fromFullName(fullName: '@david', checkValidity: true))->toThrow(InvalidNameException::class)
        ->and(fn() => PersonName::fromFullName(fullName: '@david'))->not()->toThrow(InvalidNameException::class)
        ->and(fn() => PersonName::fromFullName(fullName: 'david', checkValidity: true))->not()->toThrow(InvalidNameException::class)
        ->and(fn() => PersonName::fromFullName(fullName: 'david'))->not()->toThrow(InvalidNameException::class)
        ->and(fn() => PersonName::build(firstName: 'david@', checkValidity: true))->toThrow(InvalidNameException::class)
        ->and(fn() => PersonName::build(firstName: 'david@'))->not()->toThrow(InvalidNameException::class)
        ->and(fn() => PersonName::build(firstName: 'david'))->not()->toThrow(InvalidNameException::class)
        ->and(fn() => PersonName::build(firstName: 'david', checkValidity: true))->not()->toThrow(InvalidNameException::class);
});
