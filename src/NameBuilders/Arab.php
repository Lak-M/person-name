<?php

declare(strict_types=1);

namespace Lakm\PersonName\NameBuilders;

class Arab extends DefaultBuilder
{
    public static function fromFullName(string $fullName, bool $shouldSanitize = true): static
    {
        $parts = static::boot($fullName, $shouldSanitize);

        $collectedPrefixes = static::extractPrefixes($parts);
        $collectedSuffixes = static::extractSuffixes($parts);

        if (preg_match('/\b(ibn|bin|bint)\b/i', $fullName) && count($parts) > 4) {
            $parts = self::extractTraditionalNameParts($fullName);
            return new static($parts['first'], $parts['middle'], $parts['last'], $collectedPrefixes, $collectedSuffixes);
        }

        $parts = self::extractModernNameParts($fullName);
        return new static($parts['first'], $parts['middle'], $parts['last'], $collectedPrefixes, $collectedSuffixes);
    }

    /**
     * @param string $fullName
     * @return array{first: string, middle: ?string, last: ?string}
     */
    public static function extractTraditionalNameParts(string $fullName): array
    {
        $parts = explode(' ', trim($fullName));
        $firstName = array_shift($parts);


        // Find first nasab connector
        $nasabConnectors = ['ibn', 'bin', 'bint'];
        $connectorIndex = null;
        foreach ($parts as $i => $p) {
            if (in_array(mb_strtolower($p), $nasabConnectors)) {
                $connectorIndex = $i;
                break;
            }
        }

        $middleParts = [];
        $lastParts = [];

        if ($connectorIndex !== null) {
            if (isset($parts[$connectorIndex + 1])) {
                $mLength = 0;
                if (str_contains($parts[$connectorIndex + 1], '-')) {
                    // Middle name length
                    $mLength = $connectorIndex + 2;
                } else {
                    $mLength = $connectorIndex + 1;
                }

                $nextIndex = $mLength;

                $middleParts = array_slice($parts, 0, $mLength);
                $lastParts = array_slice($parts, $nextIndex);
            }

        } else {
            $middleParts = $parts;
            $lastParts = [];
        }

        $middleName = implode(' ', $middleParts) ?: null;
        $lastName = implode(' ', $lastParts) ?: null;

        return [
            'first' => $firstName,
            'middle' => $middleName,
            'last' => $lastName,
        ];
    }

    /**
     * @param string $fullName
     * @return array{first: string, middle: ?string, last: ?string}
     */
    public static function extractModernNameParts(string $fullName): array
    {
        $parts = static::clear($fullName);

        $firstName = array_shift($parts);
        $lastName = end($parts);
        $middleName = count($parts) > 1 ? implode(' ', array_slice($parts, 0, -1)) : null;

        return [
            'first' => (string) $firstName,
            'middle' => $middleName,
            'last' => (string) $lastName,
        ];
    }

    public function kunya(): ?string
    {
        $words = static::clear($this->fullName());

        if ( ! empty($words) && in_array(mb_strtolower($words[0]), ['abu', 'umm'])) {
            return $words[0] . ' ' . ($words[1] ?? null);
        }
        return null;
    }

    public function ism(): ?string
    {
        // If Kunya exists, Ism is usually after it
        $words = static::clear($this->fullName());

        if ( ! $this->kunya()) {
            return $words[0];
        }

        if (count($words) < 4) {
            return null;
        }

        if (in_array(mb_strtolower($words[0]), ['abu', 'umm'])) {
            return $words[2] ?? null;
        }

        return $this->first();
    }

    public function fatherName(): ?string
    {
        $words = static::clear($this->fullName());
        $words = array_map('strtolower', $words);

        // Traditional: look for ibn/bin/bint
        foreach ($words as $i => $w) {
            if (in_array($w, ['ibn', 'bin', 'bint'])) {
                if (in_array($words[$i + 1], ['abi', 'ali'])) {
                    return ucwords(implode(" ", array_slice($words, $i + 1)));
                }
                $fName = $words[$i + 1];
                return $fName ? ucfirst($fName) : null;
            }
        }

        // Modern: father is first part of middle name
        if ($this->middle()) {
            $parts = explode(' ', $this->middle());

            if ($this->kunya() && mb_strpos($this->kunya(), ucfirst($parts[0])) !== false) {
                return null;
            }

            return ucfirst($parts[0]);
        }

        return null;
    }

