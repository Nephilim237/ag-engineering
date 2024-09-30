<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $users = $this->userRepository->findAll();

        for ($i = 0; $i < 100; $i++){
            $post = new Post();

            $dir = 'public/uploads/images/posts/';
            $post->setTitle($faker->realText(250))
                ->setContent('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                ->setCreatedAt(new \DateTimeImmutable())
                ->setPostImage($faker->image($dir, 360, 360, 'animals', false, true, null, true, 'png'))
                ->setAuthor($users[mt_rand(0, count($users) - 1)]);
            $manager->persist($post);
        }
        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}