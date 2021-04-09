<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Horse;
use App\Entity\HorseInRace;
use App\Entity\Race;
use App\Repository\HorseInRaceRepository;

class HorseInRaceService
{
    public const MAX_HORSES_RACE = 8;
    public const MIN_HORSE_STAT = 0;
    public const MAX_HORSE_STAT = 10;

    private HorseService $horseService;

    private UtilService $utilService;

    private HorseInRaceRepository $horseInRaceRepository;

    public function __construct(
        HorseService $horseService,
        UtilService $utilService,
        HorseInRaceRepository $horseInRaceRepository
    ) {
        $this->horseService = $horseService;
        $this->utilService = $utilService;
        $this->horseInRaceRepository = $horseInRaceRepository;
    }

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

    public function createHorseInRace(Race $race, Horse $horse): HorseInRace
    {
        $horseRace = new HorseInRace();
        $horseRace->setRace($race);
        $horseRace->setHorse($horse);
        $horseRace->setDistanceCovered(0);
        $horseRace->setTimeSpent(0);

        return $horseRace;
    }

    public function getHorsesRace(int $raceId): array
    {
        return $this->horseInRaceRepository->findAllHorsesInRace($raceId);
    }

    public function getBestEverHorse(): ?HorseInRace
    {
        return $this->horseInRaceRepository->findBestEverTime()[0] ?? null;
    }

    public function progressHorsesRace(Race $race, float $progressSeconds): array
    {
        $horsesInRace = $this->horseInRaceRepository->findAllHorsesInRace($race->getId());
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
