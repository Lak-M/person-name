<?php

declare(strict_types=1);

use Lakm\PersonName\Enums\Abbreviate;
use Lakm\PersonName\Enums\Country;

const CN_PERSON_NAMES = [
    'CN1' => [
        "country" => Country::CHINA,
        "fullName" => "王伟",
        "firstName" => "伟",
        "middleName" => null,
        "lastName" => "王",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "王, 伟",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "W. 王",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "W. 王",
                Abbreviate::FirstName_LastInitial->value => "伟 W.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "伟 王",
                Abbreviate::Initials->value => "W",
            ],
        ],
    ],
    'CN2' => [
        "country" => Country::CHINA,
        "fullName" => "李小龙",
        "firstName" => "小",
        "middleName" => "龙",
        "lastName" => "李",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "李, 小龙",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "X. 李",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "X. L. 李",
                Abbreviate::FirstName_LastInitial->value => "小 L.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "小 龙 李",
                Abbreviate::Initials->value => "XL",
            ],
        ],
    ],
    'CN3' => [
        "country" => Country::CHINA,
        "fullName" => "习近平",
        "firstName" => "近",
        "middleName" => "平",
        "lastName" => "习",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "习, 近平",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "J. 习",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "J. P. 习",
                Abbreviate::FirstName_LastInitial->value => "近 习.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "近 平 习",
                Abbreviate::Initials->value => "JP",
            ],
        ],
    ],

    'CN4' => [
        "country" => Country::CHINA,
        "fullName" => "欧阳娜娜",
        "firstName" => "娜",
        "middleName" => "娜",
        "lastName" => "欧阳",
        "prefix" => null,
        "suffix" => null,
        "formats" => [
            "sorted" => "欧阳, 娜娜",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "N. 欧阳",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "N. N. 欧阳",
                Abbreviate::FirstName_LastInitial->value => "娜 欧.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "娜 娜 欧阳",
                Abbreviate::Initials->value => "NN",
            ],
        ],
    ],
    // With prefix 博士 (Dr.)
    'CN_5' => [
        "country" => Country::CHINA,
        "fullName" => "李小龙博士",
        "firstName" => "小",
        "middleName" => "龙",
        "lastName" => "李",
        "prefix" => "博士",
        "suffix" => null,
        "formats" => [
            "sorted" => "李, 小龙",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "X. 李",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "X. L. 李",
                Abbreviate::FirstName_LastInitial->value => "小 L.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "小 龙 李",
                Abbreviate::Initials->value => "XL",
            ],
        ],
    ],

    // With prefix 女士 (Ms.)
    'CN_6' => [
        "country" => Country::CHINA,
        "fullName" => "王芳女士",
        "firstName" => "芳",
        "middleName" => null,
        "lastName" => "王",
        "prefix" => "女士",
        "suffix" => null,
        "formats" => [
            "sorted" => "王, 芳",
            "abbreviate" => [
                Abbreviate::FirstInitial_LastName->value => "F. 王",
                Abbreviate::FirstInitial_MiddleInitial_LastName->value => "F. 王",
                Abbreviate::FirstName_LastInitial->value => "芳 W.",
                Abbreviate::FirstName_MiddleInitial_LastName->value => "芳 王",
                Abbreviate::Initials->value => "F",
            ],
        ],
    ],
];
