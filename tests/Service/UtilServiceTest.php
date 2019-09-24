<?php

namespace App\Tests\Unit\Service;

use App\Service\UtilService;
use PHPUnit\Framework\TestCase;


class UtilServiceTest extends TestCase
{
    protected $utilService;

    protected function setUp()
    {
        $this->utilService = new UtilService();
    }

    public function testGetRandomHorseNameDistribution()
    {
        $names = [];

        // Testing the random distribution
        for ($n = 0; $n < 10; $n++) {
            $nickName = $this->utilService->getRandomHorseName();
            $names[$nickName] = 1;
        }

        // Making sure at least 10 different horse names
        $this->assertEquals(10, count($names));
    }

    public function testGetRandomHorseStatDistribution()
    {
        $min = 0;
        $max = 10;

        $this->assertIsFloat($this->utilService->getRandomHorseStat($min, $max));
    }

    protected function tearDown()
    {
        unset($this->utilService);
    }
}