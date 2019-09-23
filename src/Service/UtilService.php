<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Class UtilService
 * @package App\Service
 */
class UtilService
{
    /**
     * @var array
     */
    private $nameList;

    /**
     * @var integer
     */
    private $nameListSize;

    /**
     * UtilService constructor.
     */
    public function __construct()
    {
        $this->nameList = explode(',', $_ENV['HORSES_NAMES']);
        $this->nameListSize = count($this->nameList)-1;
    }

    /**
     * Generates a random horse nickname
     * @return string
     */
    public function getRandomHorseName(): string
    {
        $randIndex = mt_rand(0, $this->nameListSize);

        return $this->nameList[$randIndex];
    }

    /**
     * Generates a decimal random horse stat
     *
     * @param int $min
     * @param int $max
     * @return float
     */
    public function getRandomHorseStat(int $min, int $max): float
    {
        $factor = 10;
        return mt_rand($min * $factor, $max * $factor) / $factor;
    }
}