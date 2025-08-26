<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Abbreviate;
use Lakm\PersonName\Enums\Country;

const RU_PERSON_NAMES = [
    'ru1' => [
        "country" => Country::RUSSIA,
        "fullName" => "Dmitry Sergeyevich Ivanov",
        "firstName" => "Dmitry",
        "middleName" => "Sergeyevich",
        "lastName" => "Ivanov",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Ivanov, Dmitry Sergeyevich",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "D. Ivanov",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "D. S. Ivanov",
                Abbreviate::FirstName_LastInitial->value => "Dmitry I.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Dmitry S. Ivanov",
                Abbreviate::Initials->value => "DSI",
            ],
        ],
    ],

    'ru2' => [
        "country" => Country::RUSSIA,
        "fullName" => "Anna Sergeyevna Petrova",
        "firstName" => "Anna",
        "middleName" => "Sergeyevna",
        "lastName" => "Petrova",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Petrova, Anna Sergeyevna",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "A. Petrova",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "A. S. Petrova",
                Abbreviate::FirstName_LastInitial->value => "Anna P.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Anna S. Petrova",
                Abbreviate::Initials->value => "ASP",
            ],
        ],
    ],

    'ru3' => [
        "country" => Country::RUSSIA,
        "fullName" => "Sergey Ivanovich Smirnov",
        "firstName" => "Sergey",
        "middleName" => "Ivanovich",
        "lastName" => "Smirnov",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Smirnov, Sergey Ivanovich",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "S. Smirnov",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "S. I. Smirnov",
                Abbreviate::FirstName_LastInitial->value => "Sergey S.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Sergey I. Smirnov",
                Abbreviate::Initials->value => "SIS",
            ],
        ],
    ],

    'ru4' => [
        "country" => Country::RUSSIA,
        "fullName" => "Olga Dmitrievna Sokolova",
        "firstName" => "Olga",
        "middleName" => "Dmitrievna",
        "lastName" => "Sokolova",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Sokolova, Olga Dmitrievna",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "O. Sokolova",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "O. D. Sokolova",
                Abbreviate::FirstName_LastInitial->value => "Olga S.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Olga D. Sokolova",
                Abbreviate::Initials->value => "ODS",
            ],
        ],
    ],

    'ru5' => [
        "country" => Country::RUSSIA,
        "fullName" => "Alexey Petrovich Volkov",
        "firstName" => "Alexey",
        "middleName" => "Petrovich",
        "lastName" => "Volkov",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Volkov, Alexey Petrovich",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "A. Volkov",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "A. P. Volkov",
                Abbreviate::FirstName_LastInitial->value => "Alexey V.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "Alexey P. Volkov",
                Abbreviate::Initials->value => "APV",
            ],
        ],
    ],
];
