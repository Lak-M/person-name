<?php

declare(strict_types=1);

namespace Lakm\PersonName;

use Lakm\PersonName\Contracts\NameBuilderContract;
use Lakm\PersonName\Enums\Country;
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
    public static function fromFullName(string $fullName, ?Country $country = null, bool $shouldSanitize = true): NameBuilderContract
    {
        if ( ! $country) {
            return DefaultBuilder::fromFullName($fullName, $shouldSanitize);
        }

        $className = "Lakm\PersonName\NameBuilders" . '\\' . $country->code();

        $builder = $className::fromFullName($fullName, $shouldSanitize);

        if ( ! $builder instanceof NameBuilderContract) {
            throw new UnexpectedValueException("Returned value is not a NameBuilderContract");
        }

        return $builder;
    }
    public function build(
        string $firstName,
        string $middleName,
        string $lastName,
        ?string $suffix = null,
        ?string $prefix = null,
        ?Country $country = null,
    ): void {
        //        return new DefaultBuilder()
    }
}
