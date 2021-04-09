<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\HorseInRace;
use App\Entity\Race;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;

class RaceService
{
    public const ALLOWED_RACES = 3;
    public const MAX_DISTANCE = 1500.0;
    public const LAST_COMPLETED_RACES = 5;
    public const TOP_COMPLETED_AMOUNT = 3;
    public const PROGRESS_SECONDS = 10.0;

    private HorseInRaceService $horseInRaceService;

    private RaceRepository $raceRepository;

    private EntityManagerInterface $entityManager;

    public function __construct(HorseInRaceService $horseInRaceService, RaceRepository $raceRepository, EntityManagerInterface $entityManager)
    {
        $this->horseInRaceService = $horseInRaceService;
        $this->raceRepository = $raceRepository;
        $this->entityManager = $entityManager;
    }

    public function createRace(): void
    {
        if (count($this->raceRepository->getActiveRaces()) >= self::ALLOWED_RACES) {
            throw new \InvalidArgumentException('Only '.self::ALLOWED_RACES.' races are allowed at the same time.');
        }

        $race = new Race();
        $race->setActive(1);
        $race->setCreatedAt(new \DateTimeImmutable());
        $race->setMaxDistance(self::MAX_DISTANCE);
        $race->setDuration(0.0);

        try {
            $this->entityManager->persist($race);
            $horses = $this->horseInRaceService->getHorsesForRace();

            if (count($horses) == 0) {
                throw new \RuntimeException('Unable to create horses for race.');
            }

            foreach ($horses as $horse) {
                $this->entityManager->persist($horse);
                $this->entityManager->persist($this->horseInRaceService->createHorseInRace($race, $horse));
            }

            $this->entityManager->flush();
        } catch (\Throwable $e) {
            $this->entityManager->rollback();
            throw new \InvalidArgumentException($e->getMessage());
        }
    }

    public function getActiveRacesWithHorses(): array
    {
        $activeRaces = $this->raceRepository->getActiveRaces();
        $result = [];

        if (count($activeRaces) == 0) {
            return $result;
        }

        foreach ($activeRaces as $activeRace) {
            $result[] = [
                'race' => $activeRace,
                'horses' => $this->horseInRaceService->getHorsesRace($activeRace->getId()),
            ];
        }

        return $result;
    }

    public function getLastCompletedRacesWithHorses(): array
    {
        $completedRaces = $this->raceRepository->getFinishedRaces(self::LAST_COMPLETED_RACES);
        $result = [];

        if (count($completedRaces) == 0) {
            return $result;
        }

        foreach ($completedRaces as $completedRace) {
            $horses = array_slice(
                $this->horseInRaceService->getHorsesRace($completedRace->getId()),
                0,
                self::TOP_COMPLETED_AMOUNT
            );

            $result[] = [
                'race' => $completedRace,
                'horses' => $horses,
            ];
        }

        return $result;
    }

    public function getBestEverHorse(): ?HorseInRace
    {
        return $this->horseInRaceService->getBestEverHorse();
    }

    public function progressRaces(): void
    {
        $activeRaces = $this->raceRepository->getActiveRaces();

        if (0 === count($activeRaces)) {
            throw new \InvalidArgumentException('There are no active races at this moment.');
        }

        $this->entityManager->beginTransaction();

        try {
            foreach ($activeRaces as $activeRace) {
                $horses = $this->horseInRaceService->progressHorsesRace($activeRace, self::PROGRESS_SECONDS);

                foreach ($horses['horsesInRace'] as $horseInRace) {
                    $this->entityManager->persist($horseInRace);
                }

                // If all horses have completed the race
                if ($horses['completedRace']) {
                    $activeRace->setActive(0);
                    $activeRace->setCompletedAt(new \DateTimeImmutable());
                    $this->entityManager->persist($activeRace);
                }
            }

            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Throwable $e) {
            $this->entityManager->rollback();
            throw new \InvalidArgumentException($e->getMessage());
        }
    }
}