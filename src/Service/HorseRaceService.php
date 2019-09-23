<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Horse;
use App\Entity\HorseRace;
use App\Entity\Race;
use App\Repository\HorseRaceRepository;

/**
 * Class HorseRaceService
 * @package App\Service
 */
class HorseRaceService
{
    const MAX_HORSES_BY_RACE = 8;
    const MIN_HORSE_STAT = 0;
    const MAX_HORSE_STAT = 10;

    /**
     * @var HorseService
     */
    private $horseService;

    /**
     * @var UtilService
     */
    private $utilService;

    /**
     * @var HorseRaceRepository
     */
    private $horseRaceRepository;

    /**
     * HorseRaceService constructor.
     * @param HorseService $horseService
     * @param UtilService $utilService
     * @param HorseRaceRepository $horseRaceRepository
     */
    public function __construct(HorseService $horseService, UtilService $utilService, HorseRaceRepository $horseRaceRepository)
    {
        $this->horseService = $horseService;
        $this->utilService = $utilService;
        $this->horseRaceRepository = $horseRaceRepository;
    }

    /**
     * Generates a set of horses for a race
     * @return array
     */
    public function generateHorsesForRace(): array
    {
        $horses = [];

        for ($h = 0; $h < self::MAX_HORSES_BY_RACE; ++$h) {
            $horses[] = $this->horseService->createHorse(
                $this->utilService->getRandomHorseStat(self::MIN_HORSE_STAT, self::MAX_HORSE_STAT),
                $this->utilService->getRandomHorseStat(self::MIN_HORSE_STAT, self::MAX_HORSE_STAT),
                $this->utilService->getRandomHorseStat(self::MIN_HORSE_STAT, self::MAX_HORSE_STAT)
            );
        }

        return $horses;
    }

    /**
     * Creates a HorseByRace entity object according to provided objects
     *
     * @param Race $race
     * @param Horse $horse
     * @return HorseRace
     */
    public function createHorseByRace(Race $race, Horse $horse): HorseRace
    {
        $horseByRace = new HorseRace();
        $horseByRace->setRace($race);
        $horseByRace->setHorse($horse);
        $horseByRace->setDistanceCovered(0);
        $horseByRace->setTimeSpent(0);

        return $horseByRace;
    }

    /**
     * @param int $raceId
     * @return array
     */
    public function getHorsesByRace(int $raceId): array
    {
        return $this->horseRaceRepository->findAllHorsesByRace($raceId);
    }

    /**
     * @return HorseRace|null
     */
    public function getBestEverHorse(): ?HorseRace
    {
        return $this->horseRaceRepository->findBestEverTime()[0] ?? null;
    }

    /**
     * @param Race $race
     * @param float $progressSeconds
     * @return array
     */
    public function progressHorsesByRace(Race $race, float $progressSeconds): array
    {
        $horsesRace = $this->horseRaceRepository->findAllHorsesByRace($race->getId());
        $completedHorsesCount = 0;

        foreach ($horsesRace as $horseRace) {
            $currentDistance = $horseRace->getDistanceCovered();

            // If the horse has not completed the race
            if ($currentDistance < $race->getMaxDistance()) {
                $horseAutonomy = $horseRace->getHorse()->getAutonomy();
                $horseRealSpeed = $this->horseService->getHorseRealSpeed($horseRace->getHorse(), $currentDistance);
                $calculatedDistance = $currentDistance + $horseRealSpeed * $progressSeconds;
                $calculatedSeconds = $horseRace->getTimeSpent() + $progressSeconds;

                // Validation to change speed when the horse reach its autonomy distance
                if ($calculatedDistance > $horseAutonomy && $currentDistance < $horseAutonomy) {
                    // Calculating gap meters between autonomy distance and calculated distance
                    $gapMeters = $calculatedDistance - $horseAutonomy;
                    // Calculating gap seconds between autonomy distance and calculated distance
                    $gapSeconds = $gapMeters / $horseRealSpeed;
                    $horseRealSpeed = $this->horseService->getHorseRealSpeed($horseRace->getHorse(), $calculatedDistance);
                    $calculatedDistance = $currentDistance + $gapSeconds * $horseRealSpeed;
                }

                // Fixing distance and time when calculated distance is greater than race's distance
                if ($calculatedDistance > $race->getMaxDistance()) {
                    $gapMeters = $race->getMaxDistance() - $currentDistance;
                    $calculatedDistance = $currentDistance + $gapMeters;
                    $gapSeconds = $gapMeters / $horseRealSpeed;
                    $calculatedSeconds = $horseRace->getTimeSpent() + $gapSeconds;
                }

                $horseRace->setDistanceCovered(round($calculatedDistance, 2));
                $horseRace->setTimeSpent(round($calculatedSeconds, 2));
            } else {
                $completedHorsesCount++;
            }
        }

        return [
            'completedRace' => ($completedHorsesCount === self::MAX_HORSES_BY_RACE),
            'horsesByRace'  => $horsesRace
        ] ;
    }
}