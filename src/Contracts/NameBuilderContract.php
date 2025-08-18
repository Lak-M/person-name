<?php

declare(strict_types=1);

namespace Lakm\PersonName\Contracts;

use Lakm\PersonName\Enums\Country;

abstract class NameBuilderContract
{
    /** @var array|string[] */
    public static array $commonPrefixes = ['Mr.', 'Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.'];

    /** @var array|string[] */
    public static array $commonSuffixes = ['Jr.', 'Sr.', 'PhD'];

    /** @var array|string[] */
    public static array $commonParticles = ['de', 'la', 'van', 'von', 'le', 'du', 'di'];

    /** @var array|string[] */
    public static array $romanNumerals = ['I', 'II', 'III', 'IV', 'V', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

    /** @var array|string[] */
    public static array $generationalSuffixes = ['Jr.', 'Sr.', 'II', 'III', 'IV', 'V'];

    /** @var array|string[] */
    public static array $sortedCommonParticles;

    protected static string $fullName;

    protected static string $sortedName;

    final public function __construct(
        private readonly string $firstName,
        private readonly ?string $middleName = null,
        private readonly ?string $lastName = null,
        private readonly ?string $prefix = null,
        private readonly ?string $suffix = null,
        private readonly ?Country $country = null,
    ) {}

    abstract public static function fromFullName(string $fullName, ?Country $country = null): static;

    abstract public function sorted(): string;

    public static function sortParticles(): void
    {
        if ( ! isset(static::$sortedCommonParticles)) {
            usort(self::$commonPrefixes, fn(string $a, string $b): int => mb_substr_count($b, ' ') <=> mb_substr_count($a, ' '));
            static::$sortedCommonParticles = self::$commonParticles;
        }
    }

    public function first(): string
    {
        return $this->firstName;
    }

    public function middle(): ?string
    {
        return $this->middleName;
    }

    public function last(): ?string
    {
        return $this->lastName;
    }

    public function country(): ?Country
    {
        return $this->country;
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
        if ( ! isset($this->fullName)) {
            return $this->prefix . $this->firstName . ' ' . $this->middleName . ' ' . $this->lastName . ' ' . $this->suffix;
        }

        return static::$fullName;
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
}
