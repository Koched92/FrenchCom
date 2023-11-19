<?php

namespace App\Controller\Admin;

use App\Entity\LinkEntity;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController {
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return parent::index();;
    }

    public function configureDashboard(): Dashboard {
        return Dashboard::new()
            ->setTitle('FrenchCom')
            ->setFaviconPath('img/favicon.svg')
            ->disableUrlSignatures()
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable {
        /* yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
          yield  MenuItem::section('Links'),

        yield MenuItem::linkToCrud('Links', 'fas fa-list', LinkEntity::class); */

        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::section('Links'),
            MenuItem::subMenu('Links', 'fa fa-article')->setSubItems([
                MenuItem::linkToCrud('Links', 'fa fa-tags', LinkEntity::class),

            ]),
            MenuItem::section('Movies'),

            MenuItem::linkToUrl('Search in Google', 'fab fa-google', 'https://google.com'),
            MenuItem::linkToUrl('Search on Facebook', 'fab fa-facebook', 'https://facebook.com'),
            MenuItem::linkToUrl('Search on YouTube', 'fab fa-youtube', 'https://youtube.com'),
            MenuItem::section('Books'),
            MenuItem::section('Series'),
            MenuItem::section('Intertainments'),
            MenuItem::section('Users'),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class)
                ->setBadge(13, 'primary'),
            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            MenuItem::linkToExitImpersonation('Stop impersonation', 'fas fa-door-open'),

        ];
    }
    public function configureUserMenu(UserInterface $user): UserMenu {




        return parent::configureUserMenu($user)
        ->displayUserName(false)
        ->setAvatarUrl('https://img1.freepng.es/20180425/csw/kisspng-computer-icons-emoticon-emoji-smiley-evil-5ae11c681c99e7.6968052915247023121172.jpg')
        ->addMenuItems([
            MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
            MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
        ]);
    }
}
