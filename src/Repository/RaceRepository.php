<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Race;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class RaceRepository.
 *
 * @method Race|null find($id, $lockMode = null, $lockVersion = null)
 * @method Race|null findOneBy(array $criteria, array $orderBy = null)
 * @method Race[]    findAll()
 * @method Race[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaceRepository extends ServiceEntityRepository
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    public function __construct(RegistryInterface $registry)
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
     * @param int    $maxResults
     * @param string $order
     *
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
