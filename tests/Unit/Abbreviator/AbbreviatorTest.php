<?php

declare(strict_types=1);

use Lakm\PersonName\Abbreviator\Abbreviator;
use Lakm\PersonName\Enums\Abbreviate;

require_once __DIR__ . '/../../Data/DefaultNameList.php';

beforeEach(function (): void {
    $this->name = [
        "fullName" => "Prof. Dr. Maria Anna de la Vega III PhD",
        "firstName" => "Maria",
        "middleName" => "Anna",
        "lastName" => "de la Vega",
        "prefix" => "Prof. Dr.",
        "suffix" => "III PhD",
        "formats" => [
            "sorted" => "de la Vega, Maria Anna",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "M. de la Vega",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "M. A. de la Vega",
                Abbreviate::FirstName_LastInitial->value => "Maria d. l. V.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Maria A. de la Vega",
                Abbreviate::Initials->value => "M. A. d. l. V.",
            ],
        ],
    ];
});

it('can abbreviate a name', function (): void {
    $name = DEFAULT_PERSON_NAMES['default1'];

    foreach (Abbreviate::cases() as $case) {
        $abb = Abbreviator::execute(
            firstName: $this->name['firstName'],
            middleName: $this->name['middleName'],
            lastName: $this->name['lastName'],
            format: $case,
        );
        expect($abb)->toBe($this->name['formats']['abbreviate'][$case->value]);
    }
});

it('can abbreviate a name without dots', function (): void {
    $name = DEFAULT_PERSON_NAMES['default1'];

    $abb = Abbreviator::execute(
        firstName: $this->name['firstName'],
        middleName: $this->name['middleName'],
        lastName: $this->name['lastName'],
        withDot: false,
        format: Abbreviate::Initials,
    );

    expect($abb)->toBe('MAdlV');
});

it('can abbreviate a name in strict mode', function (): void {
    /**
     * In strict mode name parts are considered a one
     * ex: if middle name van dora, it considered vandora as the middle name
     */
    $name = DEFAULT_PERSON_NAMES['default1'];

    $abb = Abbreviator::execute(
        firstName: $this->name['firstName'],
        middleName: $this->name['middleName'],
        lastName: $this->name['lastName'],
        strict: true,
        format: Abbreviate::Initials,
    );

    expect($abb)->toBe('M. A. d.');
});

it('can remove particles', function (): void {

    $name = DEFAULT_PERSON_NAMES['default1'];

    $abb = Abbreviator::execute(
        firstName: $this->name['firstName'],
        middleName: $this->name['middleName'],
        lastName: $this->name['lastName'],
        removeParticles: true,
        format: Abbreviate::Initials,
    );

    expect($abb)->toBe('M. A. V.');
});

it('can keep suffixes', function (): void {
    $name = "Prof. Dr. Maria Anna de la Vega IV III PhD";
    $firstName = "Maria";
    $middleName = "Anna";
    $lastName = "de la Vega";
    $prefix = "Prof. Dr.";
    $suffix = "III PhD";

    $abb = Abbreviator::execute(
        firstName: $firstName,
        middleName: $this->name['middleName'],
        lastName: $this->name['lastName'],
        suffix: $suffix,
        removeParticles: true,
        format: Abbreviate::Initials,
    );

    expect($abb)->toBe('M. A. V. III');
});

it('can keep prefixes', function (): void {
    $name = "Prof. Dr. Maria Anna de la Vega IV III PhD";
    $firstName = "Maria";
    $middleName = "Anna";
    $lastName = "de la Vega";
    $prefix = "Prof. Dr.";
    $suffix = "III PhD";

    $abb = Abbreviator::execute(
        firstName: $firstName,
        middleName: $this->name['middleName'],
        lastName: $this->name['lastName'],
        prefix: 'Dr.',
        removeParticles: true,
        format: Abbreviate::Initials,
    );
    expect($abb)->toBe('Dr. M. A. V.');
});
