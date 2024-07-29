<?php

namespace App\Repository;

use App\Entity\WorkCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class WorkCategoryRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkCategory::class);
    }

    public function getRecentsWorkCategories(?int $maxResults = 1)
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.id', 'ASC')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult()
            ;
    }

}