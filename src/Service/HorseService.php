<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Horse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class HorseService.
 */
class HorseService
{
    const BASE_SPEED = 5.0;
    const ENDURANCE_FACTOR = 100.0;
    const JOCKEY_SLOWDOWN = 5.0;
    const STRENGTH_FACTOR = 0.08;

    /**
     * @var UtilService
     */
    private $utilService;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * HorseService constructor.
     *
     * @param UtilService        $utilService
     * @param ValidatorInterface $validator
     */
    public function __construct(UtilService $utilService, ValidatorInterface $validator)
    {
        $this->utilService = $utilService;
        $this->validator = $validator;
    }

    /**
     * Creates a Horse entity object according to provided stats.
     *
     * @param float $speed
     * @param float $strength
     * @param float $endurance
     *
     * @return Horse
     */
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
            throw new \InvalidArgumentException((string) $errors);
        }

        return $horse;
    }

    /**
     * @param Horse $horse
     * @param float $distance
     *
     * @return float
     */
    public function getHorseRealSpeed(Horse $horse, float $distance): float
    {
        if ($distance <= $horse->getAutonomy()) {
            return $horse->getBestSpeed();
        }

        return $horse->getBestSpeed() - $horse->getSlowdown();
    }
}
