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
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @SuppressWarnings(PHPMD)
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('FrenchCom')
            ->setFaviconPath('img/favicon.svg')
            ->disableUrlSignatures()
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        /* yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
          yield  MenuItem::section('Links'),

        yield MenuItem::linkToCrud('Links', 'fas fa-list', LinkEntity::class); */

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Links');
        yield MenuItem::linkToCrud('Links', 'fa fa-tags', LinkEntity::class);
        yield MenuItem::section('Movies');

        yield MenuItem::linkToUrl('Search in Google', 'fab fa-google', 'https://google.com');
        yield MenuItem::linkToUrl('Search on Facebook', 'fab fa-facebook', 'https://facebook.com');
        yield MenuItem::linkToUrl('Search on YouTube', 'fab fa-youtube', 'https://youtube.com');
        yield MenuItem::section('Books');
        yield MenuItem::section('Series');
        yield MenuItem::section('Intertainments');
        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class)
            ->setBadge(13, 'primary');
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
        yield MenuItem::linkToExitImpersonation('Stop impersonation', 'fas fa-door-open');
    }

    /**
     * @SuppressWarnings(StaticAccess)
     */
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->displayUserName(false)
            ->setAvatarUrl('https://img1.freepng.es/20180425/csw/kisspng-computer-icons-emoticon-emoji-smiley-evil-5ae11c681c99e7.6968052915247023121172.jpg')
            ->addMenuItems([
                MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
            ]);
    }
}
