<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Race;
use App\Helper\EntityManagerHelper;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class RaceRepository
 * @package App\Repository
 *
 * @method Race|null find($id, $lockMode = null, $lockVersion = null)
 * @method Race|null findOneBy(array $criteria, array $orderBy = null)
 * @method Race[]    findAll()
 * @method Race[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
Class RaceRepository extends ServiceEntityRepository
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Race::class);
        EntityManagerHelper::ensureManager($this->getEntityManager());
    }

    /**
     * @return Race[]
     */
    public function getActiveRaces(): array {
        return $this->createQueryBuilder('r')
            ->andWhere('r.active = :activeValue')
            ->setParameter('activeValue', self::ACTIVE)
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $races
     * @return Race[]
     */
    public function getLastCompletedRaces(int $races): array {
        return $this->createQueryBuilder('r')
            ->andWhere('r.active = :inactiveValue')
            ->setParameter('inactiveValue', self::INACTIVE)
            ->orderBy('r.completedAt', 'ASC')
            ->setMaxResults($races)
            ->getQuery()
            ->getResult();
    }
}