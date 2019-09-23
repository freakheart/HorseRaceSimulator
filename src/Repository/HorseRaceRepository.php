<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HorseRace;
use App\Helper\EntityManagerHelper;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class HorseRaceRepository
 * @package App\Repository
 *
 * @method HorseRace|null find($id, $lockMode = null, $lockVersion = null)
 * @method HorseRace|null findOneBy(array $criteria, array $orderBy = null)
 * @method HorseRace[]    findAll()
 * @method HorseRace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
Class HorseRaceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, HorseRace::class);
        EntityManagerHelper::ensureManager($this->getEntityManager());
    }

    /**
     * @param int $raceId
     * @return HorseRace[]
     */
    public function findAllHorsesByRace(int $raceId): array {
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
     * @return HorseRace[]
     */
    public function findBestEverTime(): array {
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