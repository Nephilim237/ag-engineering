<?php

namespace App\EntityListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, entity: User::class)]
#[AsEntityListener(event: Events::preUpdate, entity: User::class)]
class UserEntityListener
{

    public function __construct(private readonly SluggerInterface $slugger)
    {

    }

    public function prePersist(User $user, LifecycleEventArgs $args): void
    {
        $user->computeSlug($this->slugger);
    }

    public function preUpdate(User $user, LifecycleEventArgs $args): void
    {
        $user->computeSlug($this->slugger);
    }
}