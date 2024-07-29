<?php

namespace App\EntityListener;

use App\Entity\Category;
use App\Entity\WorkCategory;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, entity: WorkCategory::class)]
#[AsEntityListener(event: Events::preUpdate, entity: WorkCategory::class)]
class WorkCategoryEntityListener
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(WorkCategory $category, LifecycleEventArgs $args): void
    {
        $category->computeSlug($this->slugger);
    }

    public function preUpdate(WorkCategory $category, LifecycleEventArgs $args): void
    {
        $category->computeSlug($this->slugger);
    }

}