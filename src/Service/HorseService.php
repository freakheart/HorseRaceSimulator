<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Horse;
use InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HorseService
{
    public const BASE_SPEED = 5.0;
    public const ENDURANCE_FACTOR = 100.0;
    public const JOCKEY_SLOWDOWN = 5.0;
    public const STRENGTH_FACTOR = 0.08;

    private ValidatorInterface $validator;

    private UtilService $utilService;

    public function __construct(UtilService $utilService, ValidatorInterface $validator)
    {
        $this->utilService = $utilService;
        $this->validator = $validator;
    }

    public function createHorse(float $speed, float $strength, float $endurance): Horse
    {
        $horse = new Horse();
        $horse->setSpeed($speed);
        $horse->setStrength($strength);
        $horse->setEndurance($endurance);
        $horse->setName($this->utilService->getRandomHorseName());

        $horse->setBestSpeed($speed + self::BASE_SPEED);
        $horse->setAutonomy($endurance * self::ENDURANCE_FACTOR);
        $horse->setSlowdown(self::JOCKEY_SLOWDOWN - ($strength * self::STRENGTH_FACTOR * self::JOCKEY_SLOWDOWN));

        $errors = $this->validator->validate($horse);

        if (count($errors) > 0) {
            throw new InvalidArgumentException((string) $errors);
        }

        return $horse;
    }

    public function getHorseRealSpeed(Horse $horse, float $distance): float
    {
        if ($distance <= $horse->getAutonomy()) {
            return $horse->getBestSpeed();
        }

        return $horse->getBestSpeed() - $horse->getSlowdown();
    }
}
