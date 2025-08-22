<?php

declare(strict_types=1);


require_once __DIR__ . '/DefaultNameList.php';
require_once __DIR__ . '/LKNameList.php';

define("PERSON_NAMES", [
    ...DEFAULT_PERSON_NAMES,
    ...LK_PERSON_NAMES,
]);
