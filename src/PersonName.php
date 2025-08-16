<?php

declare(strict_types=1);

namespace Lakm\PersonName;

use Lakm\PersonName\Enums\Country;

final readonly class PersonName
{
    public function __construct(
        private string $firstName,
        private string $middleName,
        private string $lastName,
        private ?string $suffix = null,
        private ?string $prefix = null,
        private ?Country $country = null,
    ) {}

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function middleName(): string
    {
        return $this->middleName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function country(): ?Country
    {
        return $this->country;
    }
}
