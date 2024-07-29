<?php

namespace App\EntityListener;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(Events::preUpdate, entity: Service::class)]
#[AsEntityListener('prePersist', entity: Service::class)]
class ServiceEntityListener
{

    private readonly SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Service $service, LifecycleEventArgs $args): void
    {
        $service->computeSlug($this->slugger);
    }

    public function preUpdate(Service $service, LifecycleEventArgs $args): void
    {
        $service->computeSlug($this->slugger);
    }

}