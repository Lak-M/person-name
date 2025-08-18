<?php

declare(strict_types=1);

namespace Lakm\PersonName\Abbreviator;

use Lakm\PersonName\Abbreviator\Strategies\FirstInitialLast;
use Lakm\PersonName\Abbreviator\Strategies\FirstInitialMiddleInitialLast;
use Lakm\PersonName\Abbreviator\Strategies\FirstLastInitial;
use Lakm\PersonName\Abbreviator\Strategies\FirstMiddleInitialLast;
use Lakm\PersonName\Abbreviator\Strategies\Initials;
use Lakm\PersonName\Enums\Abbreviate;

class Abbreviator
{
    public static function execute(
        string  $firstName,
        ?string $middleName = null,
        ?string $lastName = null,
        ?string $prefix = null,
        ?string $suffix = null,
        bool    $withDot = true,
        bool    $strict = false,
        bool    $removeParticles = false,
        Abbreviate $format = Abbreviate::FirstInitial_LastName,
    ): string {
        /** @var string[] */
        $args = func_get_args();

        unset($args['format']);

        return match ($format) {
            Abbreviate::FirstInitial_LastName =>  (new FirstInitialLast(...$args))->abbreviate(),
            Abbreviate::FirstInitial_MiddleInitial_LastName =>  (new FirstInitialMiddleInitialLast(...$args))->abbreviate(),
            Abbreviate::FirstName_LastInitial =>  (new FirstLastInitial(...$args))->abbreviate(),
            Abbreviate::FirstName_MiddleInitial_LastName =>  (new FirstMiddleInitialLast(...$args))->abbreviate(),
            Abbreviate::Initials =>  (new Initials(...$args))->abbreviate(),
        }

        ;
    }
}
