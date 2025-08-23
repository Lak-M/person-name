<?php

declare(strict_types=1);

namespace Lakm\PersonName\NameBuilders;

use Override;

class LK extends DefaultBuilder
{
    #[Override]
    public static function fromFullName(string $fullName, bool $shouldSanitize = true): static
    {
        $parts = parent::boot($fullName, $shouldSanitize);

        $collectedPrefixes = static::extractPrefixes($parts);
        $collectedSuffixes = static::extractSuffixes($parts);

        $fName = null;
        $mName = null;
        $lName = null;

        foreach ($parts as $part) {
            foreach (static::getCommonParticleList() as $particle) {
                if ($particle === mb_strtolower($part)) {
                    $fullName = implode(' ', $parts);
                    $lName = mb_trim(mb_substr($fullName, (int) mb_strpos($fullName, $part)));

                    //First name + middle names
                    $parts = explode(' ', mb_trim(str_replace($lName, '', $fullName)));

                    $fName = array_shift($parts);

                    if (count($parts)) {
                        $mName = mb_trim(implode(' ', $parts));
                    }

                    return new static($fName, $mName, $lName, $collectedPrefixes, $collectedSuffixes);
                }
            }
        }

        if (count($parts) === 5) {
            $fName = $parts[2] . ' ' . $parts[3];
            $mName = $parts[4];
            $lName = $parts[0] . ' ' . $parts[1];
        }

        if (count($parts) === 4) {
            $fName = $parts[2];
            $mName = $parts[3];
            $lName = $parts[0] . ' ' . $parts[1];
        }

        if (count($parts) === 3) {
            $fName = $parts[0];
            $mName = $parts[1];
            $lName = $parts[2];
        }

        if (count($parts) === 2) {
            $fName = $parts[0];
            $lName = $parts[1];
        }

        return new static($fName ?? $parts[0], $mName, $lName, $collectedPrefixes, $collectedSuffixes);
    }
}
