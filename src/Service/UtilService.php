<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Class UtilService.
 */
class UtilService
{
    /**
     * @var array
     */
    private $nameList;

    /**
     * UtilService constructor.
     */
    public function __construct()
    {
        $this->nameList = explode(',', $_ENV['HORSES_NAMES']);
    }

    /**
     * Generates a random horse nickname.
     *
     * @return string
     */
    public function getRandomHorseName(): string
    {
        array_rand($this->nameList);

        return array_pop($this->nameList);
    }

    /**
     * Generates a decimal random horse stat.
     *
     * @param int $min
     * @param int $max
     *
     * @return float
     */
    public function getRandomHorseStat(int $min, int $max): float
    {
        $factor = 10;

        return mt_rand($min * $factor, $max * $factor) / $factor;
    }
}
