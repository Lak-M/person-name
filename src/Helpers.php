<?php

declare(strict_types=1);

namespace Lakm\PersonName;

class Helpers
{
    public static function replaceLastLetter(string $word, string $lastLetter, string $replaceWith = ''): string
    {
        if (empty($word)) {
            return $word;
        }

        if (mb_substr($word, -1) === $lastLetter) {
            // Multi-byte safe replacement for last character
            return mb_substr($word, 0, mb_strlen($word) - 1) . $replaceWith;
        }

        return $word;
    }
}
