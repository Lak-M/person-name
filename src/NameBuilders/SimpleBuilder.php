<?php

declare(strict_types=1);

namespace Lakm\PersonName\NameBuilders;

class SimpleBuilder extends DefaultBuilder
{
    public static function fromFullName(string $fullName, bool $shouldSanitize = true): static
    {
        $parts = static::boot($fullName, $shouldSanitize);

        $collectedPrefixes = static::extractPrefixes($parts);
        $collectedSuffixes = static::extractSuffixes($parts);

        return new static(
            $parts[0],
            $parts[1] ?? null,
            $parts[2] ?? null,
            $collectedPrefixes,
            $collectedSuffixes,
        );
    }
}
