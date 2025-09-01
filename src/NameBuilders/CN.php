<?php

declare(strict_types=1);

namespace Lakm\PersonName\NameBuilders;

use Lakm\PersonName\Enums\Abbreviate;
use Lakm\PersonName\Exceptions\FormatNotSupportException;
use Lakm\PersonName\Exceptions\InvalidNameException;
use Lakm\PersonName\Exceptions\PartNotSupportException;
use Override;

class CN extends DefaultBuilder
{
    /**
     * List of common two-character Chinese family names
     *
     * @var string[]
     */
    public static array $doubleSurnames = [
        "欧阳","司马","诸葛","上官","东方","夏侯","皇甫","尉迟",
        "公孙","长孙","宇文","司徒","司空","令狐","慕容","钟离",
        "闾丘","轩辕","东郭","南宫","百里","呼延","濮阳","澹台",
        "公冶","太史","申屠","公羊","仲孙","鲜于","亓官","谷梁",
        "左丘","梁丘","第五","南门","东门","西门","公良",
    ];

    /** @var string[] */
    public static array $prefixes = [
        "先生","女士","小姐","老师","医生","主席","总理","小","老",
    ];

    /** @var string[] */
    public static array $honors = [
        "博士",
    ];

    /**
     * @throws InvalidNameException
     */
    #[Override]
    public static function fromFullName(string $fullName, bool $shouldSanitize = true): static
    {
        $parts =  mb_str_split(parent::boot($fullName, $shouldSanitize)[0]);

        $fullName = implode('', $parts);

        $collectedPrefixes = self::extractPrefix($fullName) ;

        $nameLength = mb_strlen($fullName, 'UTF-8');

        if ($nameLength < 2) {
            throw InvalidNameException::from('Full name must be at least 2 characters long.');
        }

        // Detect surname (last name in Western mapping)
        $surname = null;
        $given = null;

        $firstTwo = mb_substr($fullName, 0, 2, 'UTF-8');
        $firstOne = mb_substr($fullName, 0, 1, 'UTF-8');


        if (in_array($firstTwo, static::$doubleSurnames, true)) {
            $surname = $firstTwo;
            $given = mb_substr($fullName, 2, null, 'UTF-8');
        } else {
            $surname = $firstOne;
            $given = mb_substr($fullName, 1, null, 'UTF-8');
        }

        // Split given name into first + middle (if 2 characters)
        $givenLength = mb_strlen($given, 'UTF-8');
        $firstName = null;
        $middleName = null;

        if ($givenLength === 1) {
            $firstName = $given;
        } elseif ($givenLength === 2) {
            $firstName = mb_substr($given, 0, 1, 'UTF-8');
            $middleName = mb_substr($given, 1, 1, 'UTF-8');
        } else {
            // Unusual case: treat as whole first name
            $firstName = $given;
        }

        return new static(
            firstName: $firstName,
            middleName: $middleName,
            lastName: $surname,
            prefix: $collectedPrefixes,
        );
    }

    public function sorted(): string
    {
        if ($this->last()) {
            // Format: LastName, FirstName MiddleName
            return $this->last() . ', ' . $this->first() . $this->middle();
        }

        // No last name: FirstName + MiddleName
        return $this->first() . $this->middle();
    }

    /**
     * @throws FormatNotSupportException
     */
    public function abbreviated(
        bool $includePrefix = false,
        bool $includeSuffix = false,
        bool $withDot = true,
        bool $strict = false,
        bool $removeParticles = false,
        Abbreviate $format = Abbreviate::Initials,
    ): string {
        throw FormatNotSupportException::from('Abbreviation not supported for CN names.');
    }

    /**
     * @throws PartNotSupportException
     */
    public function suffix(): ?string
    {
        throw PartNotSupportException::from('Suffixes not supported for CN names.');
    }

    /**
     * @return string[]|array
     */
    public function honours(): array
    {
        if (in_array($this->prefix(), static::getCommonHonorList(), true)) {
            return [$this->prefix()];
        }

        return [];
    }

    private static function extractPrefix(string &$fullName): ?string
    {
        $firstTwo = mb_substr($fullName, 0, 2, 'UTF-8');
        $firstOne = mb_substr($fullName, 0, 1, 'UTF-8');

        $lastTwo = mb_substr($fullName, -2, 2, 'UTF-8');
        $lastOne = mb_substr($fullName, -1, 1, 'UTF-8');

        $prefixList = array_merge(static::getCommonPrefixList(), static::getCommonHonorList());


        $collectedPrefixes = [];

        if (in_array($firstTwo, $prefixList, true)) {
            $collectedPrefixes[] = $firstTwo;
            $fullName = mb_substr($fullName, 2, null, 'UTF-8');
        }

        if (in_array($lastTwo, $prefixList, true)) {
            $collectedPrefixes[] = $lastTwo;
            $fullName = mb_substr($fullName, 0, -2, 'UTF-8');
        }

        if (in_array($firstOne, $prefixList, true)) {
            $collectedPrefixes[] = $firstOne;
            $fullName = mb_substr($fullName, 1, null, 'UTF-8');

        }

        if (in_array($lastOne, $prefixList, true)) {
            $collectedPrefixes[] = $lastOne;
            $fullName = mb_substr($fullName, 0, -1, 'UTF-8');

        }

        $prefixes =  implode("", $collectedPrefixes);

        return empty($prefixes) ? null : $prefixes;
    }
}
