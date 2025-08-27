<?php

declare(strict_types=1);

namespace Lakm\PersonName\NameBuilders;

use Lakm\PersonName\Enums\Gender;

class RU extends SimpleBuilder
{
    public function patronymic(): ?string
    {
        return $this->middle();
    }

    public function gender(): ?Gender
    {
        // 1. Patronymic check
        if ($this->patronymic()) {
            if (preg_match('/(ovich|evich)$/iu', $this->patronymic())) {
                return Gender::Male;
            }
            if (preg_match('/(ovna|evna)$/iu', $this->patronymic())) {
                return Gender::Female;
            }
        }

        // 2. Last name check
        if ($this->last()) {
            if (preg_match('/(ov|ev|in|sky)$/iu', $this->last())) {
                return Gender::Male;
            }
            if (preg_match('/(ova|eva|ina|skaya)$/iu', $this->last())) {
                return Gender::Female;
            }
        }

        // 3. First name dictionary (basic sample)
        $maleNames   = ['Dmitry','Sergey','Ivan','Alexey','Vladimir','Mikhail'];
        $femaleNames = ['Anna','Olga','Ekaterina','Natalia','Irina'];

        if ($this->middle()) {
            if (in_array($this->first(), $maleNames)) {
                return Gender::Male;
            }
            if (in_array($this->first(), $femaleNames)) {
                return Gender::Female;
            }
        }

        // Unknown
        return null;
    }

    public function fathersName(): ?string
    {
        // Remove common patronymic endings
        $base = preg_replace('/(ovich|evich|ovna|evna)$/iu', '', $this->patronymic() ?? '');

        if ( ! $base) {
            return null;
        }

        // Common normalization map
        $map = [
            "Dmitri"    => "Dmitry",
            "Alexandr"  => "Alexander",
            "Andre"     => "Andrei",
            "Nikola"    => "Nikolai",
            "Pavl"      => "Pavel",
            "Yakovl"    => "Yakov",   // Yakovlevich → Yakov
        ];

        foreach ($map as $wrong => $correct) {
            if (strcasecmp($base, $wrong) === 0) {
                return $correct;
            }
        }

        // Handle endings generically
        if (preg_match('/i$/', $base)) {
            return $base . 'y'; // Dmitri → Dmitry
        }

        // Default: capitalize first letter
        return ucfirst($base);
    }
}