    public function grandfatherName(): ?string
    {
        $words = static::clear($this->fullName());

        $connectors = ['ibn', 'bin', 'bint'];
        $count = 0;

        // Traditional: find 2nd connector → grandfather = next token
        foreach ($words as $i => $token) {
            if (in_array(mb_strtolower($token), $connectors, true)) {
                $count++;
                if ($count === 2) {
                    return $words[$i + 1] ?? null;
                }
            }
        }

        // If we saw at least one connector but not two → no explicit grandfather given
        if ($count > 0) {
            return null;
        }

        // Modern fallback: middle block = full name minus first & last
        // Grandfather = 2nd token of middle block (if present)
        if (count($words) >= 4) {
            $middle = array_slice($words, 1, -1); // e.g., ["Mohammed","Ali"]
            return $middle[1] ?? null;            // e.g., "Ali"
        }

        return null;
    }

    public function nasab(): ?string
    {
        $words = static::clear($this->fullName());

        $nasabConnectors = ['ibn', 'bin', 'bint'];
        $nasabParts = [];

        $count = count($words);
        for ($i = 0; $i < $count; $i++) {
            $w = mb_strtolower($words[$i]);
            if (in_array($w, $nasabConnectors, true)) {
                $segment = [$words[$i]]; // start with connector
                // Collect following tokens until next connector or last token starting with 'al-'
                for ($j = $i + 1; $j < $count; $j++) {
                    if (in_array(mb_strtolower($words[$j]), $nasabConnectors, true)) {
                        break;
                    }
                    // If last token starts with al-, stop before it
                    if ($j === $count - 1 && str_starts_with(mb_strtolower($words[$j]), 'al-')) {
                        break;
                    }
                    $segment[] = $words[$j];
                }
                $nasabParts[] = implode(' ', $segment);
            }
        }

        return ! empty($nasabParts) ? implode(' ', $nasabParts) : null;
    }

    public function laqab(): ?string
    {
        $words = static::clear($this->fullName());

        if ( ! $words || count($words) < 2) {
            return null;
        }

        // Step 1: Special historical laqabs (optional)
        $specialLaqabs = [
            'Abu Hurairah' => 'Hurairah',
            'Abu Bakr' => 'Bakr',
            // add more if needed
        ];
        foreach ($specialLaqabs as $key => $value) {
            if (mb_stripos($this->fullName(), $key) !== false) {
                return $value;
            }
        }

        // Step 2: Kunya-based laqab
        // Look for Abu/Umm at start
        if (in_array(mb_strtolower($words[0]), ['abu', 'umm'], true)) {
            // Grab all tokens after Abu/Umm until the personal name (ism) or nasab connector
            $laqabTokens = [];
            for ($i = 1; $i < count($words); $i++) {
                $lower = mb_strtolower($words[$i]);
                if (in_array($lower, ['ibn', 'bin', 'bint'])) {
                    break; // stop before nasab
                }
                // Stop at first token that is likely the personal name?
                // We can assume ism follows laqab, take first token only
                $laqabTokens[] = $words[$i];
                break; // usually laqab is one token after Abu/Umm
            }
            return $laqabTokens[0] ?? null;
        }

        // Step 3: No laqab detected
        return null;


    }

    public function nisbah(): ?string
    {
        $words = static::clear($this->fullName());

        // Iterate **backwards** to find the last word starting with "al-"
        for ($i = count($words) - 1; $i >= 0; $i--) {
            if (str_starts_with(mb_strtolower($words[$i]), 'al-')) {
                return $words[$i];
            }
        }

        return null; // no nisbah found
    }

    public function family(): ?string
    {
        if ( ! $this->nisbah()) {
            return null;
        }

        $words = static::clear($this->fullName());

        for ($i = count($words) - 1; $i >= 0; $i--) {
            if (str_starts_with(mb_strtolower($words[$i]), 'al-')) {
                return $words[$i];
            }
        }

        // Step 2: fallback to last token
        return end($words) ?: null;
    }
}
