<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HorseInRace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HorseInRace|null find($id, $lockMode = null, $lockVersion = null)
 * @method HorseInRace|null findOneBy(array $criteria, array $orderBy = null)
 * @method HorseInRace[]    findAll()
 * @method HorseInRace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HorseInRaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HorseInRace::class);
    }

    /**
     * @return HorseInRace[]
     */
    public function findAllHorsesInRace(int $raceId): array
    {
        return $this->createQueryBuilder('hr')
            ->addSelect('hr')
            ->andWhere('hr.race = :param1')
            ->setParameter('param1', $raceId)
            ->orderBy('hr.distanceCovered', 'DESC')
            ->addOrderBy('hr.timeSpent', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return HorseInRace[]
     */
    public function findBestEverTime(): array
    {
        return $this->createQueryBuilder('hr')
            ->innerJoin('hr.race', 'r')
            ->addSelect('hr')
            ->andWhere('r.active = :inactiveValue')
            ->setParameter('inactiveValue', RaceRepository::INACTIVE)
            ->orderBy('hr.timeSpent', 'ASC')
            ->getQuery()
            ->getResult();
    }
}