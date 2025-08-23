<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Country;
use Lakm\PersonName\NameBuilders\CN;
use Lakm\PersonName\NameBuilders\DefaultBuilder;

require_once __DIR__ . '/../../Data/CNNameList.php';

it('extends DefaultBuilderContract', function (): void {
    expect(CN::class)->toExtend(DefaultBuilder::class);
});

it('can create a person name from constructor', function (): void {
    $firstName = '小';
    $middleName = '龙';
    $lastName = '李';

    $pn = new CN($firstName, $middleName, $lastName);

    expect($pn->first())->toBe($firstName)
        ->and($pn->middle())->toBe($middleName)
        ->and($pn->last())->toBe($lastName);
});

it('can create a person name from full name', function (
    ?Country $country,
    string  $fullName,
    string  $firstName,
    ?string $middleName,
    ?string $lastName,
    ?string $prefix,
    ?string $suffix,
    array   $formats,
): void {
    $n1 = CN::fromFullName($fullName);

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

    expect($n1)->toBeInstanceOf(CN::class)
        ->and($n1->fullName())->toBe(preg_replace('/\s{2,}/', ' ', $fullName))
        ->and($n1->first())->toBe($firstName)
        ->and($n1->middle())->toBe($middleName)
        ->and($n1->last())->toBe($lastName)
        ->and($n1->prefix())->toBe($prefix);
})->with(CN_PERSON_NAMES);
