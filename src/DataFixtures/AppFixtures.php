<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $hashedPassword = $this->userPasswordHasher->hashPassword($user, '1234567890');
        $user
            ->setName('OWE IHIOF')
            ->setFirstname('Stéphane')
            ->setEmail('oweihiof@gmail.com')
            ->setRoles(['ROLE_ADMIN_SYS'])
            ->setPassword($hashedPassword)
            ->setProfileImage('A-G-Engineering-Square-01.png')
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user);
        $manager->flush();
    }
}

