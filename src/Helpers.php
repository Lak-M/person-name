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
            return substr_replace($word, $replaceWith, -1);
        }

        return $word;
    }
}
