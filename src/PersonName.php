<?php

declare(strict_types=1);

namespace Lakm\PersonName;

use Lakm\PersonName\Contracts\NameBuilderContract;
use Lakm\PersonName\Data\PersonNameStatus;
use Lakm\PersonName\Enums\Country;
use Lakm\PersonName\Enums\Ethnicity;
use Lakm\PersonName\Exceptions\InvalidNameException;
use Lakm\PersonName\NameBuilders\DefaultBuilder;
use UnexpectedValueException;

final readonly class PersonName
{
    /**
     * @param string $fullName
     * @param Country|Ethnicity|null $country
     * When following option is true, the full name will be sanitized to remove extra spaces, braces, Quotes...
     * @param bool $shouldSanitize
     *
     * @return NameBuilderContract
     * @throws InvalidNameException
     */
    public static function fromFullName(string $fullName, Country|Ethnicity|null $country = null, bool $shouldSanitize = true, bool $checkValidity = false): NameBuilderContract
    {
        if ($checkValidity) {
            self::throwInvalidException($fullName);
        }

        if ( ! $country) {
            return DefaultBuilder::fromFullName($fullName, $shouldSanitize);
        }

        $fqClassName = self::fqClassName($country);

        return $fqClassName::fromFullName($fullName, $shouldSanitize);
    }

    /**
     * @throws InvalidNameException
     */
    public static function build(
        string $firstName,
        ?string $middleName = null,
        ?string $lastName = null,
        ?string $suffix = null,
        ?string $prefix = null,
        Country|Ethnicity|null $country = null,
        bool $shouldSanitize = true,
        bool $checkValidity = false
    ): NameBuilderContract {
        if ($checkValidity) {
            foreach (array_filter([$firstName, $middleName, $lastName, $suffix, $prefix]) as $part) {
                self::throwInvalidException($part);
            }
        }

        $fqClassName = self::fqClassName($country);

        return new $fqClassName(
            $firstName,
            $middleName,
            $lastName,
            $prefix,
            $suffix,
            $shouldSanitize,
        );
    }

    /**
     * @param Country|Ethnicity|null $country
     * @return class-string<NameBuilderContract>
     */
    private static function fqClassName(Country|Ethnicity|null $country): string
    {
        if ( ! $country) {
            $fqClassName = DefaultBuilder::class;
        } else {
            $className = $country instanceof Country ? $country->code() : $country->name;

            /** @var class-string<NameBuilderContract> $fqClassName */
            $fqClassName = "Lakm\PersonName\NameBuilders" . '\\' . $className;

        }

        self::checkInstance($fqClassName);

        return $fqClassName;
    }

    /**
     * @param class-string $builder
     * @return void
     */
    private static function checkInstance(string $builder): void
    {
        if ( ! is_subclass_of($builder, NameBuilderContract::class)) {
            throw new UnexpectedValueException("Returned value is not a NameBuilderContract");
        }
    }

    public static function checkValidity(string $name): PersonNameStatus
    {
        // Allowed: letters (any script), diacritics, spaces, apostrophe, hyphen
        $pattern = '/^[\p{L}\p{M}\s\'\-]+$/u';

        if (preg_match($pattern, $name)) {
            return new PersonNameStatus(isValid: true);
        }

        // Find illegal characters
        preg_match_all('/[^\p{L}\p{M}\s\'\-]/u', $name, $matches);

        if ($matches[0]) {
           return new PersonNameStatus(
               isValid: false,
               illegalChars: array_unique($matches[0])
           );
        }

        return new PersonNameStatus(isValid: true);
    }

    /**
     * @throws InvalidNameException
     */
    private static function throwInvalidException(string $name): void
    {
        $validity = self::checkValidity($name);

        if (!$validity->isValid) {
            $illegalChars = $validity->illegalChars ? implode(', ', $validity->illegalChars) : "";

            throw new InvalidNameException(
                'Provided name is invalid. Found illegal characters ' . $illegalChars
                );
        }
    }
}
