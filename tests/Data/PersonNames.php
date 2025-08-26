<?php

declare(strict_types=1);


require_once __DIR__ . '/DefaultNameList.php';
require_once __DIR__ . '/LKNameList.php';
require_once __DIR__ . '/CNNameList.php';
require_once __DIR__ . '/RUNameList.php';

const PERSON_NAMES = [
    ...DEFAULT_PERSON_NAMES,
    ...LK_PERSON_NAMES,
    ...CN_PERSON_NAMES,
    ...RU_PERSON_NAMES,
];
