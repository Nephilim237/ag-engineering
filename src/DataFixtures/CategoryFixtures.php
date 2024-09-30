<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture implements \Doctrine\Common\DataFixtures\DependentFixtureInterface
{

    public function __construct(private readonly PostRepository $postRepository, private readonly UserRepository $userRepository)
    {
    }
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $users = $this->userRepository->findAll();
        $categories = [];
        for ($i = 0; $i < 12; $i++){
            $category = new Category();

            $category->setTitle($faker->words(mt_rand(1, 3), true))
                ->setAuthor($users[mt_rand(0, count($users) - 1)])
                ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($category);
            $categories[] = $category;
        }

        $posts = $this->postRepository->findAll();
        foreach ($posts as $post){
            for ($p = 0; $p < mt_rand(0, 5); $p++){
                $post->addCategory($categories[mt_rand(0, count($categories) - 1 )]);
            }
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [PostFixtures::class, UserFixtures::class];
    }

}