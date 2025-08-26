<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Country;
use Lakm\PersonName\Enums\Gender;
use Lakm\PersonName\NameBuilders\RU;
use Lakm\PersonName\NameBuilders\SimpleBuilder;

require_once __DIR__ . '/../../Data/RUNameList.php';

it('extends SimpleBuilder', function (): void {
    expect(RU::class)->toExtend(SimpleBuilder::class);
});

it('can create a person name from constructor', function (): void {
    $firstName = 'Alexey';
    $middleName = 'Petrovich';
    $lastName = 'Volkov';

    $pn = new SimpleBuilder($firstName, $middleName, $lastName);

    expect($pn->first())->toBe($firstName)
        ->and($pn->middle())->toBe($middleName)
        ->and($pn->last())->toBe($lastName);
});

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
    $n1 = RU::fromFullName($fullName);

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

    expect($n1)->toBeInstanceOf(RU::class)
        ->and($n1->fullName())->toBe(preg_replace('/\s{2,}/', ' ', $fullName))
        ->and($n1->first())->toBe($firstName)
        ->and($n1->middle())->toBe($middleName)
        ->and($n1->last())->toBe($lastName)
        ->and($n1->prefix())->toBe($prefix);
})->with(RU_PERSON_NAMES);

it('can extract data from full name', function (
    string $fullName,
    Gender $gender,
    string $firstName,
    string $patronymic,
    string $fathersName,
    string $lastName,
) {
    $n1 = RU::fromFullName($fullName);

    expect($n1->gender())->toBe($gender)
        ->and($n1->first())->toBe($firstName)
        ->and($n1->patronymic())->toBe($patronymic)
        ->and($n1->fathersName())->toBe($fathersName)
        ->and($n1->last())->toBe($lastName);
})->with('names');

dataset('names', [
    [
        "fullName" => "Dmitry Sergeyevich Ivanov",
        "gender" => Gender::Male,
        "firstName" => "Dmitry",
        "patronymic" => "Sergeyevich",
        "fathersName" => "Sergey", // extracted from patronymic
        "lastName" => "Ivanov",
    ],

    [
        "fullName" => "Anna Sergeyevna Petrova",
        "gender" => Gender::Female,
        "firstName" => "Anna",
        "patronymic" => "Sergeyevna",
        "fathersName" => "Sergey",
        "lastName" => "Petrova",
    ],

    [
        "fullName" => "Sergey Ivanovich Smirnov",
        "gender" => Gender::Male,
        "firstName" => "Sergey",
        "patronymic" => "Ivanovich",
        "fathersName" => "Ivan",
        "lastName" => "Smirnov",
    ],

    [
        "fullName" => "Olga Dmitrievna Sokolova",
        "gender" => Gender::Female,
        "firstName" => "Olga",
        "patronymic" => "Dmitrievna",
        "fathersName" => "Dmitry",
        "lastName" => "Sokolova",
    ],

    [
        "fullName" => "Alexey Petrovich Volkov",
        "gender" => Gender::Male,
        "firstName" => "Alexey",
        "patronymic" => "Petrovich",
        "fathersName" => "Petr",
        "lastName" => "Volkov",
    ],

    [
        "fullName" => "Natalia Ivanovna Kuznetsova",
        "gender" => Gender::Female,
        "firstName" => "Natalia",
        "patronymic" => "Ivanovna",
        "fathersName" => "Ivan",
        "lastName" => "Kuznetsova",
    ],

    [
        "fullName" => "Mikhail Andreevich Orlov",
        "gender" => Gender::Male,
        "firstName" => "Mikhail",
        "patronymic" => "Andreevich",
        "fathersName" => "Andrei",
        "lastName" => "Orlov",
    ],

    [
        "fullName" => "Ekaterina Pavlovna Morozova",
        "gender" => Gender::Female,
        "firstName" => "Ekaterina",
        "patronymic" => "Pavlovna",
        "fathersName" => "Pavel",
        "lastName" => "Morozova",
    ],

    [
        "fullName" => "Vladimir Nikolaevich Popov",
        "gender" => Gender::Male,
        "firstName" => "Vladimir",
        "patronymic" => "Nikolaevich",
        "fathersName" => "Nikolai",
        "lastName" => "Popov",
    ],

    [
        "fullName" => "Irina Alexandrovna Fedorova",
        "gender" => Gender::Female,
        "firstName" => "Irina",
        "patronymic" => "Alexandrovna",
        "fathersName" => "Alexander",
        "lastName" => "Fedorova",
    ],

]);
