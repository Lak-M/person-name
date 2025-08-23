<?php

declare(strict_types=1);

namespace Lakm\PersonName\NameBuilders;

use InvalidArgumentException;
use Lakm\PersonName\Abbreviator\Abbreviator;
use Lakm\PersonName\Contracts\NameBuilderContract;
use Lakm\PersonName\Enums\Abbreviate;

class DefaultBuilder extends NameBuilderContract
{
    /** @var string[]  */
    protected static array $prefixes = [];


    /** @var string[]  */
    protected static array $suffixes = [];


    /** @var string[]  */
    protected static array $honors = [];

    /**
     * @param string $fullName
     * @param bool $shouldSanitize
     * @return string[]
     */
    public static function boot(string $fullName, bool $shouldSanitize): array
    {
        static::$fullName = $fullName;

        $parts =  $shouldSanitize ? static::sanitize($fullName) : static::clear($fullName);

        if (count($parts) === 0) {
            throw new InvalidArgumentException('Name must not be empty.');
        }

        if (property_exists(static::class, 'prefixes')) {
            static::$commonPrefixes = array_merge(static::$prefixes, static::$commonPrefixes);
        }

        if (property_exists(static::class, 'suffixes')) {
            static::$commonSuffixes = array_merge(static::$suffixes, static::$commonSuffixes);
        }

        if (property_exists(static::class, 'honors')) {
            static::$commonHonors = array_merge(static::$honors, static::$commonHonors);
        }

        return $parts;
    }

    public static function fromFullName(string $fullName, bool $shouldSanitize = true): static
    {
        $parts = self::boot($fullName, $shouldSanitize);

        $collectedPrefixes = static::extractPrefixes($parts);
        $collectedSuffixes = static::extractSuffixes($parts);

        // First name
        /** @var string $firstName */
        $firstName = array_shift($parts);

        if (count($parts) === 0) {
            return new static(
                firstName: $firstName,
                prefix: $collectedPrefixes,
                suffix: $collectedSuffixes,
            );
        }

        $lastNameParts = [];
        $lastNameParts[] = array_pop($parts);

        // Last name construction by removing particles from the middle name
        while ($parts) {
            $matched = false;
            foreach (static::getCommonParticleList() as $particle) {
                $words = explode(' ', $particle);
                $len = count($words);
                if (count($parts) >= $len && mb_strtolower(implode(' ', array_slice($parts, -$len))) === $particle) {
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
            $collectedPrefixes,
            $collectedSuffixes,
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

    public function possessive(?string $name = null): string
    {
        if ( ! $name) {
            $name = $this->first();
        }

        if (str_ends_with($name, 's') || str_ends_with($name, 'S')) {
            return $name . "'";
        }

        return $name . "'s";
    }
}
