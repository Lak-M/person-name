<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Country;

const DEFAULT_PERSON_NAMES = [
    'default1' => [
        "fullName" => "John Smith",
        "firstName" => "John",
        "middleName" => null,
        "lastName" => "Smith",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Smith, John",
        ],
    ],

    'default2' => [
        "fullName" => "Emily Rose Parker",
        "firstName" => "Emily",
        "middleName" => "Rose",
        "lastName" => "Parker",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Parker, Emily Rose",
        ],
    ],

    'default3' => [
        "fullName" => "James Robert William Davis",
        "firstName" => "James",
        "middleName" => "Robert William",
        "lastName" => "Davis",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Davis, James Robert William",
        ],
    ],

    'default4' => [
        "fullName" => "Sarah Connor-Smith",
        "firstName" => "Sarah",
        "middleName" => null,
        "lastName" => "Connor-Smith",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Connor-Smith, Sarah",
        ],
    ],

    'default5' => [
        "fullName" => "Jean-Luc Picard",
        "firstName" => "Jean-Luc",
        "middleName" => null,
        "lastName" => "Picard",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Picard, Jean-Luc",
        ],
    ],

    'default6' => [
        "fullName" => "Dr. John Smith",
        "firstName" => "John",
        "middleName" => null,
        "lastName" => "Smith",
        "prefix" => "Dr.",
        "suffix" => null,
        "formats" => [
            "sorted" => "Smith, John",
        ],
    ],

    'default7' => [
        "fullName" => "John Smith Jr.",
        "firstName" => "John",
        "middleName" => null,
        "lastName" => "Smith",
        "prefix" => null,
        "suffix" => "Jr.",
        "formats" => [
            "sorted" => "Smith, John",
        ],
    ],

    'default8' => [
        "fullName" => "William Johnson III",
        "firstName" => "William",
        "middleName" => null,
        "lastName" => "Johnson",
        "prefix" => null,
        "suffix" => "III",
        "formats" => [
            "sorted" => "Johnson, William",
        ],
    ],

    'default9' => [
        "fullName" => "Ludwig van Beethoven",
        "firstName" => "Ludwig",
        "middleName" => null,
        "lastName" => "van Beethoven",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "van Beethoven, Ludwig",
        ],
    ],

    'default10' => [
        "fullName" => "Maria de la Cruz",
        "firstName" => "Maria",
        "middleName" => null,
        "lastName" => "de la Cruz",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "de la Cruz, Maria",
        ],
    ],

    'default11' => [
        "fullName" => "Richard \"Rick\" Johnson",
        "firstName" => "Richard",
        "middleName" => null,
        "lastName" => "Johnson",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Johnson, Richard",
        ],
    ],

    'default12' => [
        "fullName" => "William (Bill) Thompson",
        "firstName" => "William",
        "middleName" => null,
        "lastName" => "Thompson",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Thompson, William",
        ],
    ],

    'default13' => [
        "fullName" => "Madonna",
        "firstName" => "Madonna",
        "middleName" => null,
        "lastName" => null,
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "Madonna",
        ],
    ],

    'default14' => [
        "fullName" => "Prof. Dr. Maria Anna de la Vega III PhD",
        "firstName" => "Maria",
        "middleName" => "Anna",
        "lastName" => "de la Vega",
        "prefix" => "Dr. Prof.",
        "suffix" => "III PhD",
        "formats" => [
            "sorted" => "de la Vega, Maria Anna",
        ],
    ],
];


const PERSON_NAMES = [
    ...DEFAULT_PERSON_NAMES,
    Country::Spain->value => [
        'country' => Country::Spain,
        'fullName' => 'Chriss sen tomas',
        'firstName' => 'Chriss',
        'middleName' => 'sen',
        'lastName' => 'tomas',
    ],
];
