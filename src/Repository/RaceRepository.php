<?php

namespace App\Repository;

use App\Entity\Race;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Race|null find($id, $lockMode = null, $lockVersion = null)
 * @method Race|null findOneBy(array $criteria, array $orderBy = null)
 * @method Race[]    findAll()
 * @method Race[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaceRepository extends ServiceEntityRepository
{
    public const ACTIVE = 1;
    public const INACTIVE = 0;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Race::class);
    }

    /**
     * @return Race[]
     */
    public function getActiveRaces(): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.active = :activeValue')
            ->setParameter('activeValue', self::ACTIVE)
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Race[]
     */
    public function getFinishedRaces(int $maxResults, $order = 'ASC'): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.active = :inactiveValue')
            ->setParameter('inactiveValue', self::INACTIVE)
            ->orderBy('r.completedAt', $order)
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult();
    }
}
