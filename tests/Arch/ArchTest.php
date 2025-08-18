<?php

declare(strict_types=1);

arch('globals')
    ->expect(['dd', 'dump', 'var_dump', 'print_r'])
    ->not->toBeUsed();
