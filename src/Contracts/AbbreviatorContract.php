<?php

declare(strict_types=1);

namespace Lakm\PersonName\Contracts;

abstract class AbbreviatorContract
{
    public function __construct(
        protected readonly string  $firstName,
        protected readonly ?string $middleName = null,
        protected readonly ?string $lastName = null,
        protected readonly ?string $prefix = null,
        protected readonly ?string $suffix = null,
        protected readonly bool    $withDot = true,
        protected readonly bool    $strict = false,
        protected readonly bool    $removeParticles = false,
    ) {}

    abstract public function abbreviate(): string;

    public function finalAbbreviation(string $abbreviation): string
    {
        $suffix = $this->getGenerationalSuffix($this->suffix);

        return ($this->prefix ? $this->prefix . ' ' : '') . $abbreviation . ($suffix ? ' ' . $suffix : '');
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
     * @return string[]
     */
    public function values(): array
    {
        return array_filter(array_values($this->toArray()));
    }

    /**
     * @param array<string|null>|string $parts
     * @return string
     * @throws \Exception
     */
    protected function getInitials(array|string $parts): string
    {
        $initials = [];

        if ( ! is_array($parts)) {
            $parts = [$parts];
        }

        $sanitizedParts = [];

        foreach ($parts as $part) {
            if (empty($part)) {
                continue;
            }

            if (str_word_count($part) > 1 && $this->removeParticles) {
                $tParts = explode(' ', $part);
                $filteredTParts = [];
                foreach ($tParts as $word) {
                    if ( ! in_array($word, NameBuilderContract::$commonParticles)) {
                        $filteredTParts[] = $word;
                    }
                }
                $sanitizedParts[] = implode(' ', $filteredTParts);
            } else {
                $sanitizedParts[] = $part;
            }
        }

        foreach ($sanitizedParts as $part) {
            // Split by spaces or hyphens
            if ( ! $this->strict) {
                $parts = preg_split('/[\s-]+/', $part);

                if (!$parts) {
                    throw new \Exception('Error occurred while splitting name part');
                }

                foreach ($parts as $p) {
                    $initials[] = mb_substr($p, 0, 1);
                }
            } else {
                $initials[] = mb_substr($part, 0, 1);
            }
        }

        // Output J.W or W
        return $this->withDot ? implode('. ', $initials) . '.' : implode('', $initials);
    }

    private static function getGenerationalSuffix(?string $suffix): string
    {
        if ( ! $suffix) {
            return '';
        }

        if (str_word_count($suffix) > 1) {
            $suffixes = explode(' ', $suffix);
        } else {
            $suffixes = [$suffix];
        }

        $collectedSuffixes = [];

        foreach ($suffixes as $s) {
            if (in_array($s, NameBuilderContract::$generationalSuffixes, true)) {
                $collectedSuffixes[] = $s;
            }
        }

        return implode(' ', $collectedSuffixes);
    }
}
