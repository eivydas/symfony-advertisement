<?php

namespace App\Repository;

use App\Entity\Advertisement;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AdvertisementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Advertisement::class);
    }

    public function findLatest(int $page = 1)
    {
        return $this->createQueryBuilder('a')
            ->where('a.publishedAt <= :now')
            ->andWhere('a.isActive = TRUE')
            ->orderBy('a.publishedAt', 'DESC')
            ->setMaxResults(50)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    public function findLatestByUser(User $user, int $page = 1)
    {
        return $this->createQueryBuilder('a')
            ->where('a.user = :user')
            ->orderBy('a.publishedAt', 'DESC')
            ->setMaxResults(50)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
