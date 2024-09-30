<?php

namespace App\Controller;

use App\Repository\HomeBannerRepository;
use App\Repository\OurWorkRepository;
use App\Repository\PartnerRepository;
use App\Repository\PostRepository;
use App\Repository\PrestationRepository;
use App\Repository\ServiceRepository;
use App\Repository\WorkCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HomeBannerRepository   $bannerRepository,
                          ServiceRepository      $serviceRepository,
                          PrestationRepository   $prestationRepository,
                          OurWorkRepository      $workRepository,
                          WorkCategoryRepository $workCategoryRepository,
                          PostRepository         $postRepository,
                          PartnerRepository      $partnerRepository):
    Response
    {
        $rawPartners = $partnerRepository->getRecentsPartners(10);
        //Separation du tableau rawPartners en sous tableau de 5 elements chacun
        $partners = array_chunk($rawPartners, 5);

        return $this->render('home/index.html.twig', [
            'banners' => $bannerRepository->getThreeLastBanner(3),
            'services' => $serviceRepository->getLastElements(2),
            'prestations' => $prestationRepository->getLastElements(4),
            'works' => $workRepository->getRecentsWorks(4),
            'workCategories' => $workCategoryRepository->getRecentsWorkCategories(4),
            'posts' => $postRepository->getRecentsPosts(2),
            'partners' => $partners,
        ]);
    }
}
