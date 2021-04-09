<?php

declare(strict_types=1);

namespace App\Service;

use Nubs\RandomNameGenerator\All;

class UtilService
{
    public function getRandomHorseName(): string
    {
        $generator = All::create();

        return $generator->getName();
    }

    public function getRandomHorseStat(int $min, int $max): float
    {
        $factor = 10;

        return mt_rand($min * $factor, $max * $factor) / $factor;
    }
}
