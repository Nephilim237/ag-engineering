<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog', methods: ['GET'])]
    public function index(PostRepository $postRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $paginatedPosts = $postRepository->getPaginatedPosts($request->query->getInt('p', 1), 4);
        return $this->render('blog/index.html.twig', [
            'paginatedPosts' => $paginatedPosts,
        ]);
    }

    #[Route('/blog/{slug}', name: 'blog_single', methods: ['GET'])]
    public function single(Post $post, CategoryRepository $categoryRepository): Response
    {
        return $this->render('blog/single.html.twig', [
            'post' => $post,
            'categories' => $categoryRepository->getRecentsCategories(6)
        ]);
    }
}
