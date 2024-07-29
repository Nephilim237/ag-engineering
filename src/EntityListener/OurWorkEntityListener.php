<?php

namespace App\EntityListener;

use App\Entity\OurWork;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener('prePersist', entity: OurWork::class)]
#[AsEntityListener('preUpdate', entity: OurWork::class)]
class OurWorkEntityListener
{
    public function __construct(private readonly SluggerInterface $slugger)
    {

    }

    public function prePersist(OurWork $ourWork, LifecycleEventArgs $args): void
    {
        $ourWork->computeSlug($this->slugger);
    }

    public function preUpdate(OurWork $ourWork, LifecycleEventArgs $args): void
    {
        $ourWork->computeSlug($this->slugger);
    }
}