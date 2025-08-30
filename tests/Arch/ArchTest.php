<?php

declare(strict_types=1);

use Lakm\PersonName\Contracts\AbbreviatorContract;
use Lakm\PersonName\Contracts\NameBuilderContract;


arch('globals')
    ->expect(['dd', 'dump', 'var_dump', 'print_r'])
    ->not->toBeUsed();

arch()
    ->expect('Lakm\PersonName\NameBuilders')
    ->toBeClasses()
    ->toExtend(NameBuilderContract::class);

arch()->expect('Lakm\PersonName\Enums')
    ->toBeEnums();

arch()->expect('Lakm\PersonName\Exceptions')
    ->toExtend(\Exception::class);

arch()->expect('Lakm\PersonName\Abbreviator\Strategies')
    ->toExtend(AbbreviatorContract::class);

