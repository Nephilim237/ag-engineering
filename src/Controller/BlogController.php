<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/blog/{slug}', name: 'blog_single')]
    public function single(Post $post, CategoryRepository $categoryRepository): Response
    {
        return $this->render('blog/single.html.twig', [
            'post' => $post,
            'categories' => $categoryRepository->getRecentsCategories(6)
        ]);
    }
}
