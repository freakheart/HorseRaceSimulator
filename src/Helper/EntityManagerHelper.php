<?php

declare(strict_types=1);

namespace App\Helper;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class EntityManagerHelper {
    public static function ensureManager(ObjectManager $manager): EntityManagerInterface {
        if (!$manager instanceof EntityManagerInterface) {
            throw new \RuntimeException();
        }

        if (false === $manager->getConnection()->ping() || !$manager->isOpen()) {
            $manager->getConnection()->close();
            $manager->getConnection()->connect();
        }

        return $manager;
    }
}
