<?php

declare(strict_types=1);

namespace Lakm\PersonName\Contracts;

use Lakm\PersonName\Enums\Abbreviate;

abstract class NameBuilderContract
{
    /** @var array|string[] */
    public static array $commonPrefixes = ['Mr.', 'Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.', 'Rev.', 'Sir', 'Capt.', 'Col.', 'Gen.'];

    /** @var string[] */
    public static array $commonSuffixes = ['Jr.', 'Sr.', 'PhD'];

    /** @var string[] */
    public static array $commonParticles = ['de', 'la', 'van', 'von', 'le', 'du', 'di'];

    /** @var string[] */
    public static array $romanNumerals = ['I', 'II', 'III', 'IV', 'V', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

    /** @var string[] */
    public static array $generationalSuffixes = ['Jr.', 'Sr.', 'II', 'III', 'IV', 'V'];

    /** @var string[] */
    public static array $sortedCommonParticles;

    protected static string $fullName;

    protected static string $sanitizedFullName;

    final public function __construct(
        private readonly string $firstName,
        private readonly ?string $middleName = null,
        private readonly ?string $lastName = null,
        private readonly ?string $prefix = null,
        private readonly ?string $suffix = null,
    ) {}

    abstract public static function fromFullName(string $fullName): static;

    abstract public function sorted(): string;

    abstract public function abbreviated(
        bool $includePrefix = false,
        bool $includeSuffix = false,
        bool $withDot = true,
        bool $strict = false,
        bool $removeParticles = false,
        Abbreviate $format = Abbreviate::Initials,
    ): string;

    abstract public function possessive(?string $name = null): string;

    public static function sortParticles(): void
    {
        if ( ! isset(static::$sortedCommonParticles)) {
            usort(self::$commonPrefixes, fn(string $a, string $b): int => mb_substr_count($b, ' ') <=> mb_substr_count($a, ' '));
            static::$sortedCommonParticles = self::$commonParticles;
        }
    }

    /**
     * @return string[]
     */
    public static function clear(string $name): array
    {
        // Normalize spaces
        $name = preg_replace('/\s+/', ' ', mb_trim($name));

        // Get non-empty parts
        return array_filter(explode(' ', $name ?? ''), fn($p): bool => $p !== '');
    }

    /**
     * @return string[]
     */
    public static function sanitize(string $name): array
    {
        // Normalize spaces
        $name = preg_replace('/\s+/', ' ', mb_trim($name));
        // Remove text between parentheses (...) or double quotes ""
        $name = preg_replace('/([("]).+?([)"])/', '', $name ?? '');

        // Get non-empty parts
        return array_filter(explode(' ', $name ?? ''), fn($p): bool => $p !== '');
    }

    public function first(): string
    {
        return $this->firstName;
    }

    public function mentionable(): string
    {
        return '@' . $this->firstName;
    }

    public function nick(int $length = 4): string
    {
        return mb_substr($this->firstName, 0, $length);
    }

    public function redated(int $length = 8, int $keep = 3, string $mask = '*'): string
    {
        if ($this->first() === '') {
            return str_repeat($mask, $length);
        }

        // Keep first letters
        $firstLetters = mb_substr($this->first(), 0, $keep);

        // Fill remaining to reach fixed length
        $remainingLength = max($length - mb_strlen($firstLetters), 0);
        $masked = str_repeat($mask, $remainingLength);

        return $firstLetters . $masked;
    }

    public function familiar(): ?string
    {
        return $this->first();
    }

    public function middle(): ?string
    {
        return $this->middleName;
    }

    public function last(): ?string
    {
        return $this->lastName;
    }

    public function family(): ?string
    {
        return $this->last();
    }

    public function surname(): ?string
    {
        return $this->last();
    }

    public function prefix(): ?string
    {
        return $this->prefix;
    }

    public function suffix(): ?string
    {
        return $this->suffix;
    }

    public function fullName(): string
    {
        if ( ! isset(static::$sanitizedFullName)) {
            $name = static::$fullName ?? $this->prefix . ' ' . $this->firstName . ' ' . $this->middleName . ' ' . $this->lastName . ' ' . $this->suffix;

            // We don't need to keep more than one space between name parts
            $name = preg_replace('/\s{2,}/', ' ', $name);

            return trim($name ?? '');
        }

        return static::$sanitizedFullName;
    }

    /**
     * @return array{firstName: string, middleName: ?string, lastName: ?string}
     */
    public function toArray(): array
    {
        return [
            'firstName' => $this->firstName,
            'middleName' => $this->middleName,
            'lastName' => $this->lastName,
        ];
    }

    /**
     * @param string[] $parts
     * @return string[]
     */
    protected static function getPrefixes(array &$parts): array
    {
        $collectedPrefixes = [];

        while ($parts && in_array($parts[0], static::$commonPrefixes, true)) {
            $collectedPrefixes[] = array_shift($parts);
        }

        sort($collectedPrefixes, SORT_STRING);

        return $collectedPrefixes;
    }

    /**
     * @param string[] $parts
     * @return string[]
     */
    protected static function getSuffixes(array &$parts): array
    {
        /** @var string[] $collectedSuffixes */
        $collectedSuffixes = [];

        while ($parts && (in_array(end($parts), static::$commonSuffixes, true) || in_array(end($parts), static::$romanNumerals))) {
            array_unshift($collectedSuffixes, array_pop($parts));
        }

        sort($collectedSuffixes, SORT_STRING);

        // For the sake of phpstan, we ensure that the suffixes are strings
        return array_filter($collectedSuffixes, fn($v) => is_string($v));
    }
}
