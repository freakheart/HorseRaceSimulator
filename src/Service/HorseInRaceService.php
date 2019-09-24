<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Horse;
use App\Entity\HorseInRace;
use App\Entity\Race;
use App\Repository\HorseInRaceRepository;

/**
 * Class HorseRaceService.
 */
class HorseInRaceService
{
    const MAX_HORSES_RACE = 8;
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
     * @var HorseInRaceRepository
     */
    private $horseRaceRepository;

    /**
     * HorseRaceService constructor.
     *
     * @param HorseService          $horseService
     * @param UtilService           $utilService
     * @param HorseInRaceRepository $horseRaceRepository
     */
    public function __construct(HorseService $horseService, UtilService $utilService, HorseInRaceRepository $horseRaceRepository)
    {
        $this->horseService = $horseService;
        $this->utilService = $utilService;
        $this->horseRaceRepository = $horseRaceRepository;
    }

    /**
     * Generates a set of horses for a race.
     *
     * @return array
     */
    public function getHorsesForRace(): array
    {
        $horses = [];

        for ($i = 0; $i < self::MAX_HORSES_RACE; ++$i) {
            $horses[] = $this->horseService->createHorse(
                $this->utilService->getRandomHorseStat(self::MIN_HORSE_STAT, self::MAX_HORSE_STAT),
                $this->utilService->getRandomHorseStat(self::MIN_HORSE_STAT, self::MAX_HORSE_STAT),
                $this->utilService->getRandomHorseStat(self::MIN_HORSE_STAT, self::MAX_HORSE_STAT)
            );
        }

        return $horses;
    }

    /**
     * Creates a HorseInRace entity object according to provided objects.
     *
     * @param Race  $race
     * @param Horse $horse
     *
     * @return HorseInRace
     */
    public function createHorseInRace(Race $race, Horse $horse): HorseInRace
    {
        $horseRace = new HorseInRace();
        $horseRace->setRace($race);
        $horseRace->setHorse($horse);
        $horseRace->setDistanceCovered(0);
        $horseRace->setTimeSpent(0);

        return $horseRace;
    }

    /**
     * @param int $raceId
     *
     * @return array
     */
    public function getHorsesRace(int $raceId): array
    {
        return $this->horseRaceRepository->findAllHorsesInRace($raceId);
    }

    /**
     * @return HorseInRace|null
     */
    public function getBestEverHorse(): ?HorseInRace
    {
        return $this->horseRaceRepository->findBestEverTime()[0] ?? null;
    }

    /**
     * @param Race  $race
     * @param float $progressSeconds
     *
     * @return array
     */
    public function progressHorsesRace(Race $race, float $progressSeconds): array
    {
        $horsesInRace = $this->horseRaceRepository->findAllHorsesInRace($race->getId());
        $completedHorsesCount = 0;

        foreach ($horsesInRace as $horseInRace) {
            $currentDistance = $horseInRace->getDistanceCovered();

            if ($currentDistance < $race->getMaxDistance()) {
                $horseAutonomy = $horseInRace->getHorse()->getAutonomy();
                $horseRealSpeed = $this->horseService->getHorseRealSpeed($horseInRace->getHorse(), $currentDistance);
                $calculatedDistance = $currentDistance + $horseRealSpeed * $progressSeconds;
                $calculatedSeconds = $horseInRace->getTimeSpent() + $progressSeconds;

                if ($calculatedDistance > $horseAutonomy && $currentDistance < $horseAutonomy) {
                    $gapMeters = $calculatedDistance - $horseAutonomy;
                    $gapSeconds = $gapMeters / $horseRealSpeed;
                    $horseRealSpeed = $this->horseService->getHorseRealSpeed($horseInRace->getHorse(), $calculatedDistance);
                    $calculatedDistance = $currentDistance + $gapSeconds * $horseRealSpeed;
                }

                if ($calculatedDistance > $race->getMaxDistance()) {
                    $gapMeters = $race->getMaxDistance() - $currentDistance;
                    $calculatedDistance = $currentDistance + $gapMeters;
                    $gapSeconds = $gapMeters / $horseRealSpeed;
                    $calculatedSeconds = $horseInRace->getTimeSpent() + $gapSeconds;
                }

                $horseInRace->setDistanceCovered(round($calculatedDistance, 2));
                $horseInRace->setTimeSpent(round($calculatedSeconds, 2));
            } else {
                ++$completedHorsesCount;
            }
        }

        return [
            'completedRace' => (self::MAX_HORSES_RACE === $completedHorsesCount),
            'horsesInRace' => $horsesInRace,
        ];
    }
}
