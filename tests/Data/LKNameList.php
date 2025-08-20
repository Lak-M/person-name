<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Abbreviate;

const LK_PERSON_NAMES = [
    'LK1' => [
        "fullName" => "Sanjeewa Perera",
        "firstName" => "Sanjeewa",
        "middleName" => null,
        "lastName" => "Perera",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Perera, Sanjeewa",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "S. Perera",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "S. Perera",
                Abbreviate::FirstName_LastInitial->value => "Sanjeewa P.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Sanjeewa Perera",
                Abbreviate::Initials->value => "SP",
            ],
        ],
    ],
    'LK2' => [
        "fullName" => "Chathurika Sandamali Fernando",
        "firstName" => "Chathurika",
        "middleName" => "Sandamali",
        "lastName" => "Fernando",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Fernando, Chathurika Sandamali",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "C. Fernando",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "C. S. Fernando",
                Abbreviate::FirstName_LastInitial->value => "Chathurika F.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Chathurika S. Fernando",
                Abbreviate::Initials->value => "CSF",
            ],
        ],
    ],
    'LK3' => [
        "fullName" => "Amal Prasanna De Silva",
        "firstName" => "Amal",
        "middleName" => "Prasanna",
        "lastName" => "De Silva",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "De Silva, Amal Prasanna",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "A. De Silva",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "A. P. De Silva",
                Abbreviate::FirstName_LastInitial->value => "Amal D.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Amal P. De Silva",
                Abbreviate::Initials->value => "APD",
            ],
        ],
    ],
    'LK4' => [
        "fullName" => "Ruwan Kumara Wickramasinghe",
        "firstName" => "Ruwan",
        "middleName" => "Kumara",
        "lastName" => "Wickramasinghe",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Wickramasinghe, Ruwan Kumara",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "R. Wickramasinghe",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "R. K. Wickramasinghe",
                Abbreviate::FirstName_LastInitial->value => "Ruwan W.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Ruwan K. Wickramasinghe",
                Abbreviate::Initials->value => "RKW",
            ],
        ],
    ],
    'LK5' => [
        "fullName" => "Dilani Lakmali Perera",
        "firstName" => "Dilani",
        "middleName" => "Lakmali",
        "lastName" => "Perera",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Perera, Dilani Lakmali",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "D. Perera",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "D. L. Perera",
                Abbreviate::FirstName_LastInitial->value => "Dilani P.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Dilani L. Perera",
                Abbreviate::Initials->value => "DLP",
            ],
        ],
    ],
    'LK6' => [
        "fullName" => "Ramesh De Alwis",
        "firstName" => "Ramesh",
        "middleName" => null,
        "lastName" => "De Alwis",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "De Alwis, Ramesh",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "R. De Alwis",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "R. De Alwis",
                Abbreviate::FirstName_LastInitial->value => "Ramesh D.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Ramesh De Alwis",
                Abbreviate::Initials->value => "RD",
            ],
        ],
    ],
];
