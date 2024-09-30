<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {

    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, '1234567890');

            $user->setName($faker->lastName())
                ->setFirstname($faker->firstName())
                ->setEmail($faker->email())
                ->setPassword($password)
                ->setRoles($faker->randomElements(['ROLE_BOSS', 'ROLE_ADMIN_SYS', 'ROLE_EMPLOYEE'], 1))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($user);

        }

        $manager->flush();
    }
}