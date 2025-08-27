<?php

declare(strict_types=1);

namespace Lakm\PersonName;

use Lakm\PersonName\Contracts\NameBuilderContract;
use Lakm\PersonName\Enums\Country;
use Lakm\PersonName\Enums\Ethnicity;
use Lakm\PersonName\NameBuilders\DefaultBuilder;
use UnexpectedValueException;

final readonly class PersonName
{
    /**
     * @param string $fullName
     * @param Country|null $country
     * When following option is true, the full name will be sanitized to remove extra spaces, braces, Quotes...
     * @param bool $shouldSanitize
     *
     * @return NameBuilderContract
     */
    public static function fromFullName(string $fullName, Country|Ethnicity|null $country = null, bool $shouldSanitize = true): NameBuilderContract
    {
        if ( ! $country) {
            return DefaultBuilder::fromFullName($fullName, $shouldSanitize);
        }

        $fqClassName = self::fqClassName($country);

        return $fqClassName::fromFullName($fullName, $shouldSanitize);
    }

    public static function build(
        string $firstName,
        string $middleName,
        string $lastName,
        ?string $suffix = null,
        ?string $prefix = null,
        Country|Ethnicity|null $country = null,
        bool $shouldSanitize = true,
    ): NameBuilderContract {
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
}
