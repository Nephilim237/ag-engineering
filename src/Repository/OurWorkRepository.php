<?php

namespace App\Repository;

use App\Entity\OurWork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OurWorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, OurWork::class);
    }

    public function getRecentsWorks(?int $maxResults = 1)
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.id', 'ASC')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult()
            ;
    }
}