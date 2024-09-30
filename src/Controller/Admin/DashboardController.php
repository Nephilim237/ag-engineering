<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\HomeBanner;
use App\Entity\OurWork;
use App\Entity\Partner;
use App\Entity\Post;
use App\Entity\Prestation;
use App\Entity\Service;
use App\Entity\Testimony;
use App\Entity\User;
use App\Entity\WorkCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="logos/age-logo.png" alt="logo A-G-E"/>')
            ->setFaviconPath('favicon.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de Bord', 'fa fa-home');
        yield MenuItem::linkToCrud('Gestion Des Utilisateurs', 'fas fa-list', User::class);
        yield MenuItem::submenu('Gestion du blog', 'fa-solid fa-blog')->setSubItems([
            MenuItem::linkToCrud('Gérer Les Posts', 'fas fa-file-signature', Post::class),
            MenuItem::linkToCrud('Gérer Les Catégories', 'fas fa-tags', Category::class),
        ]);
        yield MenuItem::subMenu('Travaux et Ouvrages', 'fa-solid fa-paint-roller')->setSubItems([
            MenuItem::linkToCrud('Gestion des Ouvrages', 'fas fa-building', OurWork::class),
            MenuItem::linkToCrud('Type D\'Ouvrages', 'fas fa-briefcase', WorkCategory::class),
        ]);
        yield MenuItem::linkToCrud('Partenaires', 'fa-solid fa-handshake', Partner::class);
        yield MenuItem::linkToCrud('Services', 'fas fa-hands-helping', Service::class);
        yield MenuItem::linkToCrud('Prestations', 'fas fa-cogs', Prestation::class);
        yield MenuItem::linkToCrud('Bannières A La Une', 'fas fa-flag', HomeBanner::class);
        yield MenuItem::linkToCrud('Avis & Témoignages', 'fas fa-comments', Testimony::class);
        yield MenuItem::linkToUrl('Accueil', 'fas fa-home', $this->generateUrl('app_home'));
        yield MenuItem::linkToLogout('Déconnexion', 'fas fa-door-closed');
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addCssFile('assets/css/dashboard.css');
    }
}
