<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Ethnicity;
use Lakm\PersonName\NameBuilders\Arab;
use Lakm\PersonName\NameBuilders\DefaultBuilder;

require_once __DIR__ . '/../../Data/ArabNameList.php';

it('extends DefaultBuilder', function (): void {
    expect(Arab::class)->toExtend(DefaultBuilder::class);
});

it('can create a person name from constructor', function (): void {
    $firstName = 'Abu';
    $middleName = 'Abdullah Muhammad ibn';
    $lastName = 'Battuta al-Tanji';

    $pn = new Arab($firstName, $middleName, $lastName);

    expect($pn->first())->toBe($firstName)
        ->and($pn->middle())->toBe($middleName)
        ->and($pn->last())->toBe($lastName);
});

it('can create a person name from full name', function (
    Ethnicity  $country,
    string  $fullName,
    string  $firstName,
    ?string $middleName,
    ?string $lastName,
    ?string $kunya,
    ?string $ism,
    ?string $fatherName,
    ?string $grandfatherName,
    ?string $nasab,
    ?string $laqab,
    ?string $nisbah,
    ?string $familyName,
): void {
    $n1 = Arab::fromFullName($fullName);

    expect($n1)->toBeInstanceOf(Arab::class)
        ->and($n1->fullName())->toBe($fullName)
        ->and($n1->first())->toBe($firstName)
        ->and($n1->middle())->toBe($middleName)
        ->and($n1->last())->toBe($lastName)
        ->and($n1->kunya())->toBe($kunya)
        ->and($n1->ism())->toBe($ism)
        ->and($n1->fatherName() ? mb_strtolower($n1->fatherName()) : null)->toBe($fatherName ? mb_strtolower($fatherName) : null)
        ->and($n1->grandfatherName() ? mb_strtolower($n1->grandfatherName()) : null)->toBe($grandfatherName ? mb_strtolower($grandfatherName) : null)
        ->and($n1->nasab() ? mb_strtolower($n1->nasab()) : null)->toBe($nasab ? mb_strtolower($nasab) : null)
        ->and($n1->laqab() ? mb_strtolower($n1->laqab()) : null)->toBe($laqab ? mb_strtolower($laqab) : null)
        ->and($n1->nisbah() ? mb_strtolower($n1->nisbah()) : null)->toBe($nisbah ? mb_strtolower($nisbah) : null)
        ->and($n1->family())->toBe($familyName);

})->with(ARAB_PERSON_NAMES);
