<?php

declare(strict_types=1);

namespace Lakm\PersonName\NameBuilders;

use InvalidArgumentException;
use Lakm\PersonName\Abbreviator\Abbreviator;
use Lakm\PersonName\Contracts\NameBuilderContract;
use Lakm\PersonName\Enums\Abbreviate;
use Lakm\PersonName\Enums\Country;

class DefaultBuilder extends NameBuilderContract
{
    public static function fromFullName(string $fullName, ?Country $country = null): static
    {
        static::$fullName = $fullName;

        static::sortParticles();

        $name = preg_replace('/\s+/', ' ', mb_trim($fullName));
        $name = preg_replace('/([("]).+?([)"])/', '', $name ?? '');
        $parts = array_filter(explode(' ', $name ?? ''), fn($p): bool => $p !== '');

        if (count($parts) === 0) {
            throw new InvalidArgumentException('Name must not be empty.');
        }

        // Remove prefixes
        $collectedPrefixes = [];
        while ($parts && in_array($parts[0], static::$commonPrefixes, true)) {
            $collectedPrefixes[] = array_shift($parts);
        }

        // Remove suffixes (including Roman numerals)
        $collectedSuffixes = [];
        while ($parts && (in_array(end($parts), static::$commonSuffixes, true) || in_array(end($parts), static::$romanNumerals))) {
            array_unshift($collectedSuffixes, array_pop($parts));
        }

        // First name
        /** @var string $firstName */
        $firstName = array_shift($parts);

        if ($collectedPrefixes) {
            sort($collectedPrefixes, SORT_STRING);
        }

        if ($collectedSuffixes) {
            sort($collectedSuffixes, SORT_STRING);
        }

        if (count($parts) === 0) {
            return new static(
                firstName: $firstName,
                prefix: $collectedPrefixes ? implode(' ', $collectedPrefixes) : null,
                suffix: $collectedSuffixes ? implode(' ', $collectedSuffixes) : null,
            );
        }

        // Last name construction
        $lastNameParts = [];
        $lastNameParts[] = array_pop($parts);
        while ($parts) {
            $matched = false;
            foreach (static::$sortedCommonParticles as $particle) {
                $words = explode(' ', $particle);
                $len = count($words);
                if (count($parts) >= $len && implode(' ', array_slice($parts, -$len)) === $particle) {
                    $lastNameParts = array_merge(array_slice($parts, -$len), $lastNameParts);
                    array_splice($parts, -$len);
                    $matched = true;
                    break;
                }
            }
            if ( ! $matched) {
                break;
            }
        }

        $lastName = implode(' ', $lastNameParts);
        $middleName = $parts ? implode(' ', $parts) : null;

        return new static(
            $firstName,
            $middleName,
            $lastName,
            $collectedPrefixes ? implode(' ', $collectedPrefixes) : null,
            $collectedSuffixes ? implode(' ', $collectedSuffixes) : null,
        );
    }

    public function sorted(): string
    {
        if ($this->last()) {
            // Format: LastName, FirstName MiddleName
            return $this->last() . ', ' . $this->first() . ($this->middle() ? ' ' . $this->middle() : '');
        }

        // No last name: FirstName + MiddleName
        return $this->first() . ($this->middle() ? ' ' . $this->middle() : '');
    }

    public function abbreviated(
        bool $includePrefix = false,
        bool $includeSuffix = false,
        bool $withDot = true,
        bool $strict = false,
        bool $removeParticles = false,
        Abbreviate $format = Abbreviate::Initials,
    ): string {
        return Abbreviator::execute(
            firstName: $this->first(),
            middleName: $this->middle(),
            lastName: $this->last(),
            prefix: $includePrefix ? $this->prefix() : null,
            suffix: $includeSuffix ? $this->suffix() : null,
            withDot: $withDot,
            strict: $strict,
            removeParticles: $removeParticles,
            format: $format,
        );
    }
}
