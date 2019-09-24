<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Horse;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class HorseRepository.
 *
 * @method Horse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Horse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Horse[]    findAll()
 * @method Horse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HorseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Horse::class);
    }
}
